<?php

namespace GenReviewPagination\Subscriber;

use Enlight\Event\SubscriberInterface;

/**
 * Class TemplateRegistration
 *
 * @package GenReviewPagination\Subscriber
 */
class TemplateRegistration implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @param $pluginDirectory
     */
    public function __construct($pluginDirectory)
    {   
        $this->pluginDirectory = $pluginDirectory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Inheritance_Template_Directories_Collected' => 'onTemplateDirCollected'
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     * @return array
     */
    public function onTemplateDirCollected(\Enlight_Event_EventArgs $args)
    {
        $templateDirectories = $args->getReturn();
        $templateDirectories[] = $this->pluginDirectory . '/Resources/views';
        
        return $templateDirectories;
    }
}