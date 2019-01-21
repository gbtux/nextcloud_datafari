<?php
namespace OCA\Datafari\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCA\Datafari\Service\DatafariService;
use OCP\IConfig;

/**
 * 
 */
class PageController extends Controller {
	
	private $userId;

	/** @var DatafariService */
	private $datafariService;
	
	/** @var IConfig */
    private $config;

	public function __construct($AppName, IRequest $request, $UserId, DatafariService $datafariService, IConfig $config){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
		$this->datafariService = $datafariService;
		$this->config = $config;
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index($search = null, $page=1, $languages=null, $types=null, $sources=null) {
		$r = null;
		$totalDocs = 0;
		if(null !== $search){
			$results = $this->datafariService->search($search, $page, $languages, $types, $sources);
			$resRetreated = str_replace('nextcloud(',"", $results);
			$resFinal = substr($resRetreated, 0, -1);
			$r = json_decode($resFinal);
			$totalDocs = $r->response->numFound;
		}
		
		//traitement des facets
		$facets = $this->getFacets($r->facet_counts);

		$parameters = [
			'results' => $r->response->docs,
			'facets' => $facets,
			'term' => $search,
			'currentPage' => $page,
			'totalDocs' => $totalDocs,
			'lastPage' => ceil($totalDocs/10),
			'adjacents' => 3
		];
		return new TemplateResponse('datafari', 'index', $parameters);  // templates/index.php
	}

	/** Set server URL (in admin) */
	public function settings($searchProxyUrl)
	{
		return $this->config->setAppValue('datafari', 'search_proxy_URL', $searchProxyUrl);
	}


	/*********************************************** PRIVATE  **********************************/
	private function getFacets($facets)
	{
		return [
			'fields' 	=> $this->getFacetFields($facets->facet_fields),
			'queries' 	=> $this->getFacetQueries($facets->facet_queries)
		];
	}

	private function getFacetFields($ffields)
	{
		$result = [];

		//Extension
		$tabExtension = $ffields->extension;
		$valuesExtension = [];
		$keysExtension = [];
		foreach($tabExtension as $key=>$ext) {
			$key % 2 == 0 ? $keysExtension[] = $ext : $valuesExtension[] = $ext;
		}
		$result['extensions'] = array_combine($keysExtension, $valuesExtension);

		//language
		$tabLanguage = $ffields->language;
		$valuesLanguage = [];
		$keysLanguage = [];
		foreach($tabLanguage as $key=>$ext) {
			$key % 2 == 0 ? $keysLanguage[] = $ext : $valuesLanguage[] = $ext;
		}
		$result['languages'] = array_combine($keysLanguage, $valuesLanguage);
		
		//sources
		$tabSource = $ffields->source;
		$valuesSource = [];
		$keysSource = [];
		foreach($tabSource as $key=>$ext) {
			$key % 2 == 0 ? $keysSource[] = $ext : $valuesSource[] = $ext;
		}
		$result['sources'] = array_combine($keysSource, $valuesSource);
		return $result;
	}

	private function getFacetQueries($fqueries)
	{
		
		$result = [];
		$dates = ["Moins de un mois","Moins de un an","Moins de cinq ans"];
		foreach ($fqueries as $key => $value) {
			if(in_array(urldecode($key),$dates)){
				$result['dates'][urldecode($key)] = $value;
			}else{
				$result['size'][urldecode($key)] = $value;
			}
		}
		return $result;
	}

}
