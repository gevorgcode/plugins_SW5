<?php
namespace AknCronMailLosts\Models;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="akn_lost_customer_email_history", options={"collate"="utf8_unicode_ci"})
 */
class LostCustomerEmailHistory extends ModelEntity
{
    /**
    * @var int
    *
    * @ORM\Column(name="id", type="integer", nullable=false)
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    */
    private $id;

    /**
    * @var string
    * @ORM\Column(name="user_id", type="string", unique=false)
    */
    private $userId;

    /**
    * @var string
    * @ORM\Column(name="user_email", type="string", unique=false)
    */
    private $userEmail;

    /**
    * @var string
    * @ORM\Column(name="voucher_name", type="string", unique=false)
    */
    private $voucherName;

    /**
    * @var string
    * @ORM\Column(name="email_type", type="string", unique=false )
    */
    private $emailType; //lost or birthday

    /**
    * @var string
    * @ORM\Column(name="last_order_id", type="string", unique=false)
    */
    private $lastOrderId;   

    /**
    * @var datetime
    * @ORM\Column(name="send_date", type="datetime")
    */
    private $sendDate;  
}