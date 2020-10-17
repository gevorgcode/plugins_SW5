<?php

use ApcLicenseStatus\Components\Helper;
use ApcLicenseStatus\Components\Constants;

/**
 * Class Shopware_Controllers_Frontend_Gutschein
 */
class Shopware_Controllers_Frontend_CheckLicense extends Enlight_Controller_Action{
    
    public function indexAction(){

    }
    
    // get ordernumber or email, check it and send mail to email for validation
    public function sendValidateAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $param = $this->request()->getParam('ordernumber_or_email');
        if(!$param){
            return;
        }
        
        $type = null;
        $userEmail = null;
        $Helper = new Helper();
        
        $param = trim($param);
        $param = stripslashes($param);
        $param = htmlspecialchars($param);
        $param = str_replace(' ', '', $param);
        
        $at = strpos($param, '@');       
        if ($at){
            $type = 'email';
        }
        
        if(is_numeric($param)){
            $type = 'ordernumber';
        }
        
        if($type == 'email'){
            $CheckEmail = $Helper->checkEmailIsUser($param);
            if (!$CheckEmail){
                //email is not user
                return;
            }
            $userEmail = $param;
        }
        
        if($type == 'ordernumber'){            
            $userEmail = $Helper->getUserEmailByOrderNumber($param);
        }
        
        if (!$userEmail){
            //not correct email or ordernumber
            return;
        }
        
        if ($type == 'ordernumber'){
            $orderNumber = $param;
        }else{
            $orderNumber = null;
        }
        
        $token = Shopware()->Session()->get('sessionId');        
        $returnUrl = $_SERVER['HTTP_ORIGIN'] . '/CheckLicense/orderList?email=' . $userEmail . '&type=' . $type . '&orderNumber=' . $orderNumber . '&token=' . $token;
        
        $email = $userEmail;       
        $context = ["returnUrl" => $returnUrl];
        $mail = Shopware()->TemplateMail()->createMail(Constants::EMAIL_TEMPLATE_VALID, $context);       
        $mail->addTo($email);
      
        try {
            $mail->send();
        } catch(\Exception $ex) {
           die($ex->getMessage());
        }           
        
