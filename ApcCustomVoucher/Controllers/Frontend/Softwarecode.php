<?php

use Doctrine\DBAL\Connection;
use PDO;

use Shopware\Components\Random;
use ApcCustomVoucher\Components\Helper;

/**
 * Class Shopware_Controllers_Frontend_Softwarecode
 */
class Shopware_Controllers_Frontend_Softwarecode extends Enlight_Controller_Action
{
    /**
     * @throws Exception
     */
    public function indexAction(){        

        if ($this->Request()->isPost()){            
            $vouchEmail = $this->Request()->getParam('software-code-email');
            $mailSendAgree = $this->Request()->getParam('software-code_checkbox');
            $SoftwareCode = $this->Request()->getParam('software-code-value');
            $SoftwareCode = str_replace(' ', '',$SoftwareCode);
            $SoftwareCode = str_replace('-', '',$SoftwareCode);
            
            if (strlen($SoftwareCode) == 12){
                $parts = str_split($SoftwareCode, 4);
                $SoftwareCode = $parts['0'].'-'.$parts['1'].'-'.$parts['2'];
                
                $articleIds = $this->getArticleIdByVoucher($SoftwareCode);
                $articleId = $articleIds['0'];
                $articleDetailsId = $articleIds['1'];
                
                if ($articleId){  
                    
                    $params = [
                        'softwareCode' => $SoftwareCode,
                        'articleId' => $articleId,
                        'articleDetailsId' => $articleDetailsId,
                        'vouchEmail' => $vouchEmail
                    ];
                    
                    if ($mailSendAgree){
                        $this->sendVoucherMail($params);
                    }
                    
                    $this->forward('download', null, null, ['softcode_params' => $params]);
                }
                else{
                    $this->redirect([
                        'action' => 'error',
                    ]);
                    return;
                }
            }
            else{
                 $this->redirect([
                    'action' => 'error',
                ]);
                return;
            }
        }
    }
    
    public function downloadAction(){
        
        if (!$this->Request()->isPost()){
            $this->redirect([
                'action' => 'error',
            ]);
            return;
        }
        $params = $this->Request()->getParam('softcode_params');
        $SoftwareCode = $params['softwareCode'];
        $articleId = $params['articleId'];
        $articleDetailsId = $params['articleDetailsId'];
        $vouchEmail = $params['vouchEmail'];

        if (!($SoftwareCode && $articleId)){
            $this->redirect([
                'action' => 'error',
            ]);
            return;
        }

        $countryList = $this->get('modules')->Admin()->sGetCountryList();
        $UserLoggedIn = Shopware()->Modules()->Admin()->sCheckUser();

        //all article information
        $sArticle = Shopware()->Modules()->Articles()->sGetArticleById($articleId);

        if ($UserLoggedIn) {
            $userId = Shopware()->Session()->offsetGet('sUserId');
        }else{
            $userId = -999;
        }

        $esdId = $this->getEsdIdByArticleId($articleId);

        //array width download link
        $esdAttributes = $this->getEsdAttributes($esdId);
   
        $serialId = $this->getSerialId($SoftwareCode);
        $productKey = $this->getproductKey($serialId);
        
        if (!$productKey){
            $this->redirect([
                'action' => 'error',
            ]);
            return;
        }
    
        $AssignedSoftwareCode = '✅' . $SoftwareCode . ' ✅ Used';
        $db = Shopware()->Db();
        $sql = "UPDATE `apc_custom_voucher` SET `voucher_name`= ?, `assign_user_id` = ?, `voucher_email` = ?, `voucher_used` = true, `voucher_used_date` = Now() WHERE `voucher_name` = ?;";        
        $db->query($sql, [$AssignedSoftwareCode, $userId, $vouchEmail, $SoftwareCode]);  
        
        $Helper = new Helper();
        
        $creatorId = $Helper->getCreatorId($AssignedSoftwareCode);
        $b2bemail = $Helper->getLogin($creatorId);
        
   
       /////////////////////////////////////////////////////////////////

        //assigned to download.tpl
        $this->View()->assign('Softwarecode', $SoftwareCode);
        $this->View()->assign('countryList', $countryList);
        $this->View()->assign('productKey', $productKey);
        $this->View()->assign('esdAttr', $esdAttributes);
        $this->View()->assign('serialId', $serialId); 
        $this->View()->assign('sArticle', $sArticle);        
        $this->View()->assign('b2bemail', $b2bemail);        
    }
    
