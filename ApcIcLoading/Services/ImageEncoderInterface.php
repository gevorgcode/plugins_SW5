<?php

namespace ApcIcLoading\Services;

use Symfony\Component\Serializer\Encoder\EncoderInterface;


interface ImageEncoderInterface extends EncoderInterface
{
    /**
     * @param mixed  $data
     * @param string $format
     * @param array  $context
     *
     * @return string
     */
    public function encode($data, $format = '', array $context = []);

    /**
     * @param string $url
     * @param bool   $includeDataImage
     *
     * @return string
     */
    public function encodeImageByUrl($url, $includeDataImage = true);

    /**
     * Adds the data image information which need for image encoding
     *
     * @param $extension
     * @param $data
     *
     * @return mixed
     */
    public function addDataImageInformation($extension, $data);
}
