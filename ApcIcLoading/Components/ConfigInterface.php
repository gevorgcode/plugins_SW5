<?php

namespace ApcIcLoading\Components;


interface ConfigInterface
{
    /**
     * @return string
     */
    public function getImageBase64();

    /**
     * @return bool
     */
    public function isUsingDefinedIcons();

    /**
     * @return string
     */
    public function getSelectedIconSet();

    /**
     * @return string
     */
    public function getIconColor();

    /**
     * @return int
     */
    public function getIconSize();

    /**
     * @return string
     */
    public function getEffect();

    /**
     * @return int
     */
    public function getEffectTime();

    /**
     * @return int
     */
    public function getProductImageSize();

    /**
     * @return bool
     */
    public function isLoadingInstant();

    /**
     * @return bool
     */
    public function isPreloadingAfterLoad();
}