    public function sendVoucherMail($params){
        
        $userData['email'] = $params['vouchEmail'];
        
        $data['downloads'] = Shopware()->Container()->get('apc_multi_download.download_component')->getMultipleDownloads($params['articleId']);
        $Helper = new Helper();
        
        $data['articleName'] = $Helper->getArticleName($params['articleDetailsId']);
        $serial = $Helper->getSerialByVoucher($params['softwareCode']);
        
        $context['user'] = $userData;        
        $context['details'] = $data;
        $context['serial'] = $serial;
        
        
        $mail = Shopware()->TemplateMail()->createMail('customVoucher',$context);
        $mail->addTo($userData['email']);
        try {
            $mail->send();
        } catch(\Exception $ex) {
           die($ex->getMessage());
        }
        return;
    }
    
    public function errorAction(){
        //error.tpl
    }
    
    //////////////////////////////////////////for copy codes
    //added getcode.tpl, copycodes.tpl, wrongpascode.tpl/, createsuccess.tpl and str 6-8, 55-144 for this file
    public function createsuccessAction(){
        $countCreatedVouchers = $this->Request()->getParam('countCreatedVouchers');
        $ordernumber = $this->Request()->getParam('ordernumber');
        $this->View()->assign('countCreatedVouchers', $countCreatedVouchers);
        $this->View()->assign('ordernumber', $ordernumber);

        //tpl
    }
    public function getcodeAction(){
        //tpl
    }
    public function createcodeAction(){
        $request = $this->Request();
        $params = $request->getParams();
        if (!$request->isPost()){
            return;
        }

        $countCreatedVouchers = $params['count_created_vouchers'];
        $articleDetailId = $params['article_detail_id'];
        $ordernumber = $params['article_order_number'];

        if (!$countCreatedVouchers || !$articleDetailId) {
            return;
        }

        for ($i = 1; $i <= $countCreatedVouchers; $i++) {
            $Code1 = Random::getInteger(1111, 9999);
            $Code2 = Random::getInteger(1111, 9999);
            $Code3 = Random::getInteger(1111, 9999);
            $voucherCode = $Code1.'-'.$Code2.'-'.$Code3;

            Shopware()->Db()->insert('apc_custom_voucher', [
                'voucher_name' => $voucherCode,
                'article_id' => $articleDetailId,
            ]);
        }

        $this->forward('createsuccess', null, null, ['ordernumber' => $ordernumber, 'countCreatedVouchers' => $countCreatedVouchers]);

    }
    public function copycodesAction(){
        if (!$this->Request()->isPost()){
            return;
        }

        $orderNumber = $this->Request()->getParam('orderNumber');
        $pass = $this->Request()->getParam('password');
        if ($pass != '1RXZ0l9RunxilHEse'){
            $this->redirect([
                'action' => 'wrongpascode',
            ]);
        }

        $sql = 'SELECT `id` FROM `s_articles_details` WHERE `ordernumber` = ?';
        $articleDetailId = Shopware()->Db()->fetchOne($sql, $orderNumber);

        if (!$articleDetailId) {
            $this->redirect([
                'action' => 'wrongpascode',
            ]);
        }

        $sql = 'SELECT `voucher_name` FROM `apc_custom_voucher` WHERE `article_id` = ?';
        $voucherCodes = Shopware()->Db()->fetchAll($sql, $articleDetailId);
        $NoAssignedCount = 0;
        foreach ($voucherCodes as $code){
            if (strlen($code['voucher_name']) < 15){
                $NoAssignedCount++;
            }
        }
        $countVoucherCodes = count($voucherCodes);
        $AssignedCount = $countVoucherCodes - $NoAssignedCount;


        $this->View()->assign('voucherCodes', $voucherCodes);
        $this->View()->assign('countVoucherCodes', $countVoucherCodes);
        $this->View()->assign('NoAssignedCount', $NoAssignedCount);
        $this->View()->assign('AssignedCount', $AssignedCount);
        $this->View()->assign('orderNumber', $orderNumber);
        $this->View()->assign('articleDetailId', $articleDetailId);

    }

    public function wrongpascodeAction(){
        //tpl
    }
    ////////////////////////////////////////////////////////


    
    
    
    /////////////////////////////////////////////////////////// private functions
     // function from Core/sOrder.Php
    private function getAvailableSerialsOfEsd($esdId){
        return Shopware()->Db()->fetchAll(
            'SELECT s_articles_esd_serials.id AS id, s_articles_esd_serials.serialnumber AS serialnumber
            FROM s_articles_esd_serials
            LEFT JOIN s_order_esd
              ON (s_articles_esd_serials.id = s_order_esd.serialID)
            WHERE s_order_esd.serialID IS NULL
            AND s_articles_esd_serials.esdID= :esdId',
            ['esdId' => $esdId]
        );
    }
    private function getEsdAttributes($esdId){
        $query = $this->get('dbal_connection')->createQueryBuilder();

        $query->select('*')
            ->from('s_articles_esd_attributes', 'esd_attr')
            ->where('esd_attr.esdID = :esd_id')
            ->setParameter(':esd_id', $esdId);
        return $query->execute()->fetch(\PDO::FETCH_GROUP);
    }

    private function getEsdIdByArticleId($articleId){
        $query = $this->get('dbal_connection')->createQueryBuilder();
        $query->select('esd.id')
            ->from('s_articles_esd', 'esd')
            ->where('esd.articleID = :article_id')
            ->setParameter(':article_id', $articleId);
        return $query->execute()->fetch(\PDO::FETCH_COLUMN);
    }

    private function getArticleIdByVoucher($SoftwareCode){

        $query = $this->get('dbal_connection')->createQueryBuilder();
        $query->select('voucher.article_details_id')
            ->from('apc_custom_voucher', 'voucher')
            ->where('voucher.voucher_name = :voucher_name')
            ->setParameter(':voucher_name', $SoftwareCode);
        $articledetailsID = $query->execute()->fetch(\PDO::FETCH_COLUMN);
        
        $query = $this->get('dbal_connection')->createQueryBuilder();
        $query->select('article.articleID')
            ->from('s_articles_details', 'article')
            ->where('article.id = :details_id')
            ->setParameter(':details_id', $articledetailsID);
        
        $articleId = $query->execute()->fetch(\PDO::FETCH_COLUMN);
        
        $articleIds = [$articleId, $articledetailsID];
        return  $articleIds;
    }

    private function getSerialId($SoftwareCode){
        $query = $this->get('dbal_connection')->createQueryBuilder();
        $query->select('voucher.serial_id')
            ->from('apc_custom_voucher', 'voucher')
            ->where('voucher.voucher_name = :voucher_name')
            ->setParameter(':voucher_name', $SoftwareCode);
        return $query->execute()->fetch(\PDO::FETCH_COLUMN);
    }
    
    private function getproductKey($serialId){
        $query = $this->get('dbal_connection')->createQueryBuilder();
        $query->select('serial.serial_number')
            ->from('apc_custom_voucher_serials', 'serial')
            ->where('serial.id = :serial_id')
            ->setParameter(':serial_id', $serialId);
        return $query->execute()->fetch(\PDO::FETCH_COLUMN);
    }
}
