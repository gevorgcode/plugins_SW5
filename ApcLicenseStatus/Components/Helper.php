<?php

namespace ApcLicenseStatus\Components;

use Doctrine\DBAL\Connection;
use PDO;
use Shopware\Components\Random;
use DateTime;

class Helper{
    
    public function getUserEmailByOrderNumber($param){
        $userId = Shopware()->Db()->fetchOne(
            'SELECT userID
            FROM s_order                
            WHERE s_order.ordernumber = :param',
            ['param' => $param]
        ); 
        
        $userEmail = Shopware()->Db()->fetchOne(
            'SELECT email
            FROM s_user               
            WHERE s_user.id = :userId',
            ['userId' => $userId]
        ); 
        if (!$userEmail){
            return false;
        }
        return $userEmail;
    }
    
    public function checkEmailIsUser($param){
        $userEmail = Shopware()->Db()->fetchOne(
            'SELECT id
            FROM s_user               
            WHERE s_user.email = :email',
            ['email' => $param]
        ); 
        
        if (!$userEmail){
            return false;
        }
        return $userEmail;
    }
    
    public function getOrderParamsByEmail($email){
        $user = Shopware()->Db()->fetchRow(
            'SELECT *
            FROM s_user               
            WHERE s_user.email = :email',
            ['email' => $email]
        ); 
        
        $orderIds = Shopware()->Db()->fetchAll(
            'SELECT id
            FROM s_order                
            WHERE s_order.userID = :userID',
            ['userID' => $user['id']]
        ); 
        
        $modules =Shopware()->Modules()->Order();
        foreach($orderIds as &$orderId){      
            $orderIdId = $orderId['id'];
            $orderDetails[] = $modules->getOrderDetailsByOrderId($orderId['id']);           
        }       
        $orderDetails = array_reverse($orderDetails);        
        foreach ($orderDetails as &$details){            
            foreach($details as &$detail){
                $detail['s_order'] = $modules->getOrderById($detail['orderID']);                
                $detail['s_order_documents'] = $this->getOrderDocumentsByOrderId($detail['orderID']);
                $detail['esddetails'] = $this->getEsdDetails($detail['orderdetailsID']);                
                foreach ($detail['esddetails'] as &$esddetail){                    
                    $esddetail['serial'] = $this->getSerial($esddetail['serialID']);
                }                
                $detail['invoice_down_link'] = $this->getInvoiceLink($detail['s_order_documents']['hash'], $detail['s_order_documents']['docID']);                
                $detail['esdDownload'] = $this->getDownloadLinks($detail['esddetails']['0']['esdID']);                
            }           
        }        
        $returnedParams = ['orderDetails' => $orderDetails, 'user' => $user];
        return $returnedParams;
    }
    
     public function getOrderParamsByOrdernumber($orderNumber, $email){
         $user = Shopware()->Db()->fetchRow(
            'SELECT *
            FROM s_user               
            WHERE s_user.email = :email',
            ['email' => $email]
         ); 
         
         $orderId = Shopware()->Db()->fetchOne(
            'SELECT id
            FROM s_order               
            WHERE s_order.ordernumber = :ordernumber',
            ['ordernumber' => $orderNumber]
        ); 
         
        $modules =Shopware()->Modules()->Order();                 
        $orderDetails[] = $modules->getOrderDetailsByOrderId($orderId);
        
        foreach ($orderDetails as &$details){            
            foreach($details as &$detail){
                $detail['s_order'] = $modules->getOrderById($detail['orderID']);                
                $detail['s_order_documents'] = $this->getOrderDocumentsByOrderId($detail['orderID']);
                $detail['esddetails'] = $this->getEsdDetails($detail['orderdetailsID']);                
                foreach ($detail['esddetails'] as &$esddetail){                    
                    $esddetail['serial'] = $this->getSerial($esddetail['serialID']);
                }    
                $detail['invoice_down_link'] = $this->getInvoiceLink($detail['s_order_documents']['hash'], $detail['s_order_documents']['docID']);
                $detail['esdDownload'] = $this->getDownloadLinks($detail['esddetails']['0']['esdID']);
            }
        }
        $returnedParams = ['orderDetails' => $orderDetails, 'user' => $user];
        return $returnedParams;          
    }
    
    public function getEsdDetails($orderdetailsID){
        return Shopware()->Db()->fetchAll(
            'SELECT *
            FROM s_order_esd             
            WHERE s_order_esd.orderdetailsID = :orderdetailsID',
            ['orderdetailsID' => $orderdetailsID]
        ); 
    }
    
    public function getSerial($serialId){
        return Shopware()->Db()->fetchOne(
            'SELECT serialnumber
            FROM s_articles_esd_serials             
            WHERE s_articles_esd_serials.id = :serialId',
            ['serialId' => $serialId]
        ); 
    }
    
    private function getOrderDocumentsByOrderId($orderID){
        return Shopware()->Db()->fetchRow(
            'SELECT *
            FROM s_order_documents             
            WHERE s_order_documents.orderID = :orderID',
            ['orderID' => $orderID]
        ); 
    }    
    
