<?php

namespace ApcUsbStick\Subscriber;

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'onListing',            
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onCheckout',            
            'Shopware_Modules_Order_SaveOrder_FilterParams' => 'onSaveOrderFilter',           
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
  
     public function onSaveOrderFilter(\Enlight_Event_EventArgs $args)
     { 
         $session = Shopware()->Session();      
         $basketUsbArticle = $session->offsetGet('basketUsbArticle');
         
         if ($basketUsbArticle){
             $orderParams = $args->getReturn();
             $orderParams['dispatchID'] = '11';
             $args->setReturn($orderParams);
             $session->offsetSet('basketUsbArticle', false);
         }         
     }
      
    public function onListing(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $sArticles = $view->getAssign('sArticles');
        foreach ($sArticles as &$sArticle){
            if ($sArticle['sConfigurator']){
                $UsbArticle = $this->UsbArticle($sArticle['articleID']); 
                if ($UsbArticle){
                    $sArticle['usbArticle'] = true;
                }                
            }            
        }
        $view->assign('sArticles', $sArticles);
    }
    
    public function onCheckout(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $actionName = $request->getActionName();        
        
        if ($actionName == 'shippingPayment'){  
            $basketarticles = $view->getAssign('sBasket')['content'];
            
            $basketUsbArticle = $this->basketUsbArticle($basketarticles);            
            if ($basketUsbArticle){  
                //change_shipping.tpl
                $sDispatches = [ '11' => ['key' => '11', "id" => "11", "name" => "Versand per Deutsche Post", "description" => "Ihre USB Sticks, erhalten Sie innerhalb von 1-3 Werktagen", "calculation" => "2", "status_link" => "", 'attribute' => [] ]];
                $view->assign('sDispatches', $sDispatches);    
            }                    
        }     
        
        if ($actionName == 'confirm'){
            //for sOrder:saveOrder-filter
            $basketarticles = $view->getAssign('sBasket')['content'];
            $basketUsbArticle = $this->basketUsbArticle($basketarticles);    
            $session = Shopware()->Session();
            if ($basketUsbArticle){                 
                $session->offsetSet('basketUsbArticle', true);
            }else{
                $session->offsetSet('basketUsbArticle', false);
            }
        }
        
        if ($actionName == 'finish'){
            $basketarticles = $view->getAssign('sBasket')['content']; 
            if (empty($basketarticles)){
                $basketarticles = $view->getAssign('sBasketProportional')['content']; 
            }
            
            $basketUsbArticle = $this->basketUsbArticle($basketarticles); 
            if ($basketUsbArticle){
                //for finish.tpl 
                $sDispatch['name'] = "Versand per Deutsche Post";
                $view->assign('sDispatch', $sDispatch);
            }
        }        
    } 
    
    private function basketUsbArticle($basketarticles){
        $basketUsbArticle = false;
        foreach ($basketarticles as $basketarticle){  
            $basketUsbArticle[] = $basketarticle['articlename'];             
            if (strpos($basketarticle['articlename'], "USB-Stick") !== false){
                $basketUsbArticle = true;
                return true;
            }
        }        
    }
    
    private function UsbArticle($articleId){             
         $UsbOptions = Shopware()->Db()->fetchAll(
            'SELECT s_article_configurator_option_relations.option_id       
            FROM s_article_configurator_option_relations                
            WHERE s_article_configurator_option_relations.article_id = :articleId',
            ['articleId' => $articleId]
        );
        
        foreach ($UsbOptions as $UsbOption){
            if ($UsbOption['option_id'] == 14 || $UsbOption['option_id'] == 15){
                return true;
            }            
        }    
        return false;
    }
}














