<?php
namespace ApcCustomVoucher\Models\VoucherModel;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="apc_custom_voucher_creator", options={"collate"="utf8_unicode_ci"})
 */
class VoucherCreatorModel extends ModelEntity
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
    * @ORM\Column(name="creator_login", type="string", unique=true )
    */
    private $creatorLogin;
    
     /**
    * @var string
    * @ORM\Column(name="creator_pass", type="string")
    */
    private $creatorPass;
    
    /**
    * @var boolean
    * @ORM\Column(name="creator_role_admin", type="boolean")
    */
    private $roleAdmin = false;
    
     /**
    * @var boolean
    * @ORM\Column(name="creator_active", type="boolean")
    */
    private $creatorActive = false;
    
//    use DateTime;
//    $now = new DateTime();
    
    /**
    * @var datetime
    * @ORM\Column(name="creator_create_date", type="datetime")
    */
    private $creatorCreateDate;
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id; 
    }

    /**
     * @param string $creatorLogin
     */
    public function setCreatorLogin($creatorLogin)
    {
        $this->creatorLogin = $creatorLogin;
    }
    /**
     * @return string
     */
    public function getCreatorLogin()
    {
        return $this->creatorLogin;
    }

        /**
     * @param string $creatorPass
     */
    public function setCreatorPass($creatorPass)
    {
        $this->creatorPass = $creatorPass;
    }
    /**
     * @return string
     */
    public function getCreatorPass()
    {
        return $this->creatorPass;
    }
        
    /**
     * @param boolean $roleAdmin
     */
    public function setRoleAdmin($roleAdmin)
    {
        $this->roleAdmin = $roleAdmin;
    }
    /**
     * @return string
     */
    public function getRoleAdmin()
    {
        return $this->roleAdmin;
    }   
    
    /**
     * @param boolean $creatorActive
     */
    public function setCreatorActive($creatorActive)
    {
        $this->creatorActive = $creatorActive;
    }
    /**
     * @return string
     */
    public function getCreatorActive()
    {
        return $this->creatorActive;
    }

        /**
     * @param datetime $creatorCreateDate
     */
    public function setCreatorCreateDate($creatorCreateDate)
    {
        $this->creatorCreateDate = $creatorCreateDate;
    }
    /**
     * @return string
     */
    public function getCreatorCreateDate()
    {
        return $this->creatorCreateDate;
    }

        
    public function deleteVoucherCreator($voucherCreatorId){
        if(!$voucherCreatorId){
            return false;
        }
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->delete('apc_custom_voucher_creator')
            ->where('id = :voucherCreatorId')
            ->setParameter('voucherCreatorId', $voucherCreatorId);

        $queryBuilder->execute();
         
        return true;
    }
   
}
