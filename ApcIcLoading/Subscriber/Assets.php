<?php

namespace ApcIcLoading\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use ApcIcLoading\Components\ConfigInterface;
use ApcIcLoading\Components\SpinnerProvider;
use Shopware\Components\Theme\LessDefinition;


class Assets implements SubscriberInterface
{
    /**
     * @var string
     */
    private $lessDir;

    /**
     * @var string
     */
    private $jsDir;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var SpinnerProvider
     */
    private $provider;

    /**
     * @param string          $lessDir
     * @param string          $jsDir
     * @param ConfigInterface $config
     * @param SpinnerProvider $provider
     */
    public function __construct($lessDir, $jsDir, ConfigInterface $config, SpinnerProvider $provider)
    {
        $this->lessDir = $lessDir;
        $this->jsDir = $jsDir;
        $this->config = $config;
        $this->provider = $provider;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Compiler_Collect_Plugin_Less' => 'onCollectLess',
            'Theme_Compiler_Collect_Plugin_Javascript' => 'onCollectJavascript',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendPostDispatch',
        ];
    }

    /**
     * @throws \Zend_Cache_Exception
     *
     * @return LessDefinition
     */
    public function onCollectLess()
    {
        return new LessDefinition([
            'icLoadingIcon' => "'{$this->getIcLoadingIcon()}'",
            'icLoadingIconSize' => $this->config->getIconSize(),
        ], [
            $this->lessDir . '/all.less',
        ]);
    }

    /**
     * @return ArrayCollection
     */
    public function onCollectJavascript()
    {
        $collection = new ArrayCollection();

        $collection->add($this->jsDir . '/jquery.ic-loading.js');
        $collection->add($this->jsDir . '/jquery.last-seen-products-extend.js');
        $collection->add($this->jsDir . '/libs/icsizes.min.js');

        return $collection;
    }

    /**
     * @param \Enlight_Controller_ActionEventArgs $args
     *
     * @throws \Zend_Cache_Exception
     */
    public function onFrontendPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        $view = $args->getSubject()->View();

        $view->assign('apcIcLoadingIconBase64', $this->getIcLoadingIcon());
    }

    /**
     * @throws \Zend_Cache_Exception
     *
     * @return string
     */
    public function getIcLoadingIcon()
    {
        if ($this->config->isUsingDefinedIcons() === false) {
            return $this->config->getImageBase64();
        }

        $this->provider->collect();

        return $this->provider->getSpinner($this->config->getSelectedIconSet());
    }
}
