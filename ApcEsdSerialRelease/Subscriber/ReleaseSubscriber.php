<?php

namespace ApcEsdSerialRelease\Subscriber;

use Enlight\Event\SubscriberInterface;

class ReleaseSubscriber implements SubscriberInterface
{
    /**
     * @var string
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
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Order' => 'onCheckoutFinish',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onCheckoutFinishPopup',
        ];
    }

    public function onCheckoutFinishPopup(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();

        $actionName = $request->getActionName();

        if($actionName != 'finish'){
            return;
        }

        $orderNumber = $view->getAssign('sOrderNumber');
        $sPaymentId = $view->getAssign('sPayment')['id'];
        
        //delete assign serial if payment method 'Vorkasse'-id->83 or 'Rechnung'-id->82 
        if ($sPaymentId == '83' || $sPaymentId == '82'){
            $sql = "SELECT `id` FROM `s_order` WHERE `ordernumber` = ?";
            $db = Shopware()->Db();
            $orderid = $db->fetchOne($sql, $orderNumber);
            
            $sql = "DELETE FROM `s_order_esd` WHERE `orderID` = ? ;";
            $db = Shopware()->Db();
            $db->query($sql, $orderid);
        }
        
        $basket = $view->sBasket;
        $esd = 0;
        foreach($basket['content'] as $content){
            if($content['esd'] == 1){
                $esd++;
            }
        }

        if($esd == 0){
            return;
        }

        $orderDatax;
        $orderDatas = Shopware()->Modules()->Admin()->sGetDownloads(1,5);
        foreach($orderDatas['orderData'] as &$orderData){
            $oderdatax[] =  $orderData;
        }

        if($oderdatax[0][ordernumber] == $orderNumber){
            ($final = $oderdatax[0]);
        }elseif($oderdatax[1][ordernumber] == $orderNumber){
            ($final = $oderdatax[1]);
        }elseif($oderdatax[2][ordernumber] == $orderNumber){
            ($final = $oderdatax[2]);
        }elseif($oderdatax[3][ordernumber] == $orderNumber){
            ($final = $oderdatax[3]);
        }elseif($oderdatax[4][ordernumber] == $orderNumber){
            ($final = $oderdatax[4]);
        }

        foreach($final['details'] as &$detail){
            $detail['serial'] = explode(', ',$detail['serial']);
        }

        $view->esd = $final;
        $view->sDownloadAvailablePaymentStatus = Shopware()->Config()->get('downloadAvailablePaymentStatus');

    }

    public function onCheckoutFinish(\Enlight_Event_EventArgs $args){

        $controller = $args->getSubject();
        $request = $controller->Request();

        $actionName = $request->getActionName();
        if($actionName != 'save'){
            return;
        }

        $orderId = $request->getParam('id');
        $paymentStatusId = $request->getParam('cleared');
        $orderstatus = $request->getParam('status');
 
        if($paymentStatusId == 35 || $orderstatus == 4){
            $sql = "DELETE FROM `s_order_esd` WHERE `orderID` = ? ;";
            $db = Shopware()->Db();
            $db->query($sql, $orderId); 
        }
        
        return true;

    }

}
