<?php

namespace genCookieConsentStyle;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class genCookieConsentStyle extends \Shopware\Components\Plugin
{

    public function install(InstallContext $context)
    {
        parent::install($context);
    }

    public function uninstall(UninstallContext $context)
    {
        $context->scheduleClearCache($this->getCacheData());
        parent::uninstall($context);
    }

    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache($this->getCacheData());
        parent::install($context);
    }

    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache($this->getCacheData());
        parent::install($context);
    }


    /**
     * Get caches to clear
     *
     * @return array
     */
    private function getCacheData()
    {
        return InstallContext::CACHE_LIST_ALL;
    }

}
