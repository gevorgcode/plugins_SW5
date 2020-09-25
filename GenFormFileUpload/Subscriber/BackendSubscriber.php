<?php

namespace GenFormFileUpload\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Components_Mail;
use Enlight_Hook_HookArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class FrontendSubscriber
 *
 * @package GenBasketOfferForm\Subscriber
 */
class BackendSubscriber implements SubscriberInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * FrontendSubscriber constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Backend_Form' => 'onBackendFormPostDispatch',
        ];
    }

    /**
     * Called when the BackendFormPostDispatch Event is triggered
     *
     * @param \Enlight_Controller_ActionEventArgs $arguments
     */
    public function onBackendFormPostDispatch(\Enlight_Controller_ActionEventArgs $arguments)
    {
        /**@var $view \Enlight_View_Default */
        $view = $arguments->getSubject()->View();

        $pluginPath = $this->container->getParameter('gen_form_file_upload.plugin_dir');

        // Add template directory
        $arguments->getSubject()->View()->addTemplateDir(
            $pluginPath . '/Resources/views/'
        );

        // if the controller action name equals "index" we have to extend the backend form application
        if ($arguments->getRequest()->getActionName() === 'index') {
            $view->extendsTemplate('backend/form/form_file_upload_app.js');
        }
    }
}
