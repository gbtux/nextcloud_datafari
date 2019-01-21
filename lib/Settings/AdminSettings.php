<?php

namespace OCA\Datafari\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\Settings\ISettings;
use OCP\IConfig;

/**
 * 
 */
class AdminSettings implements ISettings
{
    /** @var IConfig */
    private $config;

    /**
     * 
     */
    public function __construct(IConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Print config section
     *
     * @return TemplateResponse
     */
    public function getForm() 
    {
        $searchProxyURL = $this->config->getAppValue('datafari', 'search_proxy_URL');    

        $params = [
            'search_proxy_URL' => $searchProxyURL
        ];
        return new TemplateResponse('datafari', 'admin', $params);
    }

    /**
         * @return string the section ID, e.g. 'sharing'
         */
        public function getSection() {
            return 'additional';
    }

    /**
     * @return int whether the form should be rather on the top or bottom of
     * the admin section. The forms are arranged in ascending order of the
     * priority values. It is required to return a value between 0 and 100.
     *
     * keep the server setting at the top, right after "server settings"
     */
    public function getPriority() {
            return 0;
    }

}
