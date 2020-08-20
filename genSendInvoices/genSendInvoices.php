<?php

namespace genSendInvoices;

use Shopware\Components\Plugin;
use genSendInvoices\Models\InvoiceSentHistory;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Shopware-Plugin genSendInvoices.
 */
class genSendInvoices extends Plugin
{

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('gen_send_invoices.plugin_dir', $this->getPath());
        $container->setParameter('gen_send_invoices.plugin_name', $this->getName());
        parent::build($container);
    }

    /**
     * @param Plugin\Context\InstallContext $installContext
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function install(Plugin\Context\InstallContext $installContext)
    {
        parent::install($installContext);

        $em = $this->container->get('models');

        //setup schema
        $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $classes = [$em->getClassMetadata(InvoiceSentHistory::class)];

        if(!$em->getConnection()->getSchemaManager()->tablesExist(array('gen_invoice_sent_history'))) {
            $tool->createSchema($classes);
        }
    }

}
