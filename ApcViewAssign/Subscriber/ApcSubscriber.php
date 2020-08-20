<?php
namespace ApcViewAssign\Subscriber;

use Enlight\Event\SubscriberInterface;

class ApcSubscriber implements SubscriberInterface
{
    private $pluginDirectory;

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Widgets_Checkout' => 'onPostDispatch'
        ];
    }

    public function __construct($pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;

    }

    public function onPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        /** @var \Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $request = $controller->Request();
        $view = $controller->View();

        if($request->getActionName() == 'info'){
            $view->assign('navigationbadge', $request->getParam('navigationbadge', false));
        }
    }

}
