<?php

use ApcCsv\Components\GetNovalnetTrDetails;
/**
 * Class Shopware_Controllers_Frontend_Csvimportexport
 */
class Shopware_Controllers_Frontend_Csvimportexport extends Enlight_Controller_Action{   
    
    
    public function downloadAction(){    
        
        //to read csv
        $fh = fopen($_FILES['file']['tmp_name'], 'r+');
        $lines = array();
        while( ($row = fgetcsv($fh, 8192)) !== FALSE ) {
            $lines[] = $row;
        }
        //change csv
        ///to be modified
        foreach ($lines as &$line){
            if ($line['3']){
                $lineA = explode(";",$line['0']);                
                $orderNumber = $lineA['4']; 
                
                //From Novalmet API
                $paymentStatusNoval = $this->getPaymentStatusNoval($orderNumber);                
                $status = explode(";",$line['3']);
                $status['1'] = $paymentStatusNoval; 
                $line['3'] = implode(";",$status);    
                
                //from DB
//                $orderOrPaymentStatus = $this->getOrderPaymentStatus($orderNumber);                
//                $status = explode(";",$line['3']);
//                $status['1'] = $orderOrPaymentStatus; 
//                $line['3'] = implode(";",$status);   
            }
        }  
        
        //create and download csv
        $fileName = 'it-nerd24_' . $_FILES['file']['name'];
        
        if ($lines){
           // output headers so that the file is downloaded rather than displayed
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="'.$fileName.'"');

            // do not cache the file
            header('Pragma: no-cache');
            header('Expires: 0');

            // create a file pointer connected to the output stream
            $file = fopen('php://output', 'w');

            // output each row of the data
            foreach ($lines as $row){
                fputcsv($file, $row);
            }
            exit();
       }        
    }
    
    public function indexAction(){
        
    }

    private function getPaymentStatusNoval($orderNumber){
        $tid = Shopware()->Db()->fetchOne(
            'SELECT tid
            FROM s_novalnet_transaction_detail                
            WHERE s_novalnet_transaction_detail.order_no = :order_no',
            ['order_no' => $orderNumber]
        ); 
        $GetNovalnetTrDetails = new GetNovalnetTrDetails();
        $result = $GetNovalnetTrDetails->getNovalnetTransactionDetail($tid);
        if ($result['transaction']['status'] == 'DEACTIVATED'){
            $status = 2;
        }elseif($result['transaction']['status'] == 'CONFIRMED'){
            $status = 1;
        }else{
            $status = 0;
        }
        return $status;
    }
    
     private function getOrderPaymentStatus($orderNumber){
        $order = Shopware()->Db()->fetchRow(
            'SELECT status, cleared
            FROM s_order                
            WHERE s_order.ordernumber = :ordernumber',
            ['ordernumber' => $orderNumber]
        ); 
        
        if ($order['status'] == 4 || $order['cleared'] == 35){
            //canceled
            return 2;            
        }elseif ($order['status'] == 2 || $order['cleared'] == 12){
            //paid
            return 1;            
        }else{
            //open or in progress
            return 0;
        }        
    }   
}




































