<?php

/**
 * Class Shopware_Controllers_Frontend_Invoice
 */
class Shopware_Controllers_Frontend_Invoice extends Enlight_Controller_Action
{
    /**
     * @throws Exception
     */
    public function indexAction()
    {
        $name = basename($this->Request()->getParam('id')) . '.pdf';
        $file = Shopware()->Container()->getParameter('shopware.app.documentsdir') . $name;
        if (!file_exists($file)) {
            $this->redirect(['controller' => 'account', 'action' => 'orders']);

            return;
        }

        $response = $this->Response();
        $response->setHeader('Cache-Control', 'public');
        $response->setHeader('Content-Description', 'File Transfer');
        $response->setHeader('Content-disposition', 'attachment; filename='.$name);
        $response->setHeader('Content-Type', 'application/pdf');
        $response->setHeader('Content-Transfer-Encoding', 'binary');
        $response->setHeader('Content-Length', filesize($file));
        $response->sendHeaders();

        readfile($file);
        exit;
    }


}
