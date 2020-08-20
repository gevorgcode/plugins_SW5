<?php

namespace GenCustomBannerslider\Subscriber;

use Enlight\Event\SubscriberInterface;
//use Shopware\Components\Random;


class GenCustomBannersliderSubscriber implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;
    
    /**
     * @var \Enlight_Template_Manager
     */
    private $templateManager;

   /**
     * @param $pluginDirectory
     * @param \Enlight_Template_Manager $templateManager
     */
    public function __construct(string $pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;        
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onCollectedTemplates',
            'Enlight_Controller_Action_PostDispatchSecure' => 'onPostdispatch',
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'onPostdispatchFrontend',
        ];
    }
     /**
     * @param \Enlight_Event_EventArgs $args
     */
    public function onCollectedTemplates(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->get('subject');
        $view = $controller->View();
        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');
    }
    
      /**
     * @param \Enlight_Event_EventArgs $args
     */
    public function onPostdispatch(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->get('subject');
        $request = $controller->Request();
        $view = $controller->View();
        
//        for product slider item min-width
        $sliderItemMinWidth = 250;
        $view->sliderItemMinWidth = $sliderItemMinWidth;
//
        
        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('GenCustomBannerslider');
        
        //global
        $view->showdots = $config['showdots'];
        $view->displayarrows = $config['displayarrows'];
        $view->autoslide = $config['autoslide'];
        $view->rotspeed = $config['rotspeed'];
    }

}















