<?php

namespace ApcSpecPrice;

use Shopware\Components\Plugin;

class ApcSpecPrice extends Plugin
{
    
    public function install(Plugin\Context\InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        //$service->update('s_user_attributes', 'invoice_email', 'string');
        
        $service->update('s_articles_attributes', 'spec_price_link_active', 'boolean', [
            'label' => 'Spec Price Active:',
            'supportText' => 'If you uncheck this checkbox, values of "spec price" and "spec link" will not make sense',
                      
            //attribute will be displayed in the backend module
            'displayInBackend' => true,
            
            //numeric position for the backend view, sorted ascending
            'position' => 4,
        
            //user can modify the attribute in the free text field module
            'custom' => true,

         ]);
        
        $service->update('s_articles_attributes', 'spec_price', 'float', [
            'label' => 'Spec Price',
            'supportText' => 'Add special price for this article',
            
            //attribute will be displayed in the backend module
            'displayInBackend' => true,            
            
            //numeric position for the backend view, sorted ascending
            'position' => 5,
        
            //user can modify the attribute in the free text field module
            'custom' => true,

         ]);
        
        $service->update('s_articles_attributes', 'spec_price_link', 'string', [
            'label' => 'Spec Price Link',
            'supportText' => 'Do not change this link, it is generated automatically',
                      
            //attribute will be displayed in the backend module
            'displayInBackend' => true,
            
            //numeric position for the backend view, sorted ascending
            'position' => 6,
        
            //user can modify the attribute in the free text field module
            'custom' => true,

         ]);        
        
        
        
        $metaDataCache = Shopware()->Models()->getConfiguration()->getMetadataCacheImpl();
        $metaDataCache->deleteAll();
        Shopware()->Models()->generateAttributeModels(['s_articles_attributes']);
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

