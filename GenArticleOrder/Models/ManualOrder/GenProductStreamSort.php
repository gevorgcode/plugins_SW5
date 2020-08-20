<?php
namespace GenArticleOrder\Models\ManualOrder;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Shopware\Components\Model\ModelEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="gen_product_streams_sort")
 */
class GenProductStreamsSort extends ModelEntity
{

    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer $streamId
     *
     * @ORM\Column(name="streamID", type="integer")
     */
    private $streamID;

    /**
     * @var integer $articleID
     *
     * @ORM\Column(name="articleID", type="integer")
     */
    private $articleID;

    /**
     * @var integer $order
     *
     * @ORM\Column(name="order", type="integer")
     */
    private $order;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getArticleID()
    {
        return $this->articleID;
    }

    /**
     * @param integer $articleId
     */
    public function setArticleID($articleID)
    {
        $this->articleID = $articleID;
    }

    /**
     * @return integer
     */
    public function getStreamID()
    {
        return $this->streamID;
    }

    /**
     * @param integer $categoryID
     */
    public function setStreamID($streamID)
    {
        $this->streamID = $streamID;
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param integer $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }
}
