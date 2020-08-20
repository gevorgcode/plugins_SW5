<?php

namespace ApcB2bPage;

use Shopware\Components\Plugin;

/**
 * Class ApcB2bPage
 * @package ApcB2bPage
 */
class ApcB2bPage extends Plugin
{
    /**
     * @param Plugin\Context\InstallContext $context
     */
    public function install(Plugin\Context\InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->update('s_user_attributes', 'b2b_status', 'string');
                
        $metaDataCache = Shopware()->Models()->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        Shopware()->Models()->generateAttributeModels(['s_user_attributes']);
    }
    /**
     * @param Plugin\Context\ActivateContext $context
     */
    public function activate(Plugin\Context\ActivateContext $context)
    {
        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }

    /**
     * @param Plugin\Context\UninstallContext $context
     */
    public function uninstall(Plugin\Context\UninstallContext $context)
    {
        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }     
}










