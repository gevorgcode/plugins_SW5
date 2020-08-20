<?php

namespace ApcCustomVoucher\Components;

use Doctrine\DBAL\Connection;
use PDO;
use Shopware\Components\Random;
use DateTime;

class Helper{
    
    public function getOrdernumber($detailId){
        return Shopware()->Db()->fetchOne(
            'SELECT ordernumber
            FROM s_articles_details             
            WHERE s_articles_details.id = :detail_id',
            ['detail_id' => $detailId]
        ); 
    }
    
    public function verifyAdmin($login, $pass){
        $DbAdminRow = Shopware()->Db()->fetchRow(
            'SELECT *
            FROM apc_custom_voucher_creator                
            WHERE apc_custom_voucher_creator.creator_login = :creator_login',
            ['creator_login' => $login]
        ); 
        if (!$DbAdminRow){
            return false;
        }
        
        $DbPass = $DbAdminRow['creator_pass'];
        $DbRoleadmin = $DbAdminRow['creator_role_admin'];
        $DbAdminActive = $DbAdminRow['creator_active'];
        $verypas = password_verify($pass, $DbPass);
        if($DbRoleadmin && $DbAdminActive && $verypas){
            return true;
        }
        return false;
        
    }
    public function createCreator($creatorLogin, $creatorPass){        
        $dateTime = new DateTime();
        $date = $dateTime->format('Y-m-d H:i:s');
        $passwordhash = password_hash($creatorPass, PASSWORD_DEFAULT);
        Shopware()->Db()->insert('apc_custom_voucher_creator', [
            'creator_login' => $creatorLogin,
            'creator_pass' => $passwordhash,
            'creator_role_admin' => false,
            'creator_active' => true,
            'creator_create_date' => $date,
        ]);        
    }
    public function busyLogin($creatorLogin){
        return Shopware()->Db()->fetchRow(
            'SELECT *
            FROM apc_custom_voucher_creator                
            WHERE apc_custom_voucher_creator.creator_login = :creator_login',
            ['creator_login' => $creatorLogin]
        ); 
    }
    public function getCreators(){
        return Shopware()->Db()->fetchAll(
            'SELECT *
            FROM apc_custom_voucher_creator                
            WHERE apc_custom_voucher_creator.creator_role_admin = :creator_role_admin',
            ['creator_role_admin' => false]
        ); 
    }
    
    public function getFreeVouchers($creatorId){
        return Shopware()->Db()->fetchOne(
            'SELECT COUNT(*)
            FROM apc_custom_voucher             
            WHERE apc_custom_voucher.creator_id = :creator_id
            AND apc_custom_voucher.voucher_used = false',
            ['creator_id' => $creatorId]
        ); 
    }
    public function getUsedVouchers($creatorId){
        return Shopware()->Db()->fetchOne(
            'SELECT COUNT(*)
            FROM apc_custom_voucher             
            WHERE apc_custom_voucher.creator_id = :creator_id
            AND apc_custom_voucher.voucher_used = true',
            ['creator_id' => $creatorId]
        ); 
    }
    
    public function getCreator($creatorLogin){
        return Shopware()->Db()->fetchRow(
            'SELECT *
            FROM apc_custom_voucher_creator                
            WHERE apc_custom_voucher_creator.creator_login = :creator_login',
            ['creator_login' => $creatorLogin]
        ); 
    }
    
    public function getCreatorVouchers($creatorId){
        return Shopware()->Db()->fetchAll(
            'SELECT *
            FROM apc_custom_voucher               
            WHERE apc_custom_voucher.creator_id = :creator_id',
            ['creator_id' => $creatorId]
        ); 
    }
    
    public function getSerial($serialrId){
        return Shopware()->Db()->fetchOne(
            'SELECT serial_number
            FROM apc_custom_voucher_serials             
            WHERE apc_custom_voucher_serials.id = :serial_id',
            ['serial_id' => $serialrId]
        ); 
    }
        
    public function getLogin($changedId){
        return Shopware()->Db()->fetchOne(
            'SELECT apc_custom_voucher_creator.creator_login
            FROM apc_custom_voucher_creator                
            WHERE apc_custom_voucher_creator.id = :id',
            ['id' => $changedId]
        ); 
    }
    public function getUserLogin($voucherUserId){
        return Shopware()->Db()->fetchOne(
            'SELECT s_user.email
            FROM s_user                
            WHERE s_user.id = :id',
            ['id' => $voucherUserId]
        ); 
    }
    public function getDetailsId($ordernumber){
        return Shopware()->Db()->fetchOne(
            'SELECT id
            FROM s_articles_details             
            WHERE s_articles_details.ordernumber = :ordernumber',
            ['ordernumber' => $ordernumber]
        ); 
    }
    
