<?php

namespace genSendInvoices\Subscriber;

use Enlight\Event\SubscriberInterface;
use genSendInvoices\Services\DocumentServiceInterface;
use genSendInvoices\Services\OrderDataInterface;
use Shopware\Components\Plugin\CachedConfigReader;

/**
 * Class Frontend
 * @package genSendInvoices\Subscriber
 */
class Frontend implements SubscriberInterface
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
     * Frontend constructor.
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
            'sOrder::sSaveOrder::after' => 'afterOrder',
            'Enlight_Controller_Action_PostDispatch_Frontend_Account' => 'provideInvoiceInOrderHistory'
        );
    }

    /**
     * @param \Enlight_Hook_HookArgs $args
     */
    public function afterOrder(\Enlight_Hook_HookArgs $args)
    {
        //generate invoice
        if ($this->config["afterOrderAction"] == 1 || $this->config["afterOrderAction"] == 2) {
            $number = $args->getReturn();

            $orderId = $this->orderDataService->getOrderIdByNumber($number);
            $document = $this->invoiceService->getDocument($orderId);
        }

        //send invoice mail
        if ($this->config["afterOrderAction"] == 2) {
            $this->invoiceService->sendDocumentMail($orderId, $document, $number, true);
        }
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     */
    public function provideInvoiceInOrderHistory(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->getSubject();
        $view = $controller->View();
        $actionName = $controller->Request()->getActionName();

        if($actionName == "orders")
        {
            $orderVariables = $view->getAssign();
            $orders = $orderVariables['sOpenOrders'];

            $this->orderDataService->getInvoiceDocumentForAccountOrdersList($orders);

            $orderVariables['sOpenOrders'] = $orders;
            $view->assign($orderVariables);
        }
    }
}