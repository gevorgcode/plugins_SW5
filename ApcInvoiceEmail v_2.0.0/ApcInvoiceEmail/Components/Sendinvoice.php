<?php

namespace ApcInvoiceEmail\Components;

use ApcLicenseStatus\Components\Constants;
use ApcLicenseStatus\Components\Helper;

class Sendinvoice{    

    /**
     * @var
     */
    private $session;  
    private $helper;  
    /**
     * @param $pluginDirectory
     */
    public function __construct()
    {
        $this->session = Shopware()->Session();
        $this->helper = new Helper();
    }

    public function Send($data){
        
        $invoice_link = Shopware()->Container()->get('router')->assemble(['controller'=>'Downinvoice','odid'=>$data['id'], 'oid' => $data['orderID'], 'uid' => $data['userID'], 'token' => $this->session->get('sessionId')]);  
        $orderParams = $this->helper->getOrderParamsByOrdernumber($data['ordernumber'], $data['email']);

        $context = ["sUser" => $orderParams['user'], "ordernumber" => $data['ordernumber'], "invoiceDownloadLink" => $invoice_link];        
        $mail = Shopware()->TemplateMail()->createMail(Constants::EMAIL_TEMPLATE_SEND_INVOICE, $context);       
        $mail->addTo($data['invoice_email']);

        try {
            $mail->send();
        } catch(\Exception $ex) {
           die($ex->getMessage());
        }         
    }
}