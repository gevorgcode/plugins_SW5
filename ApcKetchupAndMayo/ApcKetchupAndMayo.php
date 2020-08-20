<?php

namespace ApcKetchupAndMayo;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class ApcKetchupAndMayo extends Plugin
{
    public function install(InstallContext $context){

        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);

    }
    public function uninstall(UninstallContext $context){
        
        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
    }

}
