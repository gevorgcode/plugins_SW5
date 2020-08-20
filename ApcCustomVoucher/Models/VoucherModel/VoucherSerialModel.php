<?php
namespace ApcCustomVoucher\Models\VoucherModel;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="apc_custom_voucher_serials", options={"collate"="utf8_unicode_ci"})
 */
class VoucherSerialModel extends ModelEntity
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
    * @ORM\Column(name="serial_number", type="string")
    */
    private $serialNumber; 
    
    /**
    * @var string
    * @ORM\Column(name="article_details_id", type="string")
    */
    private $articleDetailsID;   
    
    /**
    * @var boolean
    * @ORM\Column(name="serial_assigned", type="boolean")
    */
    private $serialAssigned;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    /**
     * @param string $serialNumber
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;
    }

    /**
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }    
   
    
    /**
     * @param string $articleDetailsID
     */
    public function setArticleDetailsID($articleDetailsID)
    {
        $this->articleDetailsID = $articleDetailsID;
    }

    /**
     * @return string
     */
    public function getArticleDetailsID()
    {
        return $this->articleDetailsID;
    }    
    
    
    /**
     * @param boolean $serialAssigned
     */
    public function setSerialAssigned($serialAssigned)
    {
        $this->serialAssigned = $serialAssigned;
    }
    /**
     * @return string
     */
    public function getSerialAssigned()
    {
        return $this->serialAssigned;
    }
}
