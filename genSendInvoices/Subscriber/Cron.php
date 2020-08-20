<?php

namespace genSendInvoices\Subscriber;

use Enlight\Event\SubscriberInterface;
use genSendInvoices\Services\DocumentServiceInterface;
use genSendInvoices\Services\OrderDataInterface;
use Shopware\Components\Plugin\CachedConfigReader;

/**
 * Class Cron
 * @package genSendInvoices\Subscriber
 */
class Cron implements SubscriberInterface
{
    /**
     * @var DocumentServiceInterface
     */
    protected $invoiceService;

    /**
     * @var OrderDataInterface
     */
    protected $orderDataService;

    /**
     * @var array|mixed
     */
    protected $config;

    /**
     * Cron constructor.
     * @param DocumentServiceInterface $invoiceService
     * @param OrderDataInterface $orderDataService
     * @param $pluginName
     * @param CachedConfigReader $configReader
     */
    public function __construct(DocumentServiceInterface $invoiceService, OrderDataInterface $orderDataService, $pluginName, CachedConfigReader $configReader)
    {
        $this->invoiceService = $invoiceService;
        $this->orderDataService = $orderDataService;
        $this->config = $configReader->getByPluginName($pluginName);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Shopware_CronJob_GenGenerateInvoices' => 'cronGenerateInvoices',
            'Shopware_CronJob_GenSendInvoices' => 'cronSendInvoices'
        );
    }

    /**
     * @param \Shopware_Components_Cron_CronJob $job
     */
    public function cronGenerateInvoices(\Shopware_Components_Cron_CronJob $job)
    {
        //generate invoices
        $orders = $this->orderDataService->getOrdersWithoutInvoice($this->config['cronGenerateInvoices']);

        foreach($orders as $order) {
            $this->invoiceService->getDocument($order['id']);
        }
    }

    /**
     * @param \Shopware_Components_Cron_CronJob $job
     */
    public function cronSendInvoices(\Shopware_Components_Cron_CronJob $job)
    {
        //send invoices
        $orders = $this->orderDataService->getOrdersWithUnsendInvoices(new \DateTime($this->config['cronSendStartDate']), $this->config['cronSendInvoices']);

        foreach($orders as $order) {
            $this->invoiceService->sendDocumentMail($order['id'], $order['document_path'], $order['number']);
        }
    }
}
