<?php

namespace ApcCustomVoucher\Subscriber;

use Enlight\Event\SubscriberInterface;
use ApcCustomVoucher\Models\VoucherModel\VoucherModel;

class TemplateSubscriber implements SubscriberInterface
{
    /**
     * @var
     */
    private $pluginDirectory;
    protected $modelManager;
    protected $alias = 'voucherModel';
    protected $voucherModel = VoucherModel::class;
    /**
     * @param $pluginDirectory
     */
    public function __construct($pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Inheritance_Template_Directories_Collected' => 'onCollectTemplateDirs',            
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Account' => 'onFrontendAccount',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Register' => 'onFrontendRegister',
            'Shopware_Controllers_Frontend_Forms_commitForm_Mail' => 'onFrontendForms',
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onCollectTemplateDirs(\Enlight_Event_EventArgs $args) {
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDirectory . '/Resources/views';
        return $dirs;
    }
        
    public function onFrontendAccount(\Enlight_Event_EventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $actionName = $request->getActionName();        
        
        if (($actionName == 'login') || ($actionName == 'index')){
            $serialId = $request->getParam('soft_order_serial_id');
            $userId = Shopware()->Session()->offsetGet('sUserId');
            
            if ($serialId && $userId){
                $sql = "UPDATE `apc_custom_voucher` SET `assign_user_id`= ? WHERE `serial_id` = ?;";
                $db = Shopware()->Db();
                $db->query($sql, [$userId, $serialId]); 
            }            
        }
        
        //view in theme NewItNerd (downloads.tpl)
        if (($actionName == 'downloads')){            
            $userId = Shopware()->Session()->offsetGet('sUserId');
            if (!$userId){
                return;
            }
            
            $softSerilasIds = Shopware()->Db()->fetchAll(
                'SELECT apc_custom_voucher.serial_id AS serialId,
                apc_custom_voucher.article_details_id AS detailsId
                FROM apc_custom_voucher                
                WHERE apc_custom_voucher.assign_user_id = :userId',
                ['userId' => $userId]
            );
                        
            if (!$softSerilasIds){
                return;
            }
            foreach ($softSerilasIds as &$softSerilasId){
                $softSerilasId['serialnumber'] = Shopware()->Db()->fetchOne(
                    'SELECT apc_custom_voucher_serials.serial_number AS serialnumber
                    FROM apc_custom_voucher_serials                
                    WHERE apc_custom_voucher_serials.id = :serialId',
                    ['serialId' => $softSerilasId['serialId']]
                ); 
                $softSerilasId['articleId'] = Shopware()->Db()->fetchOne(
                    'SELECT s_articles_details.articleID AS articleId
                    FROM s_articles_details                
                    WHERE s_articles_details.id = :detailsId',
                    ['detailsId' => $softSerilasId['detailsId']] 
                ); 
                $softSerilasId['articleName'] = Shopware()->Db()->fetchOne(
                    'SELECT s_articles.name AS articleName
                    FROM s_articles                
                    WHERE s_articles.id = :articleId',
                    ['articleId' => $softSerilasId['articleId']] 
                );
                $softSerilasId['esdId'] = Shopware()->Db()->fetchOne(
                    'SELECT s_articles_esd.id AS esdId
                    FROM s_articles_esd                
                    WHERE s_articles_esd.articledetailsID = :detailsId',
                    ['detailsId' => $softSerilasId['detailsId']] 
                );                 
                $softSerilasId['articleDetails'] = Shopware()->Db()->fetchRow(
                    'SELECT *
                    FROM s_articles_esd_attributes                
                    WHERE s_articles_esd_attributes.esdID = :esdId',
                    ['esdId' => $softSerilasId['esdId']]
                );   
            }            
            $view->assign('SoftCartArticles', $softSerilasIds);
        }
    }
    
    public function onFrontendRegister(\Enlight_Event_EventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $actionName = $request->getActionName();        
        
        if (($actionName == 'saveRegister')){
            $serialId = $request->getParam('soft_order_serial_id');
            $userId = Shopware()->Session()->offsetGet('sUserId');
            
            if ($serialId && $userId){
                $sql = "UPDATE `apc_custom_voucher` SET `assign_user_id`= ? WHERE `serial_id` = ?;";
                $db = Shopware()->Db();
                $db->query($sql, [$userId, $serialId]); 
            }           
        }        
    }

    public function onFrontendForms(\Enlight_Event_EventArgs $args) {
        
        $arrArgs = $args->getReturn();
        if ($arrArgs->getSubject() == 'Software-code question'){
            $content = $arrArgs->getPlainBodyText();
            $pieces = explode("B2B E-Mail:", $content);
            $email = str_replace(' ', '',$pieces['1']);            
            $receivers = $email;
            $arrArgs->addTo($receivers);
            $args->setReturn($arrArgs);
        }  
    }
}

