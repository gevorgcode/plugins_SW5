<?php

namespace GenImages;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class GenImages extends Plugin
{    
    /**
     * @param Plugin\Context\InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $this->createAttribute();        
        $this->createAlbum();        
        return parent::install($context);
    }
    /**
     * @param Plugin\Context\ActivateContext $context
     */
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }
    
    public function uninstall(UninstallContext $context)
    {
        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }
    
    private function createAttribute() {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->update('s_user_attributes', 'userimage', 'string');
        Shopware()->Models()->generateAttributeModels(['s_user_attributes']);        
    }
    
    private function createAlbum() {
        $albumId = '-87';
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->select(['m.name'])
            ->from('s_media_album', 'm')
            ->where('id = :id')
            ->setParameter('id', $albumId);
        $builderExecute = $queryBuilder->execute();
        $mediaAlbumName = $builderExecute->fetchColumn();        
        if ($mediaAlbumName){
            return;
        }
        
        //create albub
        $albumname = 'User photo';
        $position = 15;
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->insert("s_media_album")            
            ->setValue('id', ':id')            
            ->setValue('name', ':name')            
            ->setValue('position', ':position')
            ->setParameter('id', $albumId)            
            ->setParameter('name', $albumname)            
            ->setParameter('position', $position)
            ->execute();
        
        //create album settings(folder icon, thumbnails...)
        $thumbnail_size = '200x200;400x400;600x600;1280x1280;1920x1920';
        $icon = 'sprite-pictures';
        $queryBuilder = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $queryBuilder->insert("s_media_album_settings")            
            ->setValue('albumID', ':albumID')            
            ->setValue('create_thumbnails', '1')            
            ->setValue('thumbnail_size', ':thumbnail_size')
            ->setValue('icon', ':icon')
            ->setValue('thumbnail_high_dpi', '1')
            ->setValue('thumbnail_quality', '90')
            ->setValue('thumbnail_high_dpi_quality', '70')
            ->setParameter('albumID', $albumId)            
            ->setParameter('thumbnail_size', $thumbnail_size)
            ->setParameter('icon', $icon)
            ->execute();
    }
}


