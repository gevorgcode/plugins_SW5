<?php

namespace ApcIcLoading\Services;

use Shopware\Bundle\MediaBundle\MediaServiceInterface;


class Base64Encoder implements ImageEncoderInterface
{
    /**
     * @var MediaServiceInterface
     */
    private $mediaService;

    /**
     * @param MediaServiceInterface $mediaService
     */
    public function __construct(MediaServiceInterface $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * @param mixed  $data
     * @param string $format
     * @param array  $context
     *
     * @return string
     */
    public function encode($data, $format = '', array $context = [])
    {
        return base64_encode($data);
    }

    /**
     * @param string $url
     * @param bool   $includeDataImage
     *
     * @return string
     */
    public function encodeImageByUrl($url, $includeDataImage = true)
    {
        $path = $this->mediaService->normalize($url);
        $content = $this->mediaService->read($path);
        $encoded = $this->encode($content);

        if ($includeDataImage) {
            $extention = $this->getFileExtension($path);
            $encoded = $this->addDataImageInformation($extention, $encoded);
        }

        return $encoded;
    }

    /**
     * @param string $extension
     * @param string $data
     *
     * @return string
     */
    public function addDataImageInformation($extension, $data)
    {
        if ($extension === 'svg') {
            // @todo: build logic for this.
            $extension = $extension . '+xml';
        }

        return 'data:image/' . $extension . ';base64,' . $data;
    }

    /**
     * @param string $format
     *
     * @return bool
     */
    public function supportsEncoding($format)
    {
        return true;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getFileExtension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }
}
