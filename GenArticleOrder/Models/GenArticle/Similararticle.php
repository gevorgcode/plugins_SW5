<?php
namespace GenArticleOrder\Models\GenArticle;
use Shopware\Components\Model\ModelEntity,
    Doctrine\ORM\Mapping AS ORM,
    Symfony\Component\Validator\Constraints as Assert,
    Doctrine\Common\Collections\ArrayCollection;

/**
 * Similararticle Model
 * <br>
 * This Model represents a single similar article. 
 *
 *
 *
 * Indices for gen_articles_similar_sort:
 * <code>
 *   - PRIMARY KEY (`id`)
 * </code>
 *
 * @ORM\Entity
 * @ORM\Table(name="gen_articles_similar_sort")
 */
class Similararticle extends ModelEntity
{
    /**
     * Autoincrement ID
     *
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * relatedarticle
     *
     * @var integer $relatedarticle
     *
     * @ORM\Column(name="relatedarticle", type="integer", nullable=false)
     */
    private $relatedarticle;
    
    
    /**
     * articleID
     *
     * @var integer $articleID
     *
     * @ORM\Column(name="articleID", type="integer", nullable=false)
     */
    private $articleID;
    
    /**
     * sort
     *
     * @var integer $sort
     *
     * @ORM\Column(name="sort", type="integer", nullable=false)
     */
    private $sort;
    
    /**
     * OWNING SIDE
     * @var Article
     * @ORM\ManyToOne(targetEntity="GenArticleOrder\Models\GenArticle\Article", inversedBy="relatedsimilararticle")
     * @ORM\JoinColumn(name="articleID", referencedColumnName="id")
     */
    protected $article;
    
    public function __construct()
    {
        
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the articleID
     *
     * @param integer $articleID
     * @return Similararticle
     */
    public function setArticleID($articleID)
    {
        $this->articleID = $articleID;
        return $this;
    }
    
 	/**
     * Returns the articleID of the similararticle
     *
     * @return integer
     */
    public function getArticleID()
    {
        return $this->articleID;
    }
    
    /**
     * Set the relatedarticle
     *
     * @param integer $relatedarticle
     * @return Relatedarticle
     */
    public function setRelatedarticle($relatedrarticle)
    {
    	$this->relatedarticle = $relatedarticle;
    	return $this;
    }
    
    /**
     * Returns relatedarticle
     *
     * @return integer
     */
    public function getRelatedarticle()
    {
    	return $this->relatedarticle;
    }
    
    /**
     * Set the sort
     *
     * @param integer $sort
     * @return Similararticle
     */
    public function setSort($sort)
    {
    	$this->sort = $sort;
    	return $this;
    }
    
    /**
     * Returns sort
     *
     * @return string
     */
    public function getSort()
    {
    	return $this->sort;
    }
    
 	/**
     * @return \GenArticleOrder\Models\GenArticle\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param \GenArticleOrder\Models\GenArticle\Article $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }
}
