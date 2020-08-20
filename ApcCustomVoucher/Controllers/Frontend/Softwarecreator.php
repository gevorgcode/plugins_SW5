<?php

use Doctrine\DBAL\Connection;
use PDO;
use Shopware\Components\Random;
use DateTime;
use ApcCustomVoucher\Components\Helper;

/**
 * Class Shopware_Controllers_Frontend_Softwarecreator
 */
class Shopware_Controllers_Frontend_Softwarecreator extends Enlight_Controller_Action
{
 
    public function indexAction(){
        $creatorLogin = $this->Request()->getCookie('creatorLogin');        
        if (!$creatorLogin){
            $this->redirect([
                'action' => 'creatorlogin',
            ]);
            return;
        }
        $Helper = new Helper();
        $creatorId = $Helper->getCreatreIdByLogin($creatorLogin);        
        $vouchers = $Helper->getCreatorVouchers($creatorId);
        
        foreach ($vouchers as &$voucher){
            $voucher['ordernumber'] = $Helper->getOrdernumber($voucher['article_details_id']);
            if ($voucher['assign_user_id']){
                $voucher['assignuser'] = $Helper->getUserLogin($voucher['assign_user_id']);
            }            
        }
        
        $Serials = $Helper->getSerials();
        $Serials = array_unique($Serials,SORT_REGULAR);
        
        foreach ($Serials as &$id){
            $id['free_count'] = $Helper->getFreeSerialsCount($id['article_details_id']);            
            $id['ordernumber'] = $Helper->getOrdernumber($id['article_details_id']);
            $id['name'] = $Helper->getArticleName($id['article_details_id']);
        }
        
        $createOrdernumber = $this->Request()->getParam('cronum');
        $createCount = $this->Request()->getParam('countcr');
        
        $freeVouch = $this->Request()->getParam('freeVouch');
        $usedVouch = $this->Request()->getParam('usedVouch');
        
                
        $this->View()->assign('vouchers', $vouchers);
        $this->View()->assign('creatorLogin', $creatorLogin);
        $this->View()->assign('creatorId', $creatorId);
        $this->View()->assign('Serials', $Serials);
        $this->View()->assign('createOrdernumber', $createOrdernumber);
        $this->View()->assign('createCount', $createCount);
        $this->View()->assign('freeVouch', $freeVouch);
        $this->View()->assign('usedVouch', $usedVouch);
    }
    
    public function creatorloginAction(){
        //creatorlogin.tpl
    }
    
    //logic
    public function logincreatorAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $Helper = new Helper();
        $login = $this->Request()->getParam('creatorlogin');
        $pass = $this->Request()->getParam('password');
        $verifiCreator = $Helper->verifyCreator($login, $pass);
        if ($verifiCreator){
            $this->Response()->setCookie( 'creatorLogin', $login, time()+3600, '/' );
            $this->redirect([
                'action' => 'index',
            ]);
        }        
    }
    //logic
    public function logoutAction(){
        $this->Response()->setCookie('creatorLogin', $login, time()-3600, '/' );
        $this->redirect([
            'action' => 'creatorlogin',
        ]);
    }
    
    public function createcodeAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $ordernumber = $this->Request()->getParam('order_number');
        $creatorId = $this->Request()->getParam('creator_id');
        if (!$ordernumber){
            return;
        }
        $Helper = new Helper();
        $detailsId = $Helper->getDetailsId($ordernumber);
        $vouchersOrdernumber = $Helper->getCreatorVouchersOrdernumber($creatorId, $detailsId);
        $avilableserials = $Helper->getAvilableSerials($detailsId);
      
        $this->View()->assign('ordernumber', $ordernumber);
        $this->View()->assign('vouchersOrdernumber', $vouchersOrdernumber);
        $this->View()->assign('avilableserials', $avilableserials);
        $this->View()->assign('detailsId', $detailsId);
        $this->View()->assign('creatorId', $creatorId);
        
    }
    //logic
    public function createAction(){
        if (!$this->Request()->isPost()){
            return;
        }        
        $params = $this->Request()->getParams();
        $orderNumber = $params['order_number'];
        $detailsId = $params['details_id'];
        $creatorId = $params['creator_id'];
        $countToCreate = $params['count_created_vouchers'];

        if (!($orderNumber && $detailsId && $creatorId && $countToCreate)){
            return;
        }
        
        $Helper = new Helper();
        $avilableserials = $Helper->getAvilableSerialsLimit($detailsId, $countToCreate);
        
        foreach ($avilableserials as $avilableserial){
            $Helper->createVoucher($avilableserial, $creatorId);            
        }        
        
        $this->redirect([
            'action' => 'index',
            'cronum' => $orderNumber,
            'countcr' => $countToCreate
        ]);                
    }  
    public function downvouchAction(){
        if (!$this->Request()->isPost()){
            return;
        }  
        $params = $this->Request()->getParams();
        $isDate = $params['is_date'];
        $fromDate = $params['fromdate'];
        $toDate = $params['todate'];
        $creatorId = $params['creator_id'];
        if (!$isDate){
            return;
        }
        $Helper = new Helper();
        $downVouch = $Helper->getFreeVouchersForCreator($fromDate, $toDate, $creatorId);
        foreach ($downVouch as &$item){
            $item['ordernumber'] = $Helper->getOrdernumber($item['article_details_id']);
            $item['articlename'] = $Helper->getArticleName($item['article_details_id']);
        }
        $this->View()->assign('fromDate', $fromDate);
        $this->View()->assign('toDate', $toDate);
        $this->View()->assign('downVouch', $downVouch);
        
        /////////////////////////////////////////////////
   
        
        if ($downVouch){
           // output headers so that the file is downloaded rather than displayed
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="'.$fromDate.'_to_'.$toDate.'_free-vouchers.csv"');

            // do not cache the file
            header('Pragma: no-cache');
            header('Expires: 0');

            // create a file pointer connected to the output stream
            $file = fopen('php://output', 'w');

            // send the column headers
            
            //fputcsv($file, [' from ', $fromDate,'', '  to ', $toDate]);
            fputcsv($file, ['Voucher', 'Serial Id', 'Ordernumber', 'Article name', 'Created']);

    

            // output each row of the data
            foreach ($downVouch as $row){
                $newrow['voucher_name'] = $row['voucher_name'];
                $newrow['serial_id'] = $row['serial_id'];
                $newrow['ordernumber'] = $row['ordernumber'];
                $newrow['articlename'] = $row['articlename'];
                $newrow['voucher_create_date'] = $row['voucher_create_date'];
                fputcsv($file, $newrow);
            }

            exit();

       }
                
        //////////////////////////////////////////////
    }
    
    public function searchvouchAction(){
         if (!$this->Request()->isPost()){
            return;
        }  
        $params = $this->Request()->getParams();
        $vouchcode = $params['vouchcode'];
        $vouchcode = str_replace(" ","",$vouchcode);
        $creatorId = $params['creator_id'];
        $Helper = new Helper();
        $Vouch = $Helper->getVouch($vouchcode, $creatorId);
        if ($Vouch['FreeVouch']){
            $freeVouch = $Vouch['FreeVouch'];
            $freeVouch['ordernumber'] = $Helper->getOrdernumber($freeVouch['article_details_id']);            
            $this->forward('index', null, null, ['freeVouch' => $freeVouch]);
        }
        if ($Vouch['usedVouch']){
            $usedVouch = $Vouch['usedVouch'];
            $usedVouch['ordernumber'] = $Helper->getOrdernumber($usedVouch['article_details_id']);
            $usedVouch['assignuser'] = $Helper->getUserLogin($usedVouch['assign_user_id']);
            $this->forward('index', null, null, ['usedVouch' => $usedVouch]);
        }
        
    }
}

