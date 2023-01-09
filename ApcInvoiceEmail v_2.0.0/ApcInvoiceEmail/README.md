This plugin writes for it-nerd24.de 01 jan 2023

Customer can add her invoice email during registration if customer type is account (not accountless) and B2B customer

Customer can add, update and remove invoice email in account overview page

We can add, update and remove invoice email from backend

During the order, if the client has an invoice email, he will receive an additional email with invoice to this email. 

The same email can be received anytime from Bestellstatus page

When we try to send invoice from backend, will be auto field this email

###
In this plugin used files from ApcLicenseStatus plugin

After installing this plugin add code 
  1. add str 240 in ApcLicenseStatus/ Controllers/ Frontend/ CheckLicense.php
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

        **$email = $Helper->getMailSendEmail($email);**
        
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
2. add this function  str 477-495 ApcLicenseStatus/Components/Helper.php
**public function getMailSendEmail($email){

        $sql = "SELECT `s_user_attributes`.`invoice_email` 
                FROM `s_user_attributes` 
                    LEFT JOIN `s_user`
                    ON `s_user`.`id` = `s_user_attributes`.`userID`
                WHERE `s_user`.`email` = :email";

        $invoiceEmail = Shopware()->Db()->fetchOne(
            $sql,
            [':email' => $email]
        ); 

        if ($invoiceEmail){
            $email = $invoiceEmail;
        }

        return $email;
    }**
