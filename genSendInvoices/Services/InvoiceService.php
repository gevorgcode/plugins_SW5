<?php

namespace genSendInvoices\Services;

use Doctrine\ORM\EntityManager;
use \Shopware_Components_Document;
use \Zend_Mime_Part;
use \Zend_Mime;
use Zend_Mail_Transport_Exception;
use genSendInvoices\Models\InvoiceSentHistory;

/**
 * Class InvoiceService
 * @package genSendInvoices\Services
 */
class InvoiceService implements DocumentServiceInterface {

    /**
     * @var string
     */
    protected $documentDirectory;

    /**
     * @var OrderDataInterface
     */
    protected $orderData;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * InvoiceService constructor.
     * @param string $documentDirectory
     * @param OrderDataInterface $orderData
     * @param EntityManager $entityManager
     */
    public function __construct(string $documentDirectory, OrderDataInterface $orderData, EntityManager $entityManager) {
        $this->documentDirectory = rtrim($documentDirectory, '/');
        $this->orderData = $orderData;
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $orderId
     * @return mixed|null|string
     */
    public function getDocument(int $orderId) {
        $document = $this->getExistingDocument($orderId);

        if(!$document) {
            $document = $this->generateInvoice($orderId);
        }

        return $document;
    }

    /**
     * @param $orderId
     * @return null|string
     */
    public function getExistingDocument($orderId) {
        $documentHash = $this->orderData->getOrderInvoiceHash($orderId);

        if(!$documentHash) {
            return null;
        } else {
            return $this->getDocumentPath($documentHash);
        }
    }

    /**
     * @param int $orderId
     * @return null|string
     * @throws \Enlight_Event_Exception
     * @throws \Enlight_Exception
     */
    public function generateInvoice(int $orderId) {
        $document = Shopware_Components_Document::initDocument(
            $orderId,
            1,
            [
                '_renderer' => 'pdf',
                '_preview' => false,
                'shippingCostsAsPosition' => true,
            ]
        );

        $document->render();

        return $this->getDocumentPath($document->_documentHash);
    }

    /**
     * @param string $hash
     * @return null|string
     */
    public function getDocumentPath(string $hash) {
        $filePath = $this->documentDirectory . '/' . $hash . '.pdf';

        if(file_exists($filePath)) {
            return $filePath;
        } else {
            return null;
        }
    }

    /**
     * @param int $orderId
     * @param string $documentPath
     * @param string $fileName
     * @return \Enlight_Components_Mail|void
     */
    public function createInvoiceMail(int $orderId, $documentPath = '', $fileName = '') {
        if(!$documentPath) {
            $documentPath = $this->getExistingDocument($orderId);
        }

        if(!$documentPath) {
            return;
        }

        if(!$fileName) {
            $fileName = $orderId;
        }

        $mail = Shopware()->Modules()->Order()->createStatusMail($orderId, 0, 'sORDERDOCUMENTS');
        $mail->addAttachment($this->createInvoiceAttachment($documentPath, $fileName));

        return $mail;
    }

    /**
     * @param $filePath
     * @param $fileName
     * @return Zend_Mime_Part
     */
    public function createInvoiceAttachment($filePath, $fileName)
    {
        $content = file_get_contents($filePath);
        $zendAttachment = new Zend_Mime_Part($content);
        $zendAttachment->type = 'application/pdf';
        $zendAttachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
        $zendAttachment->encoding = Zend_Mime::ENCODING_BASE64;
        $zendAttachment->filename = $fileName . '.pdf';

        return $zendAttachment;
    }

    /**
     * @param int $id
     * @param string $documentPath
     * @param string $fileName
     * @param bool $storeLog
     * @return mixed|void
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function sendDocumentMail(int $id, $documentPath = '', $fileName = '', $storeLog = true) {
        $mail = $this->createInvoiceMail($id, $documentPath, $fileName );

        if($mail) {
            try {
                $history = new InvoiceSentHistory($id);

                $mail->send();
            } catch (Zend_Mail_Transport_Exception $e) {
                //unset on exception
                unset($history);
            }
        }

        // persist if sent
        if($history) {
            $this->entityManager->persist($history);
        }

        // store to history
        if($storeLog && $history) {
            $this->entityManager->flush();
        }
    }
}