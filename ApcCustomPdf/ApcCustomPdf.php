<?php

namespace ApcCustomPdf;

use Shopware\Components\Plugin;

class ApcCustomPdf extends Plugin
{
    
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
