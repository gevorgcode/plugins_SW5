<?php

namespace genSendInvoices\Commands;

use genSendInvoices\Services\DocumentServiceInterface;
use genSendInvoices\Services\OrderDataInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Shopware\Commands\ShopwareCommand;


/**
 * Class SendInvoice
 * @package genSendInvoices\Commands
 */
class SendInvoice extends ShopwareCommand
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
     * SendInvoice constructor.
     * @param DocumentServiceInterface $invoiceService
     * @param OrderDataInterface $orderDataService
     */
    public function __construct(DocumentServiceInterface $invoiceService, OrderDataInterface $orderDataService)
    {
        $this->invoiceService = $invoiceService;
        $this->orderDataService = $orderDataService;
        parent::__construct(null);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('gen:Invoice:Send')
            ->setDescription('Generate and create a specific invoice')
            ->addArgument(
                'ordernumber',
                InputArgument::REQUIRED,
                'Number of order'
            )
            ->setHelp(<<<EOF
The <info>%command.name%</info> implements a command for generating and sending invoice for one specific order.
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //TODO: separates Plugin mit Widget (nicht erstellt / nicht versendet)

        $number = $input->getArgument('ordernumber');

        //we have to avoid warning output, because session is set by shopware
        error_reporting(E_ERROR | E_PARSE);

        $orderId = $this->orderDataService->getOrderIdByNumber($number);

        $document = $this->invoiceService->getDocument($orderId);
        $this->invoiceService->sendDocumentMail($orderId, $document, $number);
    }

}
