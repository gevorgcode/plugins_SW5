<?php

namespace ApcHttpPass\Subscriber;

use Enlight\Event\SubscriberInterface;

class TemplateSubscriber implements SubscriberInterface
{
    /**
     * @var
     */
    private $pluginDirectory;  
    /**
     * @param $pluginDirectory
     */
    public function __construct($pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Inheritance_Template_Directories_Collected' => 'onCollectTemplateDirs',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendDebit',

        ];
    }    
     /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onCollectTemplateDirs(\Enlight_Event_EventArgs $args) {
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDirectory . '/Resources/views';
        return $dirs;
    }
    
    public function onFrontendDebit(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $response = $controller->Response();
        $CookieVerify = $request->getCookie('verify');
        
//        if ($_SERVER['HTTP_HOST'] == 'license-now.de' || $_SERVER['HTTP_HOST'] == 'license-now.at'){
//            return;
//        }
        
        //if($_SERVER['HTTP_HOST'] == 'license-now.ch'){
            if (!$CookieVerify && (!$request->getParam('controller') == 'httppassverify')){
                $controller->redirect([
                    'controller' => 'httppassverify',
                    'action' => 'index',
                ]);
            }
        //}
                  
    }
}
