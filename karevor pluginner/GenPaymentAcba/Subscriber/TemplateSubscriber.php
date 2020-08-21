<?php

namespace GenPaymentAcba\Subscriber;

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onFrontendCheckoutFinish',

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
    
    public function onFrontendCheckoutFinish(\Enlight_Event_EventArgs $args){        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        
        if ($request->getActionName() == 'finish'){
            
            $AcbaPayParams = $request->getParam('orderStatusExtended');
        
            if($AcbaPayParams['paymentAmountInfo']['paymentState'] != 'DEPOSITED'){
                $controller->redirect(['controller' => 'checkout', 'action' => 'cart', 'acbaPayParams' => http_build_query($AcbaPayParams)]);
            }

            $view->AcbaPayParams = $request->getParam('orderStatusExtended');
        } 
        
        if ($request->getActionName() == 'cart'){
            $responseFromPay = $request->getParam('responseFromPay');
            if ($responseFromPay){
                $view->responseFromPay = $responseFromPay;
            }
            $AcbaPayParams = $request->getParam('acbaPayParams');
            if ($AcbaPayParams){
                $view->AcbaPayParams = $AcbaPayParams;
            }
        }        
    }
}










