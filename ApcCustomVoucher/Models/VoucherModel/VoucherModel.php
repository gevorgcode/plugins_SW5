<?php
namespace ApcCustomVoucher\Models\VoucherModel;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="apc_custom_voucher", options={"collate"="utf8_unicode_ci"})
 */
class VoucherModel extends ModelEntity
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
    * @ORM\Column(name="voucher_name", type="string", unique=true )
    */
    private $voucherName;
    
    /**
    * @var string
    * @ORM\Column(name="serial_id", type="string", unique=true)
    */
    private $serialId;

    /**
    * @var string
    * @ORM\Column(name="article_details_id", type="string")
    */
    private $articleDetailsID;

    /**
    * @var string
    * @ORM\Column(name="creator_id", type="string", nullable=false)
    */
    private $creatorId;
    
     /**
    * @var string
    * @ORM\Column(name="assign_user_id", type="string")
    */
    private $assignUserId;
    
     /**
    * @var string
    * @ORM\Column(name="voucher_email", type="string")
    */
    private $voucherEmail;
    
     /**
    * @var datetime
    * @ORM\Column(name="voucher_create_date", type="datetime")
    */
    private $voucherCreateDate;
    
    /**
    * @var boolean
    * @ORM\Column(name="voucher_used", type="boolean")
    */
    private $voucherUsed = false;
    
    /**
    * @var datetime
    * @ORM\Column(name="voucher_used_date", type="datetime")
    */
    private $voucherUsedDate;    

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $voucherName
     */
    public function setName($voucherName)
    {
        $this->voucherName = $voucherName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->voucherName;
    }

    /**
     * @param string $serialId
     */
    public function setSerialId($serialId)
    {
        $this->serialId = $serialId;
    }

    /**
     * @return string
     */
    public function getSerialId()
    {
        return $this->serialId;
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
     * @param string $creatorId
     */
    public function setCreatorId($creatorId)
    {
        $this->creatorId = $creatorId;
    }

    /**
     * @return string
     */
    public function getCreatorId()
    {
        return $this->creatorId;
    }
        
    /**
     * @param string $assignUserId
     */
    public function setAssignUserId($assignUserId)
    {
        $this->assignUserId = $assignUserId;
    }

    /**
     * @return string
     */
    public function getAssignUserId()
    {
        return $this->assignUserId;
    }
    
    /**
     * @param string $voucherEmail
     */
    public function setVoucherEmail($voucherEmail)
    {
        $this->voucherEmail = $voucherEmail;
    }

    /**
     * @return string
     */
    public function getVoucherEmail()
    {
        return $this->voucherEmail;
    }
        
    /**
     * @param datetime $voucherCreateDate
     */
    public function setVoucherCreateDate($voucherCreateDate)
    {
        $this->voucherCreateDate = $voucherCreateDate;
    }
    /**
     * @return string
     */
    public function getVoucherCreateDate()
    {
        return $this->voucherCreateDate;
    }
    
     /**
     * @param boolean $voucherUsed
     */
    public function setVoucherUsed($voucherUsed)
    {
        $this->voucherUsed = $voucherUsed;
    }
    /**
     * @return string
     */
    public function getVoucherUsed()
    {
        return $this->voucherUsed;
    }
    
    /**
     * @param datetime $voucherUsedDate
     */
    public function setVoucherUsedDate($voucherUsedDate)
    {
        $this->voucherUsedDate = $voucherUsedDate;
    }
    /**
     * @return string
     */
    public function getVoucherUsedDate()
    {
        return $this->voucherUsedDate;
    }
    
    /**
     * @return array
     */
    public function getVouchersByCreatorId($creatorId){
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->select('*')
            ->from('apc_custom_voucher')
            ->where('creator_id = :creator_id')
            ->setParameter('creator_id', $creatorId);

        $vouchers = $queryBuilder->execute()->fetchAll();
        
        return $vouchers;
    } 
    
    /**
     * @return array
     */
    public function getVoucher($voucherId){
        if(!$voucherId){
            $voucherId = $this->getId();
        }
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->select('*')
            ->from('apc_custom_voucher')
            ->where('id = :voucherId')
            ->setParameter('voucherId', $voucherId);

        $voucher = $queryBuilder->execute()->fetchAll();
        
        return $voucher;
    }
    public function destroyVoucher($voucherId){
        if(!$voucherId){
            return false;
        }
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->delete('apc_custom_voucher')
            ->where('id = :voucherId')
            ->setParameter('voucherId', $voucherId);

        $queryBuilder->execute();
         
        return true;
    }
   
}
