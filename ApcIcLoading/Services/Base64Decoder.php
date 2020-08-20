<?php

namespace ApcIcLoading\Services;

use Symfony\Component\Serializer\Encoder\DecoderInterface;


class Base64Decoder implements DecoderInterface
{
    /**
     * @param string $data
     * @param string $format
     * @param array  $context
     *
     * @return bool|string
     */
    public function decode($data, $format = '', array $context = [])
    {
        return base64_decode($data, true);
    }

    /**
     * @param string $format
     *
     * @return bool
     */
    public function supportsDecoding($format)
    {
        return true;
    }
}