    public function getDownloadLinks($esdID){
        return Shopware()->Db()->fetchRow(
            'SELECT *
            FROM s_articles_esd_attributes             
            WHERE s_articles_esd_attributes.esdID = :esdID',
            ['esdID' => $esdID]
        );         
    }
    
    private function getInvoiceLink($hash, $filename){
        
        $mainShop = Shopware()->Db()->fetchRow(
            'SELECT *
            FROM s_core_shops             
            WHERE s_core_shops.default = :default',
            ['default' => 1]
        ); 
        
        if ($mainShop['secure'] == 0){
            $urlPart1 = 'http://';
        }else{
            $urlPart1 = 'https://';
        }
        
        return $urlPart1 . $mainShop['host'] . "/CheckLicense/invoiceDownload?hash=$hash&filename=$filename";                
    }
    
    public function getInvoice($hash, $filename){
        $filepath = Shopware()->Container()->get('kernel')->getRootDir() . '/files/documents/' . $hash . '.pdf';
        $filesize = filesize($filepath);
        header('Content-Type: application/pdf; charset=UTF-8');
        header('Content-Disposition: attachment; filename="'.$filename.'.pdf"');
        header("Content-Length: $filesize");

        echo file_get_contents($filepath);
        die();         
    }
    
    public function getUser($userId){
        return Shopware()->Db()->fetchRow(
            'SELECT *
            FROM s_user               
            WHERE s_user.id = :userId',
            ['userId' => $userId]
        );      
    }
    
    public function getArticleNameByEsdId($esdId){
        $articleId = Shopware()->Db()->fetchOne(
            'SELECT articleID
            FROM s_articles_esd               
            WHERE s_articles_esd.id = :esdId',
            ['esdId' => $esdId]
        );     
        return Shopware()->Db()->fetchOne(
            'SELECT name
            FROM s_articles             
            WHERE s_articles.id = :articleId',
            ['articleId' => $articleId]
        );        
    }
    
    public function getOrderPaymentStatus($orderdetailsID){
        $orderId = Shopware()->Db()->fetchOne(
            'SELECT orderID
            FROM s_order_details               
            WHERE s_order_details.id = :orderdetailsID',
            ['orderdetailsID' => $orderdetailsID]
        );    
        return Shopware()->Db()->fetchRow(
            'SELECT status, cleared
            FROM s_order            
            WHERE s_order.id = :orderId',
            ['orderId' => $orderId]
        );        
    }
    
    public function getTrueLinks($orderDetailsLinks){
        $download['0']['link'] = $orderDetailsLinks['file_1']; 
        $download['1']['link'] = $orderDetailsLinks['file_2']; 
        $download['2']['link'] = $orderDetailsLinks['file_3']; 
        $download['3']['link'] = $orderDetailsLinks['file_4']; 
        $download['4']['link'] = $orderDetailsLinks['file_5']; 
        $download['5']['link'] = $orderDetailsLinks['file_6']; 
        $download['6']['link'] = $orderDetailsLinks['file_7']; 
        $download['7']['link'] = $orderDetailsLinks['file_8']; 
         
        $download['0']['text'] = $orderDetailsLinks['text_1']; 
        $download['1']['text'] = $orderDetailsLinks['text_2']; 
        $download['2']['text'] = $orderDetailsLinks['text_3']; 
        $download['3']['text'] = $orderDetailsLinks['text_4']; 
        $download['4']['text'] = $orderDetailsLinks['text_5']; 
        $download['5']['text'] = $orderDetailsLinks['text_6']; 
        $download['6']['text'] = $orderDetailsLinks['text_7']; 
        $download['7']['text'] = $orderDetailsLinks['text_8'];  
        
        foreach ($download as $down){
            if ($down['link'] && $down['text']){
                $links[] = $down;
            }
        }
        
        return $links;
    }
    
    public function getUserIpCity(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $ipdat = @json_decode(file_get_contents( 
            "http://www.geoplugin.net/json.gp?ip=" . $ip)); 
        $Country = $ipdat->geoplugin_countryName;
        $City = $ipdat->geoplugin_city;    
        
        $Country = trim($Country);
        $Country = stripslashes($Country);
        $Country = htmlspecialchars($Country);
        
        $City = trim($City);
        $City = stripslashes($City);
        $City = htmlspecialchars($City);   
        $dateTime = new DateTime();
        $date = $dateTime->format('Y-m-d H:i:s');
        $params = ['ip' => $ip, 'country' => $Country, 'city' => $City, 'date' => $date];
        
        return $params;
    }
    
    public function setParamsToDb($DbParams){        
        Shopware()->Db()->insert('apc_license_status', [
            'user_email' => $DbParams['email'],
            'order_number' => $DbParams['ordernumber'],
            'order_detail_id' => $DbParams['order_detail_id'],
            'client_ip' => $DbParams['userIpCity']['ip'],
            'client_country' => $DbParams['userIpCity']['country'],
            'client_city' => $DbParams['userIpCity']['city'],
            'mail_type' => $DbParams['mail_type'],
            'sent_date' => $DbParams['userIpCity']['date'],
        ]);    
    }
}















