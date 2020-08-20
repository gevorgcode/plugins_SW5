<?php

namespace genSendInvoices\Services;

/**
 * Interface OrderDataInterface
 * @package genSendInvoices\Services
 */
interface OrderDataInterface {
    /**
     * @param int $maxQuantity
     * @return mixed
     */
    public function getOrdersWithoutInvoice($maxQuantity = 0);

    /**
     * @param \DateTime $startDate
     * @param int $maxQuantity
     * @return mixed
     */
    public function getOrdersWithUnsendInvoices(\DateTime $startDate, $maxQuantity = 0) ;

    /**
     * @param int $orderId
     * @return mixed
     */
    public function getOrderInvoiceHash(int $orderId);

    /**
     * @param string $number
     * @return mixed
     */
    public function getOrderIdByNumber(string $number);
}