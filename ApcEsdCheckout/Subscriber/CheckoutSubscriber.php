<?php

namespace ApcEsdCheckout\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;

class CheckoutSubscriber implements SubscriberInterface
{
    private $pluginDir = null;

    public function __construct($pluginBaseDirectory)
    {
        $this->pluginDir = $pluginBaseDirectory;
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Order' => ['onPaymentStatusChange', 1 ],
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => ['onPaymentStatusChange', 1]
        ];
    }

      


    public function onPaymentStatusChange(\Enlight_Event_EventArgs $args){

        $controller = $args->getSubject();
        $request = $controller->Request();


        $actionName = $request->getActionName();
        
        
        
        if($actionName == 'save'){
            $orderId = $request->getParam('id');
            $paymentStatusId = $request->getParam('cleared');
        }elseif($actionName == 'finish'){
            $orderNumber = $controller->View()->getAssign("sOrderNumber");
            $order = Shopware()->Db()->fetchRow(
                   'SELECT * FROM `s_order` WHERE `ordernumber`=:ordernumber;',
                   [':ordernumber' => $orderNumber]
               );
            $orderId = $order["id"];
            $paymentStatusId = $order["cleared"];
        }else{
            return;
        }


        
        
        if($paymentStatusId != 12){
            return;
        }

        $orderDetails = Shopware()->Db()->fetchAll('SELECT `esdarticle`, `id`,`name`,`articleID` FROM `s_order_details` WHERE `ordernumber` = (SELECT `ordernumber` FROM `s_order` WHERE `id` = ?)',array($orderId));
        $userId = Shopware()->Db()->fetchOne('SELECT `userID` FROM `s_order` WHERE `id` = ?',[$orderId]);
        $userData = Shopware()->Db()->fetchRow("SELECT `salutation`,`lastname`,`email` FROM `s_user` WHERE `id` = ?",[$userId]);
        $context;
        foreach($orderDetails as $detail){

            if($detail['esdarticle'] == 1){
                $data[$detail['id']]['name'] = $detail['name'];
                $getSerial = Shopware()->Db()->fetchAll(
                        'SELECT serialnumber FROM s_articles_esd_serials, s_order_esd
                        WHERE userID = ?
                        AND orderID = ?
                        AND orderdetailsID = ?
                        AND s_order_esd.serialID = s_articles_esd_serials.id',
                        [
                            $userId,
                            $orderId,
                            $detail['id'],
                        ]
                    );
                if ($numbers){
                    $numbers = [];
                }
                foreach ($getSerial as $serial) {
                    $numbers[] = $serial['serialnumber'];
                }
                if(!empty($numbers)){
                    $data[$detail['id']]['serial'] = implode($numbers,", ");
                }
                $data[$detail['id']]['downloads'] = Shopware()->Container()->get('apc_multi_download.download_component')->getMultipleDownloads($detail['articleID']);
            }
        }

        $context['user'] = $userData;
        $context['details'] = $data;        
//        var_dump(123); exit;
        $mail = Shopware()->TemplateMail()->createMail('itnerdDownloadEmail',$context);
        $mail->addTo($userData['email']);
        try {
            $mail->send();
        } catch(\Exception $ex) {
           die($ex->getMessage());
        }
        return;
    }
}
