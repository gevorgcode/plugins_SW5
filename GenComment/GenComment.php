<?php

namespace GenComment;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class GenComment extends Plugin
{    
    /**
     * @param Plugin\Context\InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $this->createAttribute();        
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
        $service->update('s_user_attributes', 'comment', 'string');
        Shopware()->Models()->generateAttributeModels(['s_user_attributes']);
    }
}
