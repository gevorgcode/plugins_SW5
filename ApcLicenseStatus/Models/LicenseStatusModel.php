<?php
namespace ApcLicenseStatus\Models;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="apc_license_status", options={"collate"="utf8_unicode_ci"})
 */
class LicenseStatusModel extends ModelEntity
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
    * @ORM\Column(name="user_email", type="string")
    */
    private $userEmail;

    /**
    * @var string
    * @ORM\Column(name="order_number", type="string")
    */    
    private $orderNumber;
    
    /**
    * @var string
    * @ORM\Column(name="order_detail_id", type="string")
    */
    private $orderDetailId;
    
    /**
    * @var string
    * @ORM\Column(name="client_ip", type="string")
    */
    private $clientIp;
    
    /**
    * @var string
    * @ORM\Column(name="client_country", type="string")
    */
    private $clientCountry;
       
    /**
    * @var string
    * @ORM\Column(name="client_city", type="string")
    */
    private $clientCity;
         
    /**
    * @var string
    * @ORM\Column(name="mail_type", type="string")
    */
    private $mailType;
       
     /**
    * @var datetime
    * @ORM\Column(name="sent_date", type="datetime")
    */
    private $sentDate;    

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }    
    
   /**
     * @param string $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

   /**
     * @param string $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }
    
   /**
     * @param string $orderDetailId
     */
    public function setOrderDetailId($orderDetailId)
    {
        $this->orderDetailId = $orderDetailId;
    }

    /**
     * @return string
     */
    public function getOrderDetailId()
    {
        return $this->orderDetailId;
    }
    
    /**
     * @param string $clientIp
     */
    public function setClientIp($clientIp)
    {
        $this->clientIp = $clientIp;
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }
    
    /**
     * @param string $clientCountry
     */
    public function setClientCountry($clientCountry)
    {
        $this->clientCountry = $clientCountry;
    }

    /**
     * @return string
     */
    public function getClientCountry()
    {
        return $this->clientCountry;
    }
    
    /**
     * @param string $clientCity
     */
    public function setClientCity($clientCity)
    {
        $this->clientCity = $clientCity;
    }

    /**
     * @return string
     */
    public function getClientCity()
    {
        return $this->clientCity;
    }
    
    /**
     * @param string $mailType
     */
    public function setMailType($mailType)
    {
        $this->mailType = $mailType;
    }

    /**
     * @return string
     */
    public function getMailType()
    {
        return $this->mailType;
    }
    
    /**
     * @param datetime $sentDate
     */
    public function setSentDate($sentDate)
    {
        $this->sentDate = $sentDate;
    }
    /**
     * @return string
     */
    public function getSentDate()
    {
        return $this->sentDate;
    }   
}
