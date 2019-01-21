<?php

namespace OCA\Datafari\Service;

use OCA\Dashboard\Service\ConfigService;
use OCA\Dashboard\Service\MiscService;
use OCP\IConfig;

class DatafariService {

    /** @var ConfigService */
    private $configService;

    /** @var MiscService */
    private $miscService;

    /** @var IConfig */
    private $config;


    /**
     * ProviderService constructor.
     *
     * @param ConfigService $configService
     * @param MiscService $miscService
     *
     */
    public function __construct(ConfigService $configService, MiscService $miscService, IConfig $config) {
            $this->configService = $configService;
            $this->miscService = $miscService;
            $this->config = $config;
    }

    /**
     * Search With a call of Datafari SearchAPI 
     */
    public function search($term, $page, $languages, $types, $sources)
    {
        $baseURL = $this->config->getAppValue('datafari', 'search_proxy_URL');
        //$baseURL = "http://demo.datafari.com/Datafari";
        $query = http_build_query([
            "q" => $term,
            "wt" => "json",
            "json.wrf" => "nextcloud",
            "id" => uniqid(),
            "fl" => "title,url,id,extension,preview_content",
            "facet" => "true",
            "rows" => "10",
            //others*/
            "sort" => "score desc",
            "q.op" => "AND",
            "spellcheck.collateParam.q.op" => "AND"
        ]);

        //fields NOTE : not working if facet.fields and facet.queries are directly in $query
        $query .= "&".http_build_query(["facet.field" => "{!ex=extension}extension"]);
        $query .= "&".http_build_query(["facet.field" => "{!ex=language}language"]);
        $query .= "&".http_build_query(["facet.field" => "{!ex=source}source"]);
        //queries
        $query .= "&".http_build_query(["facet.query" => "{!key=Moins%20de%20un%20mois}last_modified:[NOW-1MONTH TO NOW]"]);
        $query .= "&".http_build_query(["facet.query" => "{!key=Moins%20de%20un%20an}last_modified:[NOW-1YEAR TO NOW]"]);
        $query .= "&".http_build_query(["facet.query" => "{!key=Moins%20de%20cinq%20ans}last_modified:[NOW-5YEARS TO NOW]"]);
        $query .= "&".http_build_query(["facet.query" => "{!key=Moins%20de%20100ko}original_file_size:[0 TO 102400]"]);
        $query .= "&".http_build_query(["facet.query" => "{!key=De%20100ko%20%C3%A0%2010Mo}original_file_size:[102400 TO 10485760]"]);
        $query .= "&".http_build_query(["facet.query" => "{!key=Plus%20de%2010Mo}original_file_size:[10485760 TO *]"]);
        
        //gestion de la page
        if($page > 1) {
            $start = ($page -1) * 10;
            $query .= "&".http_build_query(["start" => $start]);
        }

        //facets
        //languages
        if( null !== $languages) {
            $tabLanguages = explode(",", $languages);
            if(count($tabLanguages)>1){
                //fq: {!tag=language}(language:en OR language:fr )
                $chaine = "language:" . $tabLanguages[0];
                for ($i=1; $i < count($tabLanguages); $i++) { 
                    $chaine .= " OR language:" . $tabLanguages[$i];
                }
                $query .= "&".http_build_query(["fq" => "{!tag=language}(".$chaine.")"]);
            }else{
                $query .= "&".http_build_query(["fq" => "{!tag=language}(language:" .$languages.")"]); //fq: {!tag=language}(language:en
            }
        }

        //types
        if( null !== $types) {
            $tabTypes = explode(",", $types);
            
            if(count($tabTypes)>1){
                //fq: {!tag=extension}(extension:doc OR extension:pdf )
                $chaine = "extension:" . $tabTypes[0];
                for ($i=1; $i < count($tabTypes); $i++) { 
                    $chaine .= " OR extension:" . $tabTypes[$i];
                }
                $query .= "&".http_build_query(["fq" => "{!tag=extension}(".$chaine.")"]);
            }else{
                $query .= "&".http_build_query(["fq" => "{!tag=extension}(extension:" .$types.")"]);
            }
        }

        //sources 
        if( null !== $sources) {
            $tabSources = explode(",", $sources);
            if(count($tabSources)>1){
                //fq: {!tag=source}(source:file )
                $chaine = "source:" . $tabSources[0];
                for ($i=1; $i < count($tabSources); $i++) { 
                    $chaine .= " OR source:" . $tabSources[$i];
                }
                $query .= "&".http_build_query(["fq" => "{!tag=source}(".$chaine.")"]);
            }else{
                $query .= "&".http_build_query(["fq" => "{!tag=source}(source:" .$sources.")"]);
            }
        }


        $url = $baseURL . "/SearchProxy/select?" . $query;
        return file_get_contents($url) ;
    }
}