<?php

namespace spec\ApcIcLoading\Services;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use ApcIcLoading\Components\ConfigInterface;
use ApcIcLoading\Services\CustomizerSpinner;
use ApcIcLoading\Services\ImageEncoderInterface;

/**
 * @mixin CustomizerSpinner
 * @package spec\ApcIcLoading\Services
 */
class CustomizerSpinnerSpec extends ObjectBehavior
{
    /**
     * @param ConfigInterface $config
     * @param ImageEncoderInterface $encoder
     */
    public function let(ConfigInterface $config, ImageEncoderInterface $encoder)
    {
        $config->getIconColor()->willReturn('#FFF');

        $this->beConstructedWith($config, $encoder);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CustomizerSpinner::class);
    }

    public function it_should_be_able_to_get_content()
    {
        $this->customize('<svg/>');
        $this->getCustomized()->shouldReturn('<svg/>');
    }

    public function it_should_be_able_to_customize_xml()
    {
        $test = file_get_contents(__DIR__ . '/../../data/test.xml');
        $testPassed = file_get_contents(__DIR__ . '/../../data/testPassed.xml');

        $this->customize($test);
        $this->getCustomized()->shouldReturn($testPassed);
    }

    /**
     * @param ImageEncoderInterface $encoder
     */
    public function it_should_be_able_to_get_base64_content(ImageEncoderInterface $encoder)
    {
        // prepare
        $encoder->encode(Argument::any())->willReturn('__base64');

        $this->customize('<svg/>');
        $this->getBase64Content()->shouldReturn('__base64');
    }

    /**
     * @param ImageEncoderInterface $encoder
     */
    public function it_should_be_able_to_get_base64_image_content(ImageEncoderInterface $encoder)
    {
        $extension = 'jpg';

        // prepare
        $encoder->encode(Argument::any())->willReturn('__base64');
        $encoder->addDataImageInformation($extension, Argument::any())->willReturn('__base64');

        $this->getBase64ImageContent($extension)->shouldReturn('__base64');
    }
}
