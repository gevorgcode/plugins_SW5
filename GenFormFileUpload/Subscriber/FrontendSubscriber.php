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
class FrontendSubscriber implements SubscriberInterface
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
            'Shopware_Controllers_Frontend_Forms::_validateInput::after' => '_validateInput',
            'Shopware_Controllers_Frontend_Forms_commitForm_Mail' => 'onFrontendFormsCommitFormMail',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Forms' => 'onActionPostDispatchFrontendForms',
        ];
    }

    /**
     * Hook _validateInput method from Shopware_Controllers_Frontend_Forms controller for validation for file fields
     *
     * Populates $this->_postData
     *
     * @param \Enlight_Hook_HookArgs $arguments
     */
    public function _validateInput(Enlight_Hook_HookArgs $arguments)
    {
        /** @var \Shopware_Controllers_Frontend_Forms $controller */
        $controller = $arguments->getSubject();

        // configuration of the plugin
        $config = $this->container->get('config');

        // default file types
        $allowedFileTypes = $this->getAllowedFileTypes();
        // max file size
        $maxFileSize = ((ini_get('upload_max_filesize') * 1024) * 1024);
        // file size from plugin config
        $configMaxFileSize = (($config->maxFileSize * 1024) * 1024);
        if ($maxFileSize >= $configMaxFileSize)
            $maxFileSize = $configMaxFileSize;

        // fields and files
        $elements = $arguments->get('elements');
        $errors = $arguments->getReturn();

        foreach ($elements as $element) {
            // only for file fields
            if (!in_array($element['typ'], ['file', 'files']))
                continue;

            $id = $element['id'];

            // use default configuration if field configuration is empty
            if (!empty($element['value']))
                $allowedFileTypes = $this->getAllowedFileTypes($element['value']);

            /** @var UploadedFile|UploadedFile[] $file */
            $files = $this->getFileBag()->get($element['name']);
            if (!is_array($files) && !empty($files)) {
                $files = [$files];
            }

            // remove error for file fields because default validation is incorrect
            if (!empty($errors['e'][$id]))
                unset($errors['e'][$id]);

            // check if file is required and uploaded
            if ($element['required'] && !$files) {
                $errors['e'][$id] = true;
            }

            foreach ($files as $file) {
                // validate file type and size if file given
                if ($file && !$this->isFileValid($file, $allowedFileTypes, $maxFileSize)) {
                    $errors['v'][] = $id;
                }
            }

            // populate value in post data
            if ($files) {
                if ($element['typ'] == 'file') {
                    $file = reset($files);
                    $controller->_postData[$id] = $file->getClientOriginalName();
                } else if ($element['typ'] == 'files') {
                    $fileNames = array_map(function (UploadedFile $file) {
                        return $file->getClientOriginalName();
                    }, $files);
                    $controller->_postData[$id] = implode(', ', $fileNames);
                }
            }
        }

        // fix validation if field is required
        if (empty($errors['e']))
            unset($errors['e']);

        $arguments->setReturn($errors);
    }

    /**
     * @param UploadedFile $file
     * @param array $allowedFileTypes
     * @param int $maxFileSize
     * @return bool
     */
    private function isFileValid(UploadedFile $file, array $allowedFileTypes, $maxFileSize)
    {
        // check file type
        if (!in_array(strtolower($file->getClientOriginalExtension()), $allowedFileTypes)) {
            return false;
        }

        // check file size
        if ($file->getSize() > $maxFileSize) {
            return false;
        }

        return true;
    }

    /**
     * @return FileBag
     */
    private function getFileBag()
    {
        $fileBag = new FileBag($_FILES);
        return $fileBag;
    }

    /**
     * @param string|null $fileTypes
     * @return array
     */
    private function getAllowedFileTypes($fileTypes = null)
    {
        if ($fileTypes === null) {
            $fileTypes = $this->container->get('config')->get('allowedFileTypes');
        }

        $fileTypes = explode(';', $fileTypes);

        // allow both JPEG file extensions if one is given
        if (in_array('jpg', $fileTypes) && !in_array('jpeg', $fileTypes)) {
            $fileTypes[] = 'jpeg';
        } else if (in_array('jpeg', $fileTypes) && !in_array('jpg', $fileTypes)) {
            $fileTypes[] = 'jpg';
        }

        return $fileTypes;
    }

    /**
     * Event to add attachments to mail on Shopware versions equals or greater than 5
     *
     * @param \Enlight_Event_EventArgs $arguments
     */
    public function onFrontendFormsCommitFormMail(\Enlight_Event_EventArgs $arguments)
    {
        /** @var $mail Enlight_Components_Mail */
        $mail = $arguments->getReturn();
        $this->addAttachments($mail);
    }

    /**
     * @param Enlight_Components_Mail $mail
     * @return Enlight_Components_Mail
     */
    public function addAttachments(Enlight_Components_Mail $mail)
    {
        $fileCollection = $this->getFileBag();
        /** @var UploadedFile $file */
        foreach ($fileCollection as $files) {
            if (!$files)
                continue;

            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                $newFileName = uniqid() . '_' . $file->getClientOriginalName();
                $file = $file->move(Shopware()->DocPath('media_' . 'temp'), $newFileName);

                $mail->createAttachment(
                    file_get_contents($file->getPathname()),
                    $file->getMimeType(),
                    \Zend_Mime::DISPOSITION_ATTACHMENT,
                    \Zend_Mime::ENCODING_BASE64,
                    $newFileName
                );
            }
        }

        return $mail;
    }

    /**
     * Extend templates to show label for file field
     *
     * @param \Enlight_Controller_ActionEventArgs $arguments
     */
    public function onActionPostDispatchFrontendForms(\Enlight_Controller_ActionEventArgs $arguments)
    {
        /** @var \Shopware_Controllers_Frontend_Forms $controller */
        $controller = $arguments->getSubject();
        $view = $controller->View();

        // add template directory to show input label on file input if enabled
        $pluginPath = $this->container->getParameter('gen_form_file_upload.plugin_dir');
        $view->addTemplateDir($pluginPath . '/Resources/views/');
    }
}