        //for back from invoicesent to orderlist
        $this->Response()->setCookie('ch_license_return_url', $returnUrl, time()+2000, '/' );               
        $this->forward('orderList', null, null, ['email' => $userEmail, 'verified' => 'no', 'type' => $type, 'orderNumber' => $orderNumber]);        
    }
    
    //get validation email, check tokens (session id)
    public function orderListAction(){        
        $params = $this->request()->getParams();        
        $email = $params['email'];
        $type = $params['type'];
        $orderNumber = $params['orderNumber'];
        $token = Shopware()->Session()->get('sessionId');
        $Helper = new Helper();
        
        //view assign email before verify
        if ($params['verified'] == 'no' && $params['email']){            
            $hideEmail = substr_replace($email, '***', 3, 3);
            $this->View()->assign('verified', 'no');
            $this->View()->assign('email', $email);
            $this->View()->assign('hideEmail', $hideEmail);
        }                
        //view assign email after verify
        elseif ($params['token'] && $params['email'] && $params['token'] == $token){            
            //type email
            if($type == 'email'){
                $this->View()->assign('verified', 'yes');
                $this->View()->assign('email', $email);
                $returnedParams = $Helper->getOrderParamsByEmail($email);   
                $orderDetails = $returnedParams['orderDetails'];
                $user = $returnedParams['user'];                
                $this->View()->assign('orderDetails', $orderDetails);
                $this->View()->assign('user', $user);
                $this->View()->assign('type', $type);                
                $this->View()->assign('token', $params['token']);                
                //type ordernumber
            }elseif($type == 'ordernumber'){
                $this->View()->assign('verified', 'yes');
                $this->View()->assign('email', $email);
                $returnedParams = $Helper->getOrderParamsByOrdernumber($orderNumber, $email);  
                $orderDetails = $returnedParams['orderDetails'];
                $user = $returnedParams['user'];                
                $this->View()->assign('orderDetails', $orderDetails);
                $this->View()->assign('user', $user);
                $this->View()->assign('type', $type);
                $this->View()->assign('token', $params['token']);
            }
        }else{
            $this->redirect([
                'action' => 'index',
            ]);
            return;
        }
    }
    
     public function invoiceDownloadAction(){
         $Helper = new Helper();
         $params = $this->request()->getParams(); 
         $hash = $params['hash'];
         $filename = $params['filename'];    
         $Helper->getInvoice($hash, $filename);
    }
    
    public function sendInvoiceAction(){        
        $params = $this->request()->getParams(); 
        $token = Shopware()->Session()->get('sessionId');
        if ($token != $params['token']){
            return;
        }
        
        $Helper = new Helper();
        $ordernumber = $params['onum'];
        $email = $Helper->getUserEmailByOrderNumber($ordernumber);
        $orderParams = $Helper->getOrderParamsByOrdernumber($ordernumber, $email);
        
        $context = ["sUser" => $orderParams['user'], "ordernumber" => $ordernumber, "invoiceDownloadLink" => $orderParams['orderDetails']['0']['0']['invoice_down_link']];        
        $mail = Shopware()->TemplateMail()->createMail(Constants::EMAIL_TEMPLATE_SEND_INVOICE, $context);       
        $mail->addTo($email);

        try {
            $mail->send();
        } catch(\Exception $ex) {
           die($ex->getMessage());
        } 
        $userIpCity = $Helper->getUserIpCity();
        $DbParams = ['email' => $email, 'ordernumber' => $ordernumber, 'order_detail_id' => '-', 'mail_type' => 'invoice', 'userIpCity' => $userIpCity];        
        $Helper->setParamsToDb($DbParams);
               
        $this->forward('invoiceSent', null, null, ['email' => $email, 'orderNumber' => $orderNumber]); 
    }
    
    public function invoiceSentAction(){      
        //tpl
    }
    
    public function sendLicenseAction(){        
        $params = $this->request()->getParams();         
        $token = Shopware()->Session()->get('sessionId');
        if ($token != $params['token']){
            return;
        }
         
        $Helper = new Helper();  
        $OrderPaymentStatus = $Helper->getOrderPaymentStatus($params['orderdetailsID']);    
        if (!($OrderPaymentStatus['status'] == 2 || $OrderPaymentStatus['cleared'] == 12)){            
            return;
        } 
              
        $orderDetails['esdDetails'] = $Helper->getEsdDetails($params['orderdetailsID']);
        $orderDetails['articleName'] = $Helper->getArticleNameByEsdId($orderDetails['esdDetails']['0']['esdID']); 
        $orderDetails['links'] = $Helper->getDownloadLinks($orderDetails['esdDetails']['0']['esdID']);
        $user = $Helper->getUser($orderDetails['esdDetails']['0']['userID']); 
        $links = $Helper->getTrueLinks($orderDetails['links']);         
        
        foreach ($orderDetails['esdDetails'] as &$orderDetail){           
           $orderDetail['esdSerial'] = $Helper->getSerial($orderDetail['serialID']);               
        }
        $articleName = $orderDetails['articleName']; 
        $esdDetails = $orderDetails['esdDetails'];       
        
        $context = ["user" => $user, "articleName" => $articleName, "esdDetails" => $esdDetails, "links" => $links];        
        $mail = Shopware()->TemplateMail()->createMail(Constants::EMAIL_TEMPLATE_SEND_LICENSE, $context);
        $email = $user['email']; 
        $mail->addTo($email);
         
        try {
            $mail->send();
        } catch(\Exception $ex) {
           die($ex->getMessage());
        }  
         
        $userIpCity = $Helper->getUserIpCity();
        $DbParams = ['email' => $email, 'ordernumber' => $params['onum'], 'order_detail_id' => $params['orderdetailsID'], 'mail_type' => 'license_key', 'userIpCity' => $userIpCity];        
        $Helper->setParamsToDb($DbParams);
        
        $this->forward('licenseSent', null, null, ['email' => $email]);  
    }   
    
    public function licenseSentAction(){      
        //tpl
    }
}




































