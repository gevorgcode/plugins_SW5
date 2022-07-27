<?php

namespace AknCronMailLosts\Commands;

use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AknCronMailLosts\Components\Helper;

class SendRegisterBirthdayMailCommand extends ShopwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('akn:send_mail:register_birthday')
        ;
    }

    /** 
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = new Helper();
        $outputInfo = Shopware()->Container()->get('akn_cron_mail_losts.send_rgister_birthday_mail')->cron();
        
        $helper->sendOutputEmail($outputInfo, $subject = 'Rgister Birthday Mail');
        $output->writeln('<info>' .$outputInfo . '</info>');
    }
    
} 