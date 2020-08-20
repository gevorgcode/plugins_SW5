<?php

namespace CodersFacebookPixel;

use Doctrine\Common\Collections\ArrayCollection;
use Shopware\Components\Plugin;

/**
 * Class CodersFacebookPixel
 *
 */
class CodersFacebookPixel extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendPostDispatch',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Search' => 'onSearchPostDispatch',
        ];
    }

    public function onFrontendPostDispatch(\Enlight_Event_EventArgs $arguments) {

        $request = $arguments->getSubject()->Request();
        $response = $arguments->getSubject()->Response();
        $view = $arguments->getSubject()->View();

        if (!$request->isDispatched() || !$view->hasTemplate() || $response->isException() || $request->isXmlHttpRequest()) {
            return;
        }

        $view->assign('cg_pixelID', Shopware()->Config()->getByNamespace('CodersFacebookPixel', 'cg_pixelID'));
        $view->assign('cg_userIsLogged', $this->isUserLoggedIn());
        $view->assign('cg_userData', Shopware()->Modules()->Admin()->sGetUserData());
        $view->assign('cg_currency', $this->container->get('Shop')->getCurrency()->getCurrency());
    }

    public function onSearchPostDispatch(\Enlight_Event_EventArgs $arguments) {
        $request = $arguments->getSubject()->Request();
        $view = $arguments->getSubject()->View();

        $search = $request->getParam('sSearch', '');
        $view->assign('cg_pixelSearch', $search);
    }

    public function isUserLoggedIn() {

        return (isset(Shopware()->Session()->sUserId) && !empty(Shopware()->Session()->sUserId) && Shopware()->Session()->sUserId !=null);
    }
}