<?php

namespace ApcMultiDownload;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Model\ModelManager;
use ApcMultiDownload\Models\ApcEsdFiles;

class ApcMultiDownload extends Plugin{

    public function install(InstallContext $context){

        $this->createDatabase();

        $service = $this->container->get('shopware_attribute.crud_service');

        $this->generateAttributes($service);

   }

   public function activate(ActivateContext $activateContext)
   {
        $this->checkFiles();
   }

   public function uninstall(UninstallContext $context)
   {
//        $this->removeDatabase();
//
//        $service = $this->container->get('shopware_attribute.crud_service');
//
//        $this->removeAttributes($service);

   }

   private function createDatabase()
   {
       $modelManager = $this->container->get('models');
       $tool = new SchemaTool($modelManager);

       $classes = $this->getClasses($modelManager);

       $tool->updateSchema($classes, true);
   }

   private function removeDatabase()
   {
//       $modelManager = $this->container->get('models');
//       $tool = new SchemaTool($modelManager);
//
//       $classes = $this->getClasses($modelManager);
//
//       $tool->dropSchema($classes);
   }

   /**
    * @param ModelManager $modelManager
    * @return array
    */
   private function getClasses(ModelManager $modelManager)
   {
       return [
           $modelManager->getClassMetadata(ApcEsdFiles::class)
       ];
   }


   private function generateAttributes($service){
       $service->update('s_articles_esd_attributes', 'additional_download_active', 'boolean', [
          'label' => 'Activate Multiple Downloads',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 0,
      ]);

       $service->update('s_articles_esd_attributes', 'text_1', 'string', [
          'label' => 'Download Text 1',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 0,
      ]);

       $service->update('s_articles_esd_attributes', 'text_2', 'string', [
          'label' => 'Download Text 2',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 2,
      ]);

       $service->update('s_articles_esd_attributes', 'text_3', 'string', [
          'label' => 'Download Text 3',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 4,
      ]);

       $service->update('s_articles_esd_attributes', 'text_4', 'string', [
          'label' => 'Download Text 4',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 6,
      ]);
       
       $service->update('s_articles_esd_attributes', 'text_5', 'string', [
          'label' => 'Download Text 5 - EN',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 8,
      ]); 
       
       $service->update('s_articles_esd_attributes', 'text_6', 'string', [
          'label' => 'Download Text 6 - EN',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 10,
      ]); 
       
       $service->update('s_articles_esd_attributes', 'text_7', 'string', [
          'label' => 'Download Text 7 - FR',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 12,
      ]); 
       
       $service->update('s_articles_esd_attributes', 'text_8', 'string', [
          'label' => 'Download Text 8 - FR',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 14,
      ]); 

       $service->update('s_articles_esd_attributes', 'file_1', 'string', [
          'label' => 'Download Url 1',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 1,
      ]);

       $service->update('s_articles_esd_attributes', 'file_2', 'string', [
          'label' => 'Download Url 2',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 3,
      ]);

       $service->update('s_articles_esd_attributes', 'file_3', 'single_selection', [
           'label' => 'File 1',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 5,
           'entity' => 'ApcMultiDownload\Models\ApcEsdFiles',
       ]);

       $service->update('s_articles_esd_attributes', 'file_4', 'single_selection', [
           'label' => 'File 2',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 7,
           'entity' => 'ApcMultiDownload\Models\ApcEsdFiles',
       ]);
       
       $service->update('s_articles_esd_attributes', 'file_5', 'string', [
          'label' => 'Download Url 5 - EN',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 9,
       ]);
       
        $service->update('s_articles_esd_attributes', 'file_6', 'string', [
          'label' => 'Download Url 6 - EN',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 11,
       ]);
       
        $service->update('s_articles_esd_attributes', 'file_7', 'string', [
          'label' => 'Download Url 7 - FR',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 13,
       ]);
       
        $service->update('s_articles_esd_attributes', 'file_8', 'string', [
          'label' => 'Download Url 8 - FR',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 15,
       ]);

   }

   private function removeAttributes($service){

//      $service->delete('s_articles_esd_attributes', 'additional_download_active');
//      $service->delete('s_articles_esd_attributes', 'text_1');
//      $service->delete('s_articles_esd_attributes', 'text_2');
//      $service->delete('s_articles_esd_attributes', 'text_3');
//      $service->delete('s_articles_esd_attributes', 'text_4');
//      $service->delete('s_articles_esd_attributes', 'file_1');
//      $service->delete('s_articles_esd_attributes', 'file_2');
//      $service->delete('s_articles_esd_attributes', 'file_3');
//      $service->delete('s_articles_esd_attributes', 'file_4');

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
