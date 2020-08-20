<?php

namespace genSendInvoices\Commands;

use genSendInvoices\Services\DocumentServiceInterface;
use genSendInvoices\Services\OrderDataInterface;
use Shopware\Components\Plugin\CachedConfigReader;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Shopware\Commands\ShopwareCommand;


/**
 * Class GenerateInvoices
 * @package genSendInvoices\Commands
 */
class GenerateInvoices extends ShopwareCommand
{
    /**
     * @var DocumentServiceInterface
     */
    protected $invoiceService;

    /**
     * @var OrderDataInterface
     */
    protected $orderDataService;

    /**
     * @var array|mixed
     */
    protected $config;

    /**
     * GenerateInvoices constructor.
     * @param DocumentServiceInterface $invoiceService
     * @param OrderDataInterface $orderDataService
     * @param string $pluginName
     * @param CachedConfigReader $configReader
     */
    public function __construct(DocumentServiceInterface $invoiceService, OrderDataInterface $orderDataService, string $pluginName, CachedConfigReader $configReader)
    {
        $this->invoiceService = $invoiceService;
        $this->orderDataService = $orderDataService;
        $this->config = $configReader->getByPluginName($pluginName);
        parent::__construct(null);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('gen:Invoices:Generate')
            ->setDescription('Generate invoices')
            ->addOption(
                'quiet',
                'q',
                InputOption::VALUE_NONE,
                'No output'
            )
            ->setHelp(<<<EOF
The <info>%command.name%</info> implements a command for generating invoices.
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //we have to avoid warning output, because session is set by shopware
        error_reporting(E_ERROR | E_PARSE);

        $orders = $this->orderDataService->getOrdersWithoutInvoice($this->config['cronGenerateInvoices']);

        $i = 0;

        foreach($orders as $order) {
            $this->invoiceService->getDocument($order['id']);
            $i++;
        }

        if(!$input->getOption('quiet')) {
            $output->writeln('Invoices generated: ' . $i);
        }
    }
}
