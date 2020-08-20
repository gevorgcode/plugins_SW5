<?php

use Doctrine\DBAL\Connection;
use PDO;
use Shopware\Components\Random;
use DateTime;
use ApcCustomVoucher\Components\Helper;
/**
 * Class Shopware_Controllers_Frontend_Softwareadmin
 */
class Shopware_Controllers_Frontend_Softwareadmin extends Enlight_Controller_Action
{
    //logic + tpl
    public function indexAction(){        
        $adminLoggedIn = $this->Request()->getCookie('adminLogin');        
        if (!$adminLoggedIn){
            $this->redirect([
                'action' => 'adminlogin',
            ]);
            return;
        }
        $Helper = new Helper();
        $creators = $Helper->getCreators();
        foreach ($creators as &$creator) {
            $creator['free_vouchers'] = $Helper->getFreeVouchers($creator['id']);            
            $creator['used_vouchers'] = $Helper->getUsedVouchers($creator['id']);            
        }
        $changedId = $this->Request()->getParam('id');
        $changedStatus = $this->Request()->getParam('status');
        $serialOrdernumber = $this->Request()->getParam('serial_ordernumber');
        $fromSerial = $this->Request()->getParam('fromserial');
        $changedLogin = $Helper->getLogin($changedId);
        $delSerialId = $this->Request()->getParam('serialId');
        $fromDelete = $this->Request()->getParam('fromdelete');
        
        $incorrectOrdernumber = $this->Request()->getParam('ordernumber');
        $fromCreateserials = $this->Request()->getParam('createserials');
                
        $Serials = $Helper->getSerials();
        $Serials = array_unique($Serials,SORT_REGULAR);           
        
        foreach ($Serials as &$id){
            $id['free_count'] = $Helper->getFreeSerialsCount($id['article_details_id']);
            $id['used_count'] = $Helper->getUsedSerialsCount($id['article_details_id']);
            $id['ordernumber'] = $Helper->getOrdernumber($id['article_details_id']);
            $id['name'] = $Helper->getArticleName($id['article_details_id']);
        }
            
        $this->View()->assign('creators', $creators);
        $this->View()->assign('changedLogin', $changedLogin);
        $this->View()->assign('changedStatus', $changedStatus);
        $this->View()->assign('serialOrdernumber', $serialOrdernumber);
        $this->View()->assign('fromSerial', $fromSerial);
        $this->View()->assign('delSerialId', $delSerialId);
        $this->View()->assign('fromDelete', $fromDelete);
        $this->View()->assign('Serials', $Serials);
        $this->View()->assign('incorrectOrdernumber', $incorrectOrdernumber);
        $this->View()->assign('fromCreateserials', $fromCreateserials);
    }  
       
    //$2y$10$UfIL4xMF4Tp0TlPdflAKmuDyq9Es35qpVFQyxLOa3hvO3sQoGlOgC//demodemo
    //tpl
    public function adminloginAction(){
        //adminlogin.tpl
    }
    //tpl
    public function busyloginAction(){
        $login = $this->Request()->getParam('login');
        $this->View()->assign('creator', $login);
    }
     //tpl
    public function successcreatedAction(){
        $creator = $this->Request()->getParam('creator');
        $this->View()->assign('creator', $creator);
    }
    
    //logic
    public function loginadminAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $login = $this->Request()->getParam('adminlogin');
        $pass = $this->Request()->getParam('password');
        $Helper = new Helper();
        $verifiAdmin = $Helper->verifyAdmin($login, $pass);
        if ($verifiAdmin){
            $this->Response()->setCookie( 'adminLogin', true, time()+3600, '/' );
            $this->redirect([
                'action' => 'index',
            ]);
        }        
    }
    
    //logic
    public function createcreatorAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $creatorLogin = $this->Request()->getParam('creatorlogin');
        $creatorPass = $this->Request()->getParam('creatorpassword');       
        
        if (!($creatorLogin && $creatorPass)){
            return;
        }
        $Helper = new Helper();
        $busyLogin = $Helper->busyLogin($creatorLogin);
        if ($busyLogin){            
            $this->redirect([
                'action' => 'busylogin',
                'login' => $creatorLogin
            ]);
        }
        $Helper = new Helper();
        $Helper->createCreator($creatorLogin, $creatorPass);
        $creator = [
            'creatorLogin' => $creatorLogin,
            'creatorPass' => $creatorPass            
            ];
        $this->forward('successcreated', null, null, ['creator' => $creator]);        
    }
    
    public function viewcreatorAction(){       
        
        if (!$this->Request()->isPost()){
            return;
        }
        $Helper = new Helper();
        $creatorLogin = $this->Request()->getparam('creatorlogin');
        $creator = $Helper->getCreator($creatorLogin);        
        $creatorVouchers = $Helper->getCreatorVouchers($creator['id']);        
        
        foreach ($creatorVouchers as &$voucher){
            $voucher['serial'] = $Helper->getSerial($voucher['serial_id']);
            $voucher['orderNumber'] = $Helper->getOrdernumber($voucher['article_details_id']);
            if (!$voucher['assign_user_id']){
                $voucher['userlogin'] = false;
            }else{
                $voucher['userlogin'] = $Helper->getUserLogin($voucher['assign_user_id']);
            }
            
        }  
        
        $this->View()->assign('creator', $creator);
        $this->View()->assign('creatorvouchers', $creatorVouchers);
    }
    
    public function changestatusAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $params = $this->Request()->getParams();
        if (!($params['status'] && $params['creator_id'])){
            $this->redirect([
                'action' => 'index',
            ]);
            return;
        }
        if ($params['status'] == 'active'){
            $status = true;
        }else{
            $status = false;
        }
        
        $id = $params['creator_id']; 
        if (!$id){
            return;
        }
        $sql = "UPDATE `apc_custom_voucher_creator` SET `creator_active`= ? WHERE `id` = ?;";
            $db = Shopware()->Db();
            $db->query($sql, [$status, $id]); 
        $this->redirect([
            'action' => 'index',
            'id' => $id,
            'status' => $status,
        ]);
    }
    
    public function createserialsAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $Helper = new Helper();
        $ordernumber = $this->Request()->getParam('ordernumber');
        $detailsId = $Helper->getDetailsId($ordernumber);
        if (!$detailsId){
            $this->redirect([
                'action' => 'index',
                'ordernumber' => $ordernumber,
                'createserials' => '1',
            ]);
        }
        
        $serilasByDetailsId = $Helper->getFreeSerilasByDetailsId($detailsId);                
        $assignedSerilasByDetailsId = $Helper->getAssignedSerilasByDetailsId($detailsId);                
        
        $this->View()->assign('ordernumber', $ordernumber);
        $this->View()->assign('detailsId', $detailsId);
        $this->View()->assign('serilas', $serilasByDetailsId);
        $this->View()->assign('assignedSerilas', $assignedSerilasByDetailsId);
    }
    
    public function createserialAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $Helper = new Helper();
        $detailsId = $this->Request()->getParam('details_id');
        $ordernumber = $this->Request()->getParam('ordernumber');
        $serials = $this->Request()->getParam('serials');
        $serialsArr = explode("\n", $serials);
        if (strlen($serials) < 1){            
            echo '<div class="container" style="max-width: 1260px; margin: 0 auto; padding: 50px 0;"> <p>You have not added the series to input</p>
                <a style="padding: 25px 0;" href="/Softwareadmin">Back to Admin page</a></div>';
            exit;
        }
        foreach ($serialsArr as $serial){
            if (strlen($serial) > 3){
                $Helper->addSerialKeys($serial, $detailsId);
            }
        }
        
        $this->redirect([
            'action' => 'index',
            'serial_ordernumber' => $ordernumber,
            'fromserial' => '1',
        ]);
    }
    
    public function deleteserialAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $Helper = new Helper();
        $serialId = $this->Request()->getParam('serial_id');
        if ($serialId){
            $Helper->deleteSerialById($serialId);
        }
        $this->redirect([
            'action' => 'index',
            'serialId' => $serialId,
            'fromdelete' => '1',
        ]);
     }
    
    public function logoutAction(){
        $this->Response()->setCookie('adminLogin', true, time()-3600, '/' );
        $this->redirect([
            'action' => 'adminlogin',
        ]);
    } 
}



