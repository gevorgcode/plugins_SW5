<?php

namespace GenCustomBannerslider;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;


class GenCustomBannerslider extends Plugin
{
    /**
     * @param ActivateContext $context
     */
    public function activate(ActivateContext $context)
    {
        //$context->scheduleClearCache($context::CACHE_LIST_FRONTEND);

        parent::activate($context);
    }
}
