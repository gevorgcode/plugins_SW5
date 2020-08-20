<?php

namespace genCookieConsentStyle\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Template_Manager;
use Shopware\Components\DependencyInjection\Container;
use Shopware\Components\Plugin\ConfigReader;

class Template implements SubscriberInterface
{
    /** @var string */
    private $pluginBaseDirectory;

    /** @var Enlight_Template_Manager */
    private $templateManager;
    /**
     * Template constructor.
     * @param string $pluginBaseDirectory
     * @param Enlight_Template_Manager $templateManager
     */
    public function __construct(
        $pluginBaseDirectory,
        Enlight_Template_Manager $templateManager
    )
    {
        $this->pluginBaseDirectory = $pluginBaseDirectory;
        $this->templateManager = $templateManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch',
        ];
    }

    public function onPreDispatch()
    {
        $this->templateManager->addTemplateDir($this->pluginBaseDirectory . '/Resources/views');
    }
}
