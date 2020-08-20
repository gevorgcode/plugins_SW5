<?php

namespace genCookieConsentStyle\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\CacheManager;
use Shopware\Components\Plugin\ConfigReader;
use Shopware_Controllers_Backend_Config;

class Config implements SubscriberInterface
{
    /** @var string */
    private $pluginName;

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * Frontend constructor.
     * @param $pluginName
     * @param ConfigReader $configReader
     */
    public function __construct($pluginName, CacheManager $cacheManager)
    {
        $this->pluginName = $pluginName;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Config' => 'onPostDispatchConfig',
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     */
    public function onPostDispatchConfig(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Backend_Config $subject */
        $subject = $args->get('subject');
        $request = $subject->Request();

        // If this is a POST-Request, and affects our plugin, we may clear the config cache
        if($request->isPost() && $request->getParam('name') === $this->pluginName) {
            $this->cacheManager->clearTemplateCache();
            $this->cacheManager->clearThemeCache();
            $this->cacheManager->clearConfigCache();
            $this->cacheManager->clearHttpCache();
        }
    }
}
