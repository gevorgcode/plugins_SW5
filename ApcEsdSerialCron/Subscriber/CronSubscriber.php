<?php

namespace ApcEsdSerialCron\Subscriber;

use Enlight\Event\SubscriberInterface;

class CronSubscriber implements SubscriberInterface
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
            'Shopware_CronJob_EsdSerialCleanup' => 'onEsdCleanup',
        ];
    }

	public function onEsdCleanup(\Shopware_Components_Cron_CronJob $job) {
        $canceledOrderStatusId = 4;
        $processCanceledPaymentStatusId = 35;
        $completelyPaidPaymentStatusId = 12;
        
        $db = Shopware()->Db();
        $sOrder = Shopware()->Modules()->Order();
        
        $sql = "SELECT
                `s_order_esd`.`orderID`
                FROM `s_order_esd`
                LEFT JOIN `s_order`
                    ON(`s_order`.`id` = `s_order_esd`.`orderID`)
                WHERE
                `s_order`.`cleared` <> ?
                AND (`s_order`.`ordertime` < NOW() - INTERVAL 4 DAY)
        ;";
        
        $orderIds = $db->fetchCol($sql,$completelyPaidPaymentStatusId);
        
        if(empty($orderIds)) {
            return;
        }
        
        foreach($orderIds as $orderId) {
            $sOrder->setOrderStatus($orderId,$canceledOrderStatusId,false);
            $sOrder->setPaymentStatus($orderId,$processCanceledPaymentStatusId,false);
        }
        
        $sql = "DELETE FROM `s_order_esd`
                WHERE `orderID` IN(".str_repeat('?,',count($orderIds) - 1)."?) ;";
        
        $db->query($sql,$orderIds);
        
        return true;
	}

}

            
            