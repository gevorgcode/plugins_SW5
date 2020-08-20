<?php

namespace ApcIcLoading\Services;

use ApcIcLoading\Components\ConfigInterface;


class CustomizerSpinner implements CustomizerInterface
{
    /**
     * @var \DOMDocument
     */
    protected $customizingObject;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var ImageEncoderInterface
     */
    private $encoder;

    /**
     * @param ConfigInterface       $config
     * @param ImageEncoderInterface $encoder
     */
    public function __construct(ConfigInterface $config, ImageEncoderInterface $encoder)
    {
        $this->config = $config;
        $this->encoder = $encoder;
    }

    /**
     * @param string $xml
     */
    public function customize($xml)
    {
        $this->customizingObject = $xml;

        // Customizing
        $this->changeIconColor();
    }

    /**
     * @return string
     */
    public function getCustomized()
    {
        return $this->customizingObject;
    }

    /**
     * @return string
     */
    public function getBase64Content()
    {
        return $this->encoder->encode($this->getCustomized());
    }

    /**
     * @param string $extension
     *
     * @return string
     */
    public function getBase64ImageContent($extension)
    {
        return $this->encoder->addDataImageInformation($extension, $this->getBase64Content());
    }

    /**
     * Changes the icon color to the color which defined in the config
     */
    protected function changeIconColor()
    {
        $this->customizingObject = str_replace(
            '{@color}',
            $this->config->getIconColor(),
            $this->customizingObject
        );
    }
}
