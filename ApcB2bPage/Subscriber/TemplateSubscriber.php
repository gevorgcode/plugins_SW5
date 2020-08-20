<?php

namespace ApcB2bPage\Subscriber;

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Forms' => 'onFrontendForms',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontend',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Custom' => 'onFrontendCustom',
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

     public function onFrontendForms(\Enlight_Event_EventArgs $args) {
         $controller = $args->getSubject();
         $view = $controller->View();
         $request = $controller->Request();
         $actionName = $request->getActionName();
    
         if (($actionName != 'index')){
             return;
         }
     }
    public function onFrontend(\Enlight_Event_EventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        if (!Shopware()->Modules()->Admin()->sCheckUser()){
            return;
        }
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
        
        $isCompanyActive = Shopware()->Db()->fetchOne(
            'SELECT s_user.active
            FROM s_user              
            WHERE s_user.id = :userId',
            ['userId' => $userId]
        );
        
        if (!$isCompanyActive){
            return;
        }
        
        $CompPaids = Shopware()->Db()->fetchAll(
            'SELECT s_order.invoice_amount
            FROM s_order              
            WHERE s_order.userID = :userId
            AND s_order.status = 2',
            ['userId' => $userId]
        );
        
        $CompPaidVal = 0;
        foreach ($CompPaids as $CompPaid){
            $CompPaidVal = $CompPaidVal + $CompPaid['invoice_amount'];
        }
        
        $CompOrders = Shopware()->Db()->fetchAll(
            'SELECT s_order.invoice_amount
            FROM s_order              
            WHERE s_order.userID = :userId
            AND s_order.cleared = 12
            AND s_order.status != 2',
            ['userId' => $userId]
        );
        
        $CompOrderVal = 0;
        foreach ($CompOrders as $CompOrder){
            $CompOrderVal = $CompOrderVal + $CompOrder['invoice_amount'];
        }
        
        $compVal = $CompPaidVal + $CompOrderVal;
        
        if ($compVal < 1000){
            $B2bStatus = 'nostatus';
            $procent = $compVal/10;
        }else if($compVal >= 1000 && $compVal < 85000){
            $B2bStatus = 'bronze';
            $procent = 100 - ((85000 - $compVal) / 840);
        }else if($compVal >= 85000 && $compVal < 250000){
            $B2bStatus = 'silver';
            $procent = 100 - ((250000 - $compVal) / 1650);
        }else if ($compVal >= 250000){
            $B2bStatus = 'gold';
        }
        
        $sql = "UPDATE `s_user_attributes` SET `b2b_status`= ? WHERE `userID` = ?;";
        $db = Shopware()->Db();
        $db->query($sql, [$B2bStatus, $userId]);
 
        $view->assign('B2bStatus', $B2bStatus);        
        $view->assign('procent', $procent);        
    }
    
    public function onFrontendCustom(\Enlight_Event_EventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $sCustom = $request->getParam('sCustom');
        if ($sCustom != '76'){
            return;
        }
    }
}
