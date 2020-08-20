<?php

namespace ApcIcLoading;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author    Daniel Hormess <daniel.hormess@isento-ecommcerce.de>
 * @copyright 2018 isento eCommerce solutions GmbH
 */
class ApcIcLoading extends Plugin
{
    /**
     * @see   5.2.x to support this version.
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('apc_ic_loading.plugin_dir', $this->getPath());
        $container->setParameter('apc_ic_loading.plugin_name', $this->getName());

        parent::build($container);
    }

    /**
     * @param ActivateContext $context
     */
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache($context::CACHE_LIST_FRONTEND);

        parent::activate($context);
    }
}
