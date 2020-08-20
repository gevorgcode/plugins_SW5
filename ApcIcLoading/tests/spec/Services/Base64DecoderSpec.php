<?php

namespace spec\ApcIcLoading\Services;

use PhpSpec\ObjectBehavior;
use ApcIcLoading\Services\Base64Decoder;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

/**
 * @mixin Base64Decoder
 * @package spec\ApcIcLoading\Services
 */
class Base64DecoderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Base64Decoder::class);
    }

    public function it_should_be_a_decoder()
    {
        $this->shouldImplement(DecoderInterface::class);
    }

    public function it_should_decode_a_string()
    {
        $actual = base64_encode('hallo');
        $this->decode($actual)->shouldReturn('hallo');
    }

    public function it_should_support_decoding()
    {
        // @info: not implemented jet.
        $this->supportsDecoding('test')->shouldReturn(true);
    }
}
