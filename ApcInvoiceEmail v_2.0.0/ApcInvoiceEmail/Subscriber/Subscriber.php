<?php

namespace ApcInvoiceEmail\Subscriber;

use Enlight\Event\SubscriberInterface;
use ApcInvoiceEmail\Components\Sendinvoice;

class Subscriber implements SubscriberInterface
{
    /**
     * @var
     */
    private $pluginDirectory;  
    private $db;  
    private $session;  
    private $sendinvoice;  
    /**
     * @param $pluginDirectory
     */
    public function __construct($pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;
        $this->db = Shopware()->Db();
        $this->session = Shopware()->Session();
        $this->sendinvoice = new Sendinvoice();
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
            'Shopware_Modules_Order_SendMail_FilterContext' => 'onOrderSendMailFilterContext',
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
    
    //send invoice to iunvoice email from backend(admin panel)
    public function onOrderCreateMail(\Enlight_Event_EventArgs $args){
        
        $arrArgs = $args->getReturn();
        $email = $arrArgs['email'];

        if ($args->get('mailname') == 'document_invoice') {
            $sql = 'SELECT `invoice_email` FROM `s_user_attributes` 
                        LEFT JOIN `s_user` 
                        ON `s_user`.`id` = `s_user_attributes`.`userID`
                    WHERE `s_user`.`email` = ?';
            $invoiceEmail = $this->db->fetchRow($sql, [$email]);
            
            if (!$invoiceEmail){
                return;
            }
            
            $arrArgs['email'] = $invoiceEmail;            
            $args->setReturn($arrArgs);           
        }        
    }
    
    //add or update invoice email in register action
    public function onSaveRegister(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $request = $controller->Request();
        
        if(!$request->isPost() || $request->getParam('action') != 'saveRegister') {
            return;
        }   
        
        $this->updateInvoiceEmail($request->getParam('register')['invoice']['email']);
    }
    
    //add or update invoice email by editing account
    public function onFrontendAccount(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();   
        $userId = $this->session->offsetGet('sUserId');
                      
        $sql = 'SELECT `invoice_email` FROM `s_user_attributes` WHERE `userID` = ?';
        $invoiceEmail = $this->db->fetchOne($sql, [$userId]);
        $view->assign('invoiceEmail', $invoiceEmail);

        $companyUser = $this->db->fetchOne('SELECT `id` FROM `s_user_addresses` WHERE `user_id` = ? AND `company` IS NOT NULL', [$userId]);
        $view->assign('companyUser', $companyUser);

        if($request->getParam('action') == 'saveProfile'){
            $this->updateInvoiceEmail($request->getParam('invoice_email'));
        }
    }     
    
    //send invoice email after creating order in confirm-finish step
    public function onOrderSendMailFilterContext(\Enlight_Event_EventArgs $args){       
        $return = $args->getReturn();
        $orderDetailId = $return['sOrderDetails']['0']['orderDetailId'];

        $sql = "SELECT `s_order_details`.`id`,`s_order_details`.`orderID`, `s_order`.`userID`, `s_order`.`ordernumber`, `s_user`.`email`, `s_user_attributes`.`invoice_email`
            FROM `s_order_details` 
                LEFT JOIN `s_order`
                ON `s_order`.`id` = `s_order_details`.`orderID`
                LEFT JOIN `s_user`
                ON `s_user`.`id` = `s_order`.`userID`
                LEFT JOIN `s_user_attributes`
                ON `s_user_attributes`.`userID` = `s_user`.`id`
            WHERE `s_order_details`.`id` = ?";
        $data = $this->db->fetchRow($sql, [$orderDetailId]);
          
        if ($data['invoice_email']){
            $this->sendinvoice->Send($data);
        }        
    }

    private function updateInvoiceEmail($email){
        $userId = $this->session->offsetGet('sUserId');
        $profileinvoiceEmail = '';

        if ($email){
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                $profileinvoiceEmail = $email;
            }
        }            

        $sql = 'UPDATE s_user_attributes SET invoice_email = ? WHERE userID = ?';
        $this->db->query($sql, [$profileinvoiceEmail, $userId]);
    }    
}