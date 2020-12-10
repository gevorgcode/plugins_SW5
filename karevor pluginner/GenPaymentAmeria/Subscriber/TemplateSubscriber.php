<?php

namespace GenPaymentAmeria\Subscriber;

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
            
            
            $PaymentDetails = $request->getParam('PaymentDetails');
            parse_str($PaymentDetails, $AmeriaPayParams);
        
            if($AmeriaPayParams['ResponseCode'] != '00'){
                $controller->redirect(['controller' => 'checkout', 'action' => 'cart', 'ameriaPayParams' => http_build_query($AmeriaPayParams)]);
            }

            $view->AmeriaPayParams = $AmeriaPayParams;
        } 
        
        if ($request->getActionName() == 'cart'){
            $responseFromPay = $request->getParam('responseFromPay');            
            if ($responseFromPay){
                parse_str($responseFromPay, $responseFromPay);                
                $view->responseFromPay = $responseFromPay;
            }
            $AmeriaPayParams = $request->getParam('ameriaPayParams');                       
            if ($AmeriaPayParams){
                parse_str($AmeriaPayParams, $AmeriaPayParams);
                $view->AmeriaPayParams = $AmeriaPayParams;
            }
        }        
    }
}










