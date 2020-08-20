<?php

namespace ApcListing\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Doctrine\DBAL\Connection;
use PDO;

class ListingSubscriber implements SubscriberInterface
{
    private $pluginDir = null;

    public function __construct($pluginBaseDirectory)
    {
        $this->pluginDir = $pluginBaseDirectory;
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Widgets_Listing' => 'onAjaxListing',
            'Enlight_Controller_Action_PreDispatch_Widgets_Listing' => 'onListingCount',
            'Enlight_Controller_Action_PostDispatch_Frontend' => 'onFrontendPostDispatch',
            'Enlight_Controller_Action_PostDispatch_Widgets' => 'onWidgetsPostDispatch',
            'Shopware_Controllers_Widgets_Listing_fetchListing_preFetch' => 'onPreFetchListing',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendPostDispatchBasket',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onCheckoutFinish',
        ];
    }
    
    public function onCheckoutFinish(\Enlight_Event_EventArgs $args) {
        
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();
        
        $actionName = $request->getActionName();
        
        if($actionName != 'finish'){
            return;
        }        
        
        $esdDetails = $view->getAssign('esd')['details'];
        
        foreach ($esdDetails as $esd){
            $articleIds[] = $esd['articleID'];
        }
        
        $query = $controller->get('dbal_connection')->createQueryBuilder();
        
        foreach($articleIds as $articleId){            
            $query->select('esd.id')
                ->from('s_articles_esd', 'esd')
                ->where('esd.articleID = :article_id')
                ->setParameter(':article_id', $articleId);
            $esdIds[] = $query->execute()->fetch(\PDO::FETCH_COLUMN);
        }            
        
        foreach ($esdIds as $esdId){
             $query->select('*')
            ->from('s_articles_esd_attributes', 'esd_attr')
            ->where('esd_attr.esdID = :esd_id')
            ->setParameter(':esd_id', $esdId);
        $esdAttrFinish[] =  $query->execute()->fetch(\PDO::FETCH_GROUP);
        }
        
        //used in theme checkout finish.tpl
        $view->assign('esdAttrFinish', $esdAttrFinish);    
       
    }
    
    
     public function onFrontendPostDispatchBasket(\Enlight_Event_EventArgs $args) {
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();
         
        $sBasket = Shopware()->Modules()->Basket()->sGetBasket(); 
        
        $view->sBasket = $sBasket;
    }

    public function onPreFetchListing(\Enlight_Event_EventArgs $args) {
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();
        if(empty($request->getParam('style'))){
            return;
        }
        $view->productBoxLayout = $request->getParam('style');
    }
    
    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onAjaxListing(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $actionName = $request->getActionName();
        $view = $controller->View();

        if($actionName != 'listingCount'){
            return;
        }
        
        if(empty($request->getParam('style'))){
            return;
        }
        
        
        $view->productBoxLayout = $request->getParam('style');
     }

    public function onFrontendPostDispatch(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();

        $view = $controller->View();
        $view->currency = Shopware()->Shop()->getCurrency();
    }

    public function onListingCount(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $actionName = $request->getActionName();

        if($actionName != 'listingCount'){
            return;
        }
        $request->setPost('currency',Shopware()->Shop()->getCurrency());
    }
    
    public function onWidgetsPostDispatch(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();

        $view = $controller->View();
        $view->currency = Shopware()->Shop()->getCurrency();
    }

}
