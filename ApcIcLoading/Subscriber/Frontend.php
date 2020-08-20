<?php

namespace ApcIcLoading\Subscriber;

use Enlight\Event\SubscriberInterface;
use ApcIcLoading\Components\ConfigInterface;


class Frontend implements SubscriberInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Frontend' => 'onDispatch',
            'Enlight_Controller_Action_PostDispatch_Widgets' => 'onDispatch',
            'Enlight_Controller_Action_PreDispatch_Widgets' => 'onDispatch',
        ];
    }

    /**
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function onDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        $view = $args->getSubject()->View();

        $view->assign('apcIcLoadingProductImageSize', $this->config->getProductImageSize());
        $view->assign('apcIcLoadingInstantLoad', $this->config->isLoadingInstant());

        if ($view->getAssign('apcIcLoadingEffect') !== null) {
            return;
        }

        $view->assign('apcIcLoadingEffect', $this->config->getEffect());
        $view->assign('apcIcLoadingEffectTime', $this->config->getEffectTime());
    }
}
