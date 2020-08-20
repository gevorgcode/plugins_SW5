<?php


class Shopware_Controllers_Frontend_ApcDownload extends Enlight_Controller_Action
{
    public function modalAction()
    {
        $this->View()->addTemplateDir(__DIR__ . '/../../Resources/views/');
        $this->View()->loadTemplate('frontend/apc_download/modal.tpl');

        $articleId = $this->Request()->getParam('articleId');
        $esdLink = $this->Request()->getParam('esdLink');

        if(empty($articleId)){
            return;
        }

        $downloadData = Shopware()->Container()->get('apc_multi_download.download_component')->getMultipleDownloads($articleId);

        $articleName = Shopware()->Db()->fetchOne('SELECT `name` FROM `s_articles` WHERE `id` = ?', array($articleId));

        $this->View()->assign('downloads', $downloadData);
        $this->View()->assign('articleName', $articleName);

    }

}
