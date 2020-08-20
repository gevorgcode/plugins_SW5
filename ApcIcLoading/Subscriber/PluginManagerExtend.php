<?php

namespace ApcIcLoading\Subscriber;

use Enlight\Event\SubscriberInterface;


class PluginManagerExtend implements SubscriberInterface
{
    /**
     * @var string
     */
    private $viewDir;

    /**
     * @param string $viewDir
     */
    public function __construct($viewDir)
    {
        $this->viewDir = $viewDir;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Backend_PluginManager' => 'onPluginManager',
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @throws \Enlight_Exception
     */
    public function onPluginManager(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Backend_PluginManager $controller */
        $controller = $args->getSubject();

        $view = $controller->View();
        $request = $controller->Request();

        if ($request->getActionName() === 'load') {
            $view->addTemplateDir($this->viewDir);
            $view->extendsTemplate('backend/apc_ic_loading/controller/plugin.js');
        }
    }
}
