<?php

namespace ApcIcLoading\Components;

use Shopware\Components\Plugin\ConfigReader;

/**
 * @author    Daniel Hormess <daniel.hormess@isento-ecommcerce.de>
 * @copyright 2018 isento eCommerce solutions GmbH
 */
class Config implements ConfigInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param ConfigReader $configReader
     * @param string       $pluginName
     */
    public function __construct(ConfigReader $configReader, $pluginName)
    {
        $this->config = $configReader->getByPluginName($pluginName);
    }

    /**
     * @return string
     */
    public function getImageBase64()
    {
        return $this->config['apcIcLoadingIconBase64'];
    }

    /**
     * @return bool
     */
    public function isUsingDefinedIcons()
    {
        return (bool) $this->config['apcIcLoadingUsePreDefinedIcons'];
    }

    /**
     * @return string
     */
    public function getSelectedIconSet()
    {
        return $this->config['apcIcLoadingIconSets'];
    }

    /**
     * @return string
     */
    public function getIconColor()
    {
        return $this->config['apcIcLoadingColor'];
    }

    /**
     * @return int
     */
    public function getIconSize()
    {
        return (int) $this->config['apcIcLoadingIconSize'];
    }

    /**
     * @return string
     */
    public function getEffect()
    {
        return $this->config['apcIcLoadingEffect'];
    }

    /**
     * @return int
     */
    public function getEffectTime()
    {
        return (int) $this->config['apcIcLoadingEffectTime'];
    }

    /**
     * @return int
     */
    public function getProductImageSize()
    {
        return (int) $this->config['apcIcLoadingProductImageSize'];
    }

    /**
     * @return bool
     */
    public function isLoadingInstant()
    {
        return (bool) $this->config['apcIcLoadingInstantLoad'];
    }

    /**
     * @return bool
     */
    public function isPreLoadingAfterLoad()
    {
        return (bool) $this->config['apcIcLoadingPreloadAfterLoad'];
    }
}
