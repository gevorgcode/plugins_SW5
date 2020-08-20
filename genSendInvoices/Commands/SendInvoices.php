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
 * Class SendInvoices
 * @package genSendInvoices\Commands
 */
class SendInvoices extends ShopwareCommand
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
     * SendInvoices constructor.
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
            ->setName('gen:Invoices:Send')
            ->setDescription('Send invoices')
            ->addOption(
                'quiet',
                'q',
                InputOption::VALUE_NONE,
                'No output'
            )
            ->setHelp(<<<EOF
The <info>%command.name%</info> implements a command for sending invoices.
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

        $orders = $this->orderDataService->getOrdersWithUnsendInvoices(new \DateTime($this->config['cronSendStartDate']), $this->config['cronSendInvoices']);

        $i = 0;

        foreach($orders as $order) {
            $this->invoiceService->sendDocumentMail($order['id'], $order['document_path'], $order['number']);
            $i++;
        }

        if(!$input->getOption('quiet')) {
            $output->writeln('Invoices sent: ' . $i);
        }
    }
}
