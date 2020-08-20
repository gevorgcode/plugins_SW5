<?php

namespace ApcCustomTab;

use Shopware\Components\Plugin;
use Doctrine\ORM\Tools\SchemaTool;
use ApcCustomTab\Models\TabModel\TabModel;

/**
 * Class ApcVariantImage
 * @package ApcVariantImage
 */
class ApcCustomTab extends Plugin
{
    /**
     * @param Plugin\Context\InstallContext $context
     */
    public function install(Plugin\Context\InstallContext $context)
    {
        $context->scheduleMessage('Thank you for installing');
        $em = $this->container->get('models');
        $tool = new SchemaTool($em);
        $classes = [$em->getClassMetadata(TabModel::class)];
        $tool->createSchema($classes);

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

        $em = $this->container->get('models');
        $tool = new SchemaTool($em);
        $classes = [$em->getClassMetadata(TabModel::class)];
        $tool->dropSchema($classes);
        


        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }
}
