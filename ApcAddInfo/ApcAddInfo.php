<?php

namespace ApcAddInfo;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class ApcAddInfo extends Plugin
{
    public function install(InstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->update('s_categories_attributes', 'display_add_info', 'boolean', [
           'label' => 'Display Additional Info',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 0,
       ]);

        $service->update('s_categories_attributes', 'tab_title1', 'string', [
           'label' => 'Tab Title 1',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 1,
       ]);
       $service->update(
            's_categories_attributes',
            'tab_image_1',
            'single_selection',[
                'label' => 'Tab Image 1',
                'entity' => \Shopware\Models\Media\Media::class,
                'displayInBackend' => true,
                'custom' => true,
                'position' => 2,
            ]
        );
        $service->update('s_categories_attributes', 'tab_text1', 'html', [
           'label' => 'Tab Text 1',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 3,
       ]);

        $service->update('s_categories_attributes', 'tab_title2', 'string', [
           'label' => 'Tab Title 2',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 4,
       ]);

       $service->update(
            's_categories_attributes',
            'tab_image_2',
            'single_selection',[
                'label' => 'Tab Image 2',
                'entity' => \Shopware\Models\Media\Media::class,
                'displayInBackend' => true,
                'custom' => true,
                'position' => 5,
            ]
        );
        $service->update('s_categories_attributes', 'tab_text2', 'html', [
           'label' => 'Tab Text 2',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 6,
       ]);

        $service->update('s_categories_attributes', 'tab_title3', 'string', [
           'label' => 'Tab Title 3',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 7,
       ]);
       $service->update(
            's_categories_attributes',
            'tab_image_3',
            'single_selection',[
                'label' => 'Tab Image 3',
                'entity' => \Shopware\Models\Media\Media::class,
                'displayInBackend' => true,
                'custom' => true,
                'position' => 8,
            ]
        );
        $service->update('s_categories_attributes', 'tab_text3', 'html', [
           'label' => 'Tab Text 3',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 9,
       ]);

        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);

    }
    public function uninstall(UninstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->delete('s_categories_attributes', 'tab_title1');
        $service->delete('s_categories_attributes', 'tab_title2');
        $service->delete('s_categories_attributes', 'tab_title3');
        $service->delete('s_categories_attributes', 'tab_text1');
        $service->delete('s_categories_attributes', 'tab_text2');
        $service->delete('s_categories_attributes', 'tab_text3');
        $service->delete('s_categories_attributes', 'tab_image1');
        $service->delete('s_categories_attributes', 'tab_image2');
        $service->delete('s_categories_attributes', 'tab_image3');

        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
    }

}
