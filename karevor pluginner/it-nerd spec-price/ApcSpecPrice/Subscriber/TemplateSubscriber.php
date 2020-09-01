<?php

namespace ApcSpecPrice\Subscriber;

use Enlight\Event\SubscriberInterface;

class TemplateSubscriber implements SubscriberInterface
{
    /**
     * @var
     */
    private $pluginDirectory;  
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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onDetail',
            'Enlight_Controller_Action_PreDispatch_Backend_AttributeData' => 'onGenerateLink',            
            'Enlight_Controller_Action_PreDispatch_Frontend_Checkout' => 'onCheckout',
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
  
      
    public function onDetail(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $fromSpec = $request->getParam('fromSpec');
        
        if (!$fromSpec){
            return;
        }
    
        $sArticle = $request->getParam('sArticle');
        if (!$sArticle){
            return;
        }
        
        $specPrice = $request->getParam('spfPrice');
        
        //theme frontend/detail/data.tpl
        $view->assign('specPrice', $specPrice);

    }
    
    public function onCheckout(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $response = $controller->Response();
        $actionName = $request->getActionName();
        
        $articleIdCookie = $request->getCookie('spec_article_id');
        if ($articleIdCookie){
            $view->assign('specCookie', $articleIdCookie);
        } 

        $sql = 'SELECT `id` FROM `s_articles_details` WHERE `articleID` = ?';
        $articleDetailId = Shopware()->Db()->fetchOne($sql, [$articleIdCookie]); 

        $sql = 'SELECT `spec_price` FROM `s_articles_attributes` WHERE `articledetailsID` = ?';
        $specPrice = Shopware()->Db()->fetchOne($sql, [$articleDetailId]);  

        //for warenkorb view->theme ajax_cart_item.tpl
        $view->assign('specPrice', $specPrice);        
        
        if ($actionName != 'addArticle' && $actionName != 'ajax_add_article'){
            return;
        }
        
                
        $AddedOrdernumber = $request->getParam('sAdd');
        $sql = 'SELECT `articleID` FROM `s_articles_details` WHERE `ordernumber` = ?';
        $addedArticleId = Shopware()->Db()->fetchOne($sql, [$AddedOrdernumber]);                
        $articleIdCookie = $request->getCookie('spec_article_id');
        
        if ($addedArticleId != $articleIdCookie){
            return;
        }
        
        $sql = 'SELECT `id` FROM `s_articles_details` WHERE `ordernumber` = ?';
        $articleDetailId = Shopware()->Db()->fetchOne($sql, [$AddedOrdernumber]); 

        $sql = 'SELECT `spec_price` FROM `s_articles_attributes` WHERE `articledetailsID` = ?';
        $specPrice = Shopware()->Db()->fetchOne($sql, [$articleDetailId]);             

        $view->assign('specPrice', $specPrice);
        $view->assign('specPriceAddArticle', true);
        
            
        $specVoucherOrderCode = 'VnSp' . $AddedOrdernumber;        
        $response->setCookie( 'spec_vouch', $specVoucherOrderCode, time()+1500, '/' );
        
        $sql = 'SELECT * FROM `s_emarketing_vouchers` WHERE `ordercode` = ?';
        $voucher = Shopware()->Db()->fetchRow($sql, [$specVoucherOrderCode]);
        
        if (!$voucher){
            return;
        }
       
        $sessionID = Shopware()->Session()->offsetGet('sessionId');
        $userID = Shopware()->Session()->offsetGet('sUserId');
        
        if (!$userID){
            $userID = 0;
        }
        
        $articlename = 'Gutschein ' . $voucher["value"] . ' %';
        $articleID = $voucher["id"];
        $ordernumber = $voucher["ordercode"];
        
        $sql = ' INSERT INTO `s_order_basket` 
            (`sessionID`,
             `userID`,
             `articlename`,
             `articleID`, 
             `ordernumber`, 
             `shippingfree`,
             `quantity`,
             `tax_rate`,             
             `modus`,
             `esdarticle`,             
             `lastviewport`,              
             `currencyFactor`) VALUES
            (?,
             ?,
             ?,
             ?,
             ?,
             0,
             1,
             19,
             2,
             0,
             "checkout",
             1);';
        
        Shopware()->Db()->query($sql,[$sessionID, $userID, $articlename, $articleID, $ordernumber]);
        return;     
    }
     
     public function onGenerateLink(\Enlight_Event_EventArgs $args){
         $controller = $args->getSubject();
         $view = $controller->View();
         $request = $controller->Request();         
         if ($request->getParam('action') != 'saveData'){
             return;    
         } 
                  
         $articledetailsID = $request->getParam('_foreignKey');
         $token = $request->getParam('__csrf_token');
         
         // spec price from this Article
         $specPrice = $request->getParam('__attribute_spec_price');
         
         // spec price from this Article
         $sql = 'SELECT `spec_price` FROM `s_articles_attributes` WHERE `articledetailsID` = ?';
         $oldSpecPrice = Shopware()->Db()->fetchOne($sql, [$articledetailsID]); 
         
                  
         if (!$specPrice || ($specPrice == $oldSpecPrice)){
             return;
         }               
         
         //generate spec link and add to admin input        
         $specLink = 'https://it-nerd24.de/Spec?sDetailsId=' . $articledetailsID . '&curPr=' . $specPrice . '&token=' . $token;         
         $request->setParam('__attribute_spec_price_link', $specLink);       
        
        //create or update voucher 
        $sql = 'SELECT `ordernumber` FROM `s_articles_details` WHERE `id` = ?';
        $ordernumber = Shopware()->Db()->fetchOne($sql, [$articledetailsID]);
        
        $sql = 'SELECT `price` FROM `s_articles_prices` WHERE `articledetailsID` = ?';
        $result = Shopware()->Db()->fetchOne($sql, [$articledetailsID]);
        $price = $result * 1.19;
         
        $description = 'Des' . $ordernumber;
        $vouchercode = 'Vc' . $ordernumber;
        $value = (($price - $specPrice) * 100)/$price;
        $ordercode = 'VnSp' . $ordernumber;
        $restrictarticles = ';' . $ordernumber . ';'; 
        
        $sql = 'SELECT `value` FROM `s_emarketing_vouchers` WHERE `description` = ?';
        $checkVoucherValue = Shopware()->Db()->fetchOne($sql, [$description]);
         
         if (!$checkVoucherValue){
             $sql = 'INSERT INTO `s_emarketing_vouchers` (`description`, `vouchercode`, `numberofunits`, `value`, `minimumcharge`, `shippingfree`, `ordercode`, `modus`, `percental`, `numorder`, `restrictarticles`, `strict`) VALUES (?, ?, 100, ?, 10, 0, ?, 0, 1, 10, ?, 1);';
        
            Shopware()->Db()->query($sql,[$description, $vouchercode, $value, $ordercode, $restrictarticles]);
             return;
         }
         
         if ($checkVoucherValue != $value){
             $sql = 'UPDATE `s_emarketing_vouchers` SET `value` = ? WHERE `description` = ?;';
        
            Shopware()->Db()->query($sql,[$value, $description]);
             return;
         }
     }
}














