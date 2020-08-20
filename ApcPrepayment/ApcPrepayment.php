<?php

namespace ApcPrepayment;

use Shopware\Components\Plugin;

/**
 * Class ApcPrepayment
 * @package ApcPrepayment
 */
class ApcPrepayment extends Plugin
{
    /**
     * @param Plugin\Context\InstallContext $context
     */
    public function install(Plugin\Context\InstallContext $context)
    {
       
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










