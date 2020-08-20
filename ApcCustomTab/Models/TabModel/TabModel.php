<?php
namespace ApcCustomTab\Models\TabModel;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="apc_custom_tab", options={"collate"="utf8_unicode_ci"})
 */
class TabModel extends ModelEntity
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
    * @ORM\Column(name="tab_name", type="string")
    */
    private $tabName;

    /**
    * @var string
    * @ORM\Column(name="tab_content", type="string")
    */
    private $tabContent;

    /**
    * @var string
    * @ORM\Column(name="article_id", type="string")
    */
    private $articleId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $tabContent
     */
    public function setContent($tabContent)
    {
        $this->tabContent = $tabContent;
    }
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->tabContent;
    }

    /**
     * @param string $articleId
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    }
    /**
     * @return string
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @param string $tabName
     */
    public function setName($tabName)
    {
        $this->tabName = $tabName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->tabName;
    }
    
    /**
     * @return array
     */
    public function getTabsByArticle($articleId){
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->select('*')
            ->from('apc_custom_tab')
            ->where('article_id = :articleId')
            ->setParameter('articleId', $articleId);

        $tabs = $queryBuilder->execute()->fetchAll();
        
        return $tabs;
    } 
    
    /**
     * @return array
     */
    public function getTab($tabId){
        if(!$tabId){
            $tabId = $this->getId();
        }
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->select('*')
            ->from('apc_custom_tab')
            ->where('id = :tabId')
            ->setParameter('tabId', $tabId);

        $tab = $queryBuilder->execute()->fetchAll();
        
        return $tab;
    }
    public function destroyTab($tabId){
        if(!$tabId){
            return false;
        }
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->delete('apc_custom_tab')
            ->where('id = :tabId')
            ->setParameter('tabId', $tabId);

        $queryBuilder->execute();
         
        return true;
    }
   
}
