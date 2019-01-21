<?php
declare(strict_types=1);

namespace OCA\Datafari\Widgets;

use OCP\Dashboard\Model\WidgetSetup;
use OCP\Dashboard\Model\WidgetTemplate;
use OCP\Dashboard\IDashboardWidget;
use OCP\Dashboard\Model\IWidgetRequest;
use OCP\Dashboard\Model\IWidgetConfig;
use OCP\IL10N;
use OCA\Datafari\Service\DatafariService;

class DatafariWidget implements IDashboardWidget {
    
    const WIDGET_ID = 'datafari';
    
    /** @var IL10N */
    private $l10n;
    
    /** @var DatafariService */
    private $datafariService;
    
    public function __construct(IL10N $l10n, DatafariService $datafariService) {
        $this->l10n = $l10n;
        $this->datafariService = $datafariService;
    }
    
    /**
	 * @return string
	 */
	public function getId(): string {
		return self::WIDGET_ID;
    }
    
	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->l10n->t('Datafari');
    }

    /**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->l10n->t('Search with Datafari');
	}

    /**
	 * @return WidgetTemplate
	 */
	public function getWidgetTemplate(): WidgetTemplate {
		$template = new WidgetTemplate();
		$template//->addCss('widgets/materialize.min')
				 ->addCss('widgets/datafari')
				 ->addJs('widgets/materialize.min')
				 ->addJs('widgets/datafari')
				 ->setIcon('icon-datafari')
				 ->setContent('widgets/datafari')
				 ->setInitFunction('OCA.DashBoard.datafari.init');
		return $template;
    }
    
	/**
	 * @return WidgetSetup
	 */
	public function getWidgetSetup(): WidgetSetup {
		$setup = new WidgetSetup();
		$setup->addSize(WidgetSetup::SIZE_TYPE_MIN, 2, 1)
			  ->addSize(WidgetSetup::SIZE_TYPE_MAX, 4, 1)
			  ->addSize(WidgetSetup::SIZE_TYPE_DEFAULT, 4, 1);
		//$setup->addMenuEntry('OCA.DashBoard.fortunes.getFortune', 'icon-fortunes', 'New Fortune');
		//$setup->addDelayedJob('OCA.DashBoard.fortunes.getFortune', 300);
		//$setup->setPush('OCA.DashBoard.fortunes.push');
		return $setup;
    }
    
    /**
	 * @param IWidgetConfig $settings
	 */
	public function loadWidget(IWidgetConfig $settings) {
    }
    
	/**
	 * @param IWidgetRequest $request
	 */
	public function requestWidget(IWidgetRequest $request) {
		if ($request->getRequest() === 'search') {
            $request->addResult('results', $this->datafariService->search($request->getValue()));
		}
	}
    
}