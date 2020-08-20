<?php

namespace ApcInvoiceEmail;

use Shopware\Components\Plugin;

class ApcInvoiceEmail extends Plugin
{
    
    public function install(Plugin\Context\InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        //$service->update('s_user_attributes', 'invoice_email', 'string');
        
        $service->update('s_user_attributes', 'invoice_email', 'string', [
            'label' => 'Rechnung E-mail',
            'supportText' => 'Die Rechnung wird an diese E-Mail gesendet.',
          
            //attribute will be displayed in the backend module
            'displayInBackend' => true,
        
            //user can modify the attribute in the free text field module
            'custom' => true,

         ]);
        
        
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

