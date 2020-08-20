<?php

namespace genSendInvoices\Services;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;

/**
 * TODO
 * Instead of implementing a service we should check if injecting the order repository is an option
 */

class OrderData implements OrderDataInterface {

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $documentDirectory;

    /**
     * OrderData constructor.
     * @param EntityManager $entityManager
     * @param string $documentDirectory
     */
    public function __construct(EntityManager $entityManager, string $documentDirectory)
    {
        $this->entityManager = $entityManager;
        $this->documentDirectory = $documentDirectory;
    }

    /**
     * @param int $maxQuantity
     * @return array
     */
    public function getOrdersWithoutInvoice($maxQuantity = 0)
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select(['orders.id', 'orders.number'])
            ->from('Shopware\Models\Order\Order', 'orders')
            ->leftJoin('Shopware\Models\Order\Document\Document', 'document', Join::WITH, 'document.typeId = 1 AND orders.id = document.orderId')
            ->where('document.id IS NULL')
            ->orderBy('orders.id', 'ASC')
            ->getQuery();

        if($maxQuantity) {
            $query->setMaxResults($maxQuantity);
        }

        return $query->getResult();
    }

    /**
     * @param \DateTime $startDate
     * @param int $maxQuantity
     * @return array
     */
    public function getOrdersWithUnsendInvoices(\DateTime $startDate, $maxQuantity = 0)
    {
         $query = $this->entityManager->createQueryBuilder()
            ->select(['orders.id', 'orders.number', 'CONCAT(:document_directory, document.hash, \'.pdf\') AS document_path'])
            ->from('Shopware\Models\Order\Order', 'orders')
            ->leftJoin('Shopware\Models\Order\Document\Document', 'document', Join::WITH, 'document.typeId = 1 AND orders.id = document.orderId')
            ->leftJoin('genSendInvoices\Models\InvoiceSentHistory', 'history', Join::WITH, 'orders.id = history.orderId')
            ->where('document.id IS NOT NULL')
            ->andWhere('orders.orderTime >= :start_date')
            ->andWhere('history.id IS NULL')
            ->orderBy('orders.id', 'ASC')
            ->setParameters(array('document_directory' => $this->documentDirectory, 'start_date' => $startDate))
            ->getQuery();

        if($maxQuantity) {
            $query->setMaxResults($maxQuantity);
        }

        return $query->getResult();
    }

    /**
     * @param int $orderId
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOrderInvoiceHash(int $orderId)
    {
        $documentHash = $this->entityManager->createQueryBuilder()
            ->select(['document.hash'])
            ->from('Shopware\Models\Order\Document\Document', 'document')
            ->where('document.typeId = 1')
            ->andWhere('document.orderId = ?1')
            ->setParameter(1, $orderId)
            ->getQuery()
            ->getOneOrNullResult();

        return $documentHash['hash'];
    }

    /**
     * @param string $number
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOrderIdByNumber(string $number)
    {
        $id = $this->entityManager->createQueryBuilder()
            ->select(['orders.id'])
            ->from('Shopware\Models\Order\Order', 'orders')
            ->andWhere('orders.number = ?1')
            ->setParameter(1, $number)
            ->getQuery()
            ->getSingleScalarResult();

        return $id;
    }

    /**
     * @param $orders
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getInvoiceDocumentForAccountOrdersList(&$orders)
    {
        foreach($orders as &$order)
        {
            $qb = Shopware()->Models()->createQueryBuilder();
            $result = $qb->select('document.hash')
                ->from('Shopware\Models\Order\Document\Document', 'document')
                ->where('document.typeId = 1')
                ->andWhere('document.orderId = ?1')
                ->setParameter(1, $order["id"])
                ->getQuery()
                ->getOneOrNullResult()
            ;
            $order["invoice"] = reset($result);
        }

        return $orders;
    }

}