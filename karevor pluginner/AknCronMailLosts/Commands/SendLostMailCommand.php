<?php

namespace AknCronMailLosts\Commands;

use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AknCronMailLosts\Components\Helper;

class SendLostMailCommand extends ShopwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('akn:send_mail:lost')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = new Helper();
        $outputInfo = Shopware()->Container()->get('akn_cron_mail_losts.send_lost_mail')->cron();
        $helper->sendOutputEmail($outputInfo, $subject = 'Losts Mail');
        $output->writeln('<info>' .$outputInfo . '</info>');
    }
}