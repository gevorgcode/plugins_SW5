<?php

namespace genSendInvoices\Services;

/**
 * Interface DocumentServiceInterface
 * @package genSendInvoices\Services
 */
interface DocumentServiceInterface {

    /**
     * @param int $orderId
     * @return mixed
     */
    public function getDocument(int $orderId);

    /**
     * @param int $id
     * @param string $documentPath
     * @param string $fileName
     * @param bool $storeLog
     * @return mixed
     */
    public function sendDocumentMail(int $id, $documentPath = '', $fileName = '', $storeLog = true);

}