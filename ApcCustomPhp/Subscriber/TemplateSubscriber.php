<?php

namespace ApcCustomPhp\Subscriber;

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Listing' => 'onFrontendListing',

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
        
        $SepaPay = false;
        $view->assign('SepaPay', $SepaPay);
        
        if (Shopware()->Modules()->Admin()->sCheckUser()){
            $userId = Shopware()->Session()->offsetGet('sUserId');
            $isCompany = Shopware()->Db()->fetchOne(
                'SELECT s_user_addresses.company AS company
                FROM s_user_addresses                
                WHERE s_user_addresses.user_id = :userId',
                ['userId' => $userId]
            );
            
            if (!$isCompany){                
                return;
            }
            
            $completedPayds = Shopware()->Db()->fetchAll(
                'SELECT s_order.id AS id
                FROM s_order                
                WHERE s_order.userID = :userId',
                ['userId' => $userId]
            );       
     
            $countCompletedPayds = count($completedPayds);                                 
            
            if ($countCompletedPayds < 4){                
                return;
            }
            
            $OrderSumm = Shopware()->Db()->fetchAll(
                'SELECT s_order.invoice_amount
                FROM s_order                
                WHERE s_order.userID = :userId',
                ['userId' => $userId]
            );  
            
            if (!$OrderSumm){
                return;
            }
            
            foreach ($OrderSumm as &$sum){
                $OrderSumm['summ'] = $OrderSumm['summ'] + $sum['invoice_amount'];                
            }
            
            if ($OrderSumm['summ'] < 1000){
                return;
            }
                        
            $SepaPay = true;
            
            $view->assign('SepaPay', $SepaPay);
            
        }
    }
    
    public function onFrontendListing(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
       
        $sArticles = $view->getAssign('sArticles');
        foreach ($sArticles as &$sArticle){
            $pieces = explode("?", $sArticle['linkDetails']);
            if ($pieces['0']){
                $sArticle['linkDetails'] = $pieces['0'];
            }
        }
        $view->assign('sArticles', $sArticles);
        
        if (count($sArticles) == 1){
            $Article = array_shift($sArticles);
            $url = $Article['linkDetails'];            
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $url");
            exit();            
        }
    }
}