    public function addSerialKeys($serial, $detailsId){
        
        if ($serial && $detailsId){
            Shopware()->Db()->insert('apc_custom_voucher_serials', [
                'serial_number' => $serial,
                'article_details_id' => $detailsId,
                'serial_assigned' => false,                
            ]);   
        }             
    }
    
    public function getFreeSerilasByDetailsId($detailsId){
        return Shopware()->Db()->fetchAll(
            'SELECT *
            FROM apc_custom_voucher_serials                
            WHERE apc_custom_voucher_serials.article_details_id = :article_details_id
            AND apc_custom_voucher_serials.serial_assigned = false',
            ['article_details_id' => $detailsId]
        ); 
    }
    public function getAssignedSerilasByDetailsId($detailsId){
        return Shopware()->Db()->fetchAll(
            'SELECT *
            FROM apc_custom_voucher_serials                
            WHERE apc_custom_voucher_serials.article_details_id = :article_details_id
            AND apc_custom_voucher_serials.serial_assigned = true',
            ['article_details_id' => $detailsId]
        ); 
    }
    
    public function deleteSerialById($serialId){
        return Shopware()->Db()->query(
            'DELETE 
            FROM apc_custom_voucher_serials 
            WHERE apc_custom_voucher_serials.id = :serial_id',
            ['serial_id' => $serialId]            
        ); 
    }
    
    public function getCreatreIdByLogin($creatorLogin){
        return Shopware()->Db()->fetchOne(
            'SELECT apc_custom_voucher_creator.id
            FROM apc_custom_voucher_creator                
            WHERE apc_custom_voucher_creator.creator_login = :creator_login',
            ['creator_login' => $creatorLogin]
        ); 
    }
    
    public function verifyCreator($login, $pass){
        $DbCreatorRow = Shopware()->Db()->fetchRow(
            'SELECT *
            FROM apc_custom_voucher_creator                
            WHERE apc_custom_voucher_creator.creator_login = :creator_login',
            ['creator_login' => $login]
        ); 
        if (!$DbCreatorRow){
            return false;
        }
        
        $DbPass = $DbCreatorRow['creator_pass'];
        $DbRoleadmin = $DbCreatorRow['creator_role_admin'];
        $DbCreatorActive = $DbCreatorRow['creator_active'];
        $verypas = password_verify($pass, $DbPass);
        if(!$DbRoleadmin && $DbCreatorActive && $verypas){
            return true;
        }
        return false;        
    }
    
    public function getCreatorVouchersOrdernumber($creatorId, $detailsId){
        return Shopware()->Db()->fetchAll(
            'SELECT *
            FROM apc_custom_voucher                
            WHERE apc_custom_voucher.creator_id = :creator_id
            AND apc_custom_voucher.article_details_id = :details_id',
            ['creator_id' => $creatorId, 'details_id' => $detailsId]            
        ); 
    }
    
    public function getAvilableSerials($detailsId){
        return Shopware()->Db()->fetchAll(
            'SELECT *
            FROM apc_custom_voucher_serials                
            WHERE apc_custom_voucher_serials.serial_assigned = false
            AND apc_custom_voucher_serials.article_details_id = :details_id',
            ['details_id' => $detailsId]            
        ); 
    }
    
    public function getAvilableSerialsLimit($detailsId, $countToCreate){        
        
        return Shopware()->Db()->fetchAll(
            'SELECT *
            FROM apc_custom_voucher_serials                
            WHERE apc_custom_voucher_serials.serial_assigned = false
            AND apc_custom_voucher_serials.article_details_id = :details_id
            ORDER BY apc_custom_voucher_serials.id ASC LIMIT ' . $countToCreate,
            ['details_id' => $detailsId]            
        ); 
    }
    
    public function createVoucher($avilableserial, $creatorId){
        
        $dateTime = new DateTime();
        $date = $dateTime->format('Y-m-d H:i:s');
            $Code1 = Random::getInteger(1111, 9999);
            $Code2 = Random::getInteger(1111, 9999);
            $Code3 = Random::getInteger(1111, 9999);
        $voucherName = $Code1.'-'.$Code2.'-'.$Code3;
        Shopware()->Db()->insert('apc_custom_voucher', [
            'voucher_name' => $voucherName,
            'serial_id' => $avilableserial['id'],
            'article_details_id' => $avilableserial['article_details_id'],
            'creator_id' => $creatorId,            
            'voucher_create_date' => $date,
            'voucher_used' => false,            
        ]); 
        Shopware()->Db()->query(
            'UPDATE apc_custom_voucher_serials
            SET apc_custom_voucher_serials.serial_assigned = true
            WHERE apc_custom_voucher_serials.id = :serial_id',
            ['serial_id' => $avilableserial['id']]           
        ); 
    }
    
    public function getSerials(){
        return Shopware()->Db()->fetchAll(
            'SELECT apc_custom_voucher_serials.article_details_id            
            FROM apc_custom_voucher_serials'       
        ); 
    }
    
    public function getFreeSerialsCount($detailsId){
        return Shopware()->Db()->fetchOne(
            'SELECT COUNT(*)
            FROM apc_custom_voucher_serials                
            WHERE apc_custom_voucher_serials.serial_assigned = false
            AND apc_custom_voucher_serials.article_details_id = :details_id',
            ['details_id' => $detailsId]
        ); 
    }
    
    public function getUsedSerialsCount($detailsId){
        return Shopware()->Db()->fetchOne(
            'SELECT COUNT(*)
            FROM apc_custom_voucher_serials                
            WHERE apc_custom_voucher_serials.serial_assigned = true
            AND apc_custom_voucher_serials.article_details_id = :details_id',
            ['details_id' => $detailsId]
        ); 
    }
    
    public function getArticleName($detailsId){
        $articleId = Shopware()->Db()->fetchOne(
            'SELECT s_articles_details.articleID
            FROM s_articles_details                
            WHERE s_articles_details.id = :details_id',            
            ['details_id' => $detailsId]
        ); 
        if ($articleId){
            $articleName = Shopware()->Db()->fetchOne(
                'SELECT s_articles.name
                FROM s_articles                
                WHERE s_articles.id = :article_id',            
                ['article_id' => $articleId]
            ); 
        }
        if ($articleName){
            return $articleName;
        }
    }
    public function getFreeVouchersForCreator($fromDate, $toDate, $creatorId){
        $toDate = strtotime($toDate) + 86400;
        //$date = date('d-m-Y', strtotime("+1 day", strtotime("10-12-2011")));
        $toDate = date('Y-m-d', $toDate);        
        return Shopware()->Db()->fetchAll(
            'SELECT *
            FROM apc_custom_voucher               
            WHERE apc_custom_voucher.creator_id = :creator_id
            AND apc_custom_voucher.voucher_used = false
            AND apc_custom_voucher.voucher_create_date >= :from_date
            AND apc_custom_voucher.voucher_create_date <= :to_date',
            ['creator_id' => $creatorId, 'from_date' => $fromDate, 'to_date' => $toDate]
        ); 
    }
    
    public function getSerialByVoucher($voucherName){
        $serialId = Shopware()->Db()->fetchOne(
            'SELECT apc_custom_voucher.serial_id
            FROM apc_custom_voucher             
            WHERE apc_custom_voucher.voucher_name = :voucher_name',            
            ['voucher_name' => $voucherName]
        );
        return $this->getSerial($serialId);
        
    }
    
    public function getCreatorId($SoftwareCode){
        return Shopware()->Db()->fetchOne(
            'SELECT apc_custom_voucher.creator_id
            FROM apc_custom_voucher             
            WHERE apc_custom_voucher.voucher_name = :voucher_name',            
            ['voucher_name' => $SoftwareCode]
        );
    }
    
    public function getVouch($vouchcode, $creatorId){
        $FreeVouch = Shopware()->Db()->fetchRow(
            'SELECT *
            FROM apc_custom_voucher                
            WHERE apc_custom_voucher.creator_id = :creator_id
            AND apc_custom_voucher.voucher_name = :voucher_name',
            ['creator_id' => $creatorId, 'voucher_name' => $vouchcode]
        ); 
        
        $usedVouchCode = '✅' . $vouchcode . ' ✅ Used';
        
        $usedVouch = Shopware()->Db()->fetchRow(
            'SELECT *
            FROM apc_custom_voucher                
            WHERE apc_custom_voucher.creator_id = :creator_id
            AND apc_custom_voucher.voucher_name = :voucher_name',
            ['creator_id' => $creatorId, 'voucher_name' => $usedVouchCode]
        ); 
        
        return  ['FreeVouch' => $FreeVouch, 'usedVouch' => $usedVouch];
    }
}















