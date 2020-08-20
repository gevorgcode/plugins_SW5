<?php

namespace spec\ApcIcLoading\Services;

use PhpSpec\ObjectBehavior;
use ApcIcLoading\Services\Base64Encoder;
use Shopware\Bundle\MediaBundle\MediaServiceInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

/**
 * @mixin Base64Encoder
 * @package spec\ApcIcLoading\Services
 */
class Base64EncoderSpec extends ObjectBehavior
{
    /**
     * @param MediaServiceInterface $mediaService
     */
    public function let(MediaServiceInterface $mediaService)
    {
        $this->beConstructedWith($mediaService);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Base64Encoder::class);
    }

    public function it_should_be_an_encoder()
    {
        $this->shouldImplement(EncoderInterface::class);
    }

    public function it_should_encode_a_string_as_base64()
    {
        $this->encode('hallo')->shouldReturn('aGFsbG8=');
    }

    public function it_should_add_data_image_information()
    {
        $this->addDataImageInformation('jpg', '__base64')->shouldReturn('data:image/jpg;base64,__base64');
        $this->addDataImageInformation('svg', '__base64')->shouldReturn('data:image/svg+xml;base64,__base64');;
    }

    /**
     * @param MediaServiceInterface $mediaService
     */
    public function it_should_be_able_to_encode_an_image_by_url(MediaServiceInterface $mediaService)
    {
        $input = 'test';
        $output = 'content';
        $expected = base64_encode($output);

        // prepare media service
        $mediaService->normalize($input)->willReturn('__path');
        $mediaService->read('__path')->willReturn($output);

        // without image info
        $this->encodeImageByUrl($input, false)->shouldReturn($expected);
        // with image info
        $this->encodeImageByUrl($input)->shouldReturn('data:image/;base64,' . $expected);
    }

    public function it_should_support_encoding()
    {
        // @info: not implemented jet.
        $this->supportsEncoding('test')->shouldReturn(true);
    }
}
