<?php

namespace genSendInvoices\Models;

use Doctrine\ORM\Mapping as ORM;
use \Shopware\Components\Model\ModelEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="gen_invoice_sent_history")
 */
class InvoiceSentHistory extends ModelEntity {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct(int $orderId)
    {
        $this->setDate(new \DateTime());
        $this->setOrderId($orderId);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


}