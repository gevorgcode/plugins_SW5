<?php

namespace ApcInvoiceEmail\Subscriber;

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Register' => 'onSaveRegister',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Account' => 'onFrontendAccount',
            'Shopware_Controllers_Backend_OrderState_Filter' => 'onOrderCreateMail',
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
    
    public function onOrderCreateMail(\Enlight_Event_EventArgs $args){
        
        $arrArgs = $args->getReturn();
        $subject = $arrArgs['subject'];
        $email = $arrArgs['email'];
        
        if ((strpos($subject, 'Invoice for order') !== false) || (strpos($subject, 'Ihre Unterlagen für Ihre Bestellung') !== false) || (strpos($subject, 'Your documents for your order') !== false)|| (strpos($subject, 'Vos documents pour votre commande') !== false)) {
            $sql = 'SELECT `id` FROM `s_user` WHERE `email` = ?';
            $userId = Shopware()->Db()->fetchOne($sql, [$email]);
            
            $sql = 'SELECT `invoice_email` FROM `s_user_attributes` WHERE `userID` = ?';
            $invoiceEmail = Shopware()->Db()->fetchOne($sql, [$userId]);
            
            if (!$invoiceEmail){
                return;
            }
            
            $arrArgs['email'] = $invoiceEmail;
            
            $args->setReturn($arrArgs);
           
        }
        
    }
    
    public function onSaveRegister(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        
        if(!$request->isPost()) {
            return;
        }
        
        if($request->getParam('action') != 'saveRegister'){
            return;
        }
        
        $invoiceEmail = $request->getParam('register')['invoice']['email'];
        $userId = Shopware()->Session()->offsetGet('sUserId');
        
        $sql = 'UPDATE s_user_attributes SET invoice_email = ? WHERE userID = ?';
        Shopware()->Db()->query($sql, [$invoiceEmail, $userId]);
    }
    
    public function onFrontendAccount(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();       
                      
        $userId = Shopware()->Session()->offsetGet('sUserId');        
        
        $sql = 'SELECT `invoice_email` FROM `s_user_attributes` WHERE `userID` = ?';
        $invoiceEmail = Shopware()->Db()->fetchOne($sql, [$userId]);
        $view->assign('invoiceEmail', $invoiceEmail);
        
        if($request->getParam('action') == 'saveProfile'){
            
            $profileinvoiceEmail = $request->getParam('invoice_email');
            
            if ($profileinvoiceEmail){
                $sql = 'UPDATE s_user_attributes SET invoice_email = ? WHERE userID = ?';
                Shopware()->Db()->query($sql, [$profileinvoiceEmail, $userId]);
            }         
        }
    }    
    
}














