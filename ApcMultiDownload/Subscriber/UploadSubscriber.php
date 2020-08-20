<?php

namespace ApcMultiDownload\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;

class UploadSubscriber implements SubscriberInterface
{
    private $pluginDir = null;

    public function __construct($pluginBaseDirectory)
    {
        $this->pluginDir = $pluginBaseDirectory;
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Backend_Article' => 'onEsdUpload',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Account' => 'onFrontendAccount',
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onEsdUpload(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();

        $actionName = $request->getActionName();
        if($actionName != 'uploadEsdFile'){
            return;
        }
        $this->checkFiles();

        return;

    }
    
     public function onFrontendAccount(\Enlight_Event_EventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $actionName = $request->getActionName();
        //view in theme NewItNerd (downloads.tpl)
        if (($actionName == 'downloads')){ 
            $sDownloads = $view->getAssign(sDownloads);
            foreach ($sDownloads as &$sDownload){
                foreach ($sDownload as &$items){
                    foreach ($items as &$item){
                        $item['esdId'] = $this->getEsdId($item['articleDetailID']);
                        $item['esdAttr'] = $this->getEsdAttr($item['esdId']);
                    }
                }                
            }  
            $view->assign('sDownloads', $sDownloads);
        } 
     }
    
    private function getEsdId($articleDetailsId){
        //var_dump($articleDetailsId); exit;
        return Shopware()->Db()->fetchOne(
            'SELECT s_articles_esd.id AS esdId
            FROM s_articles_esd                
            WHERE s_articles_esd.articledetailsID = :detailsId',
            ['detailsId' => $articleDetailsId] 
        );       
    }
    
    private function getEsdAttr($esdId){
        return Shopware()->Db()->fetchRow(
                    'SELECT *
                    FROM s_articles_esd_attributes                
                    WHERE s_articles_esd_attributes.esdID = :esdId',
                    ['esdId' => $esdId]
                );   
    }

    private function checkFiles(){
         $filePath = Shopware()->DocPath('files_' . Shopware()->Config()->get('sESDKEY'));
         if (!file_exists($filePath)) {
             return;
         }
         $sql = 'TRUNCATE TABLE `apc_esd_files` ; ';
         Shopware()->Db()->query($sql);
         $sql = 'INSERT INTO `apc_esd_files` SET `name` = ? ;';
         $result = [];
         foreach (new \DirectoryIterator($filePath) as $file) {
             if ($file->isDot() || strpos($file->getFilename(), '.') === 0) {
                 continue;
             }
             $count = Shopware()->Db()->fetchOne('SELECT COUNT(*) FROM `apc_esd_files` WHERE `name` = ?;',array($file->getFilename()));
             if($count == 0){
                 Shopware()->Db()->query($sql,array($file->getFilename()));
             }
         }
         return;
    }


}
