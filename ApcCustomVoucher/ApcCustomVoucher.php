<?php

namespace ApcCustomVoucher;

use Shopware\Components\Plugin;
use Doctrine\ORM\Tools\SchemaTool;
use ApcCustomVoucher\Models\VoucherModel\VoucherModel;
use ApcCustomVoucher\Models\VoucherModel\VoucherCreatorModel;
use ApcCustomVoucher\Models\VoucherModel\VoucherSerialModel;

/**
 * Class ApcCustomVoucher
 * @package ApcCustomVoucher
 */
class ApcCustomVoucher extends Plugin
{
    /**
     * @param Plugin\Context\InstallContext $context
     */
    public function install(Plugin\Context\InstallContext $context)
    {
        $em = $this->container->get('models');
        $tool = new SchemaTool($em);
        $classes = [$em->getClassMetadata(VoucherModel::class)];
        $tool->createSchema($classes);
        
        $classes = [$em->getClassMetadata(VoucherCreatorModel::class)];
        $tool->createSchema($classes);
        
        $classes = [$em->getClassMetadata(VoucherSerialModel::class)];
        $tool->createSchema($classes);
        
        $this->CreateSoftwareEmail();
        $this->CreateAdmin();

    }

    /**
     * @param Plugin\Context\ActivateContext $context
     */
    public function activate(Plugin\Context\ActivateContext $context)
    {
        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }

    /**
     * @param Plugin\Context\UninstallContext $context
     */
    public function uninstall(Plugin\Context\UninstallContext $context)
    {

//        $em = $this->container->get('models');
//        $tool = new SchemaTool($em);
//        $classes = [$em->getClassMetadata(VoucherModel::class)];
//        $tool->dropSchema($classes);
//        
//        $classes = [$em->getClassMetadata(VoucherCreatorModel::class)];
//        $tool->dropSchema($classes);
//        
//        $classes = [$em->getClassMetadata(VoucherSerialModel::class)];
//        $tool->dropSchema($classes);
        


        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }
    
    private function CreateSoftwareEmail(){
        
        $voucherEmail = Shopware()->Db()->fetchOne('SELECT * FROM `s_user` WHERE `id` = -999');
        
        if ($voucherEmail){
            return;
        }
        Shopware()->Db()->insert(
            's_user',
            [
                'id' => '-999',
                'password' => '$2y$10$sS36WtmFuoNtLu50CEHfDumNPoMSBDZv5Ov7slfQ4zGXAwrD6Nb3C', //demodemo /bcrypt
                'encoder' => 'bcrypt',
                'email' => 'no email',
                'active' => '1',
                'firstlogin' => '2019-06-01',
                'lastlogin' => '2019-07-01',
                'subshopID' => '1',
                'customergroup' => 'EK',
                'salutation' => 'mr',
                'firstname' => 'voucherdemoname',
                'lastname' => 'voucherdemolastname',
                'customernumber' => '-999',
                'default_billing_address_id' => '-999',
                'default_shipping_address_id' => '-999',
            ]
        );
        
        Shopware()->Db()->insert('s_user_addresses', [
            'id' => '-999',
            'user_id' => '-999',
            'company' => 'softcode',
            'salutation' => 'mr',
            'firstname' => '',
            'lastname' => '',
            'zipcode' => '',
            'city' => '',
            'country_id' => 2,
            'state_id' => 3,
        ]);       
    }
    
    private function CreateAdmin(){
        $Admin = Shopware()->Db()->fetchOne('SELECT * FROM `apc_custom_voucher_creator` WHERE `creator_login` = "Admin"');
        if ($Admin){
            return;
        }
        Shopware()->Db()->insert('apc_custom_voucher_creator', [            
            'creator_login' => 'Admin',
            'creator_pass' => '$2y$10$sS36WtmFuoNtLu50CEHfDumNPoMSBDZv5Ov7slfQ4zGXAwrD6Nb3C', //demodemo /bcrypt need to change after install
            'creator_role_admin' => true,
            'creator_active' => true,
            'creator_create_date' => '2019-11-27 11:32:12',            
        ]);       
    }    
}
