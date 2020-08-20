<?php

namespace spec\ApcIcLoading\Subscriber;

use Enlight\Event\SubscriberInterface;
use ApcIcLoading\Services\ImageEncoderInterface;
use ApcIcLoading\Subscriber\PluginConfigExtend;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin PluginConfigExtend
 * @package spec\ApcIcLoading\Subscriber
 */
class PluginConfigExtendSpec extends ObjectBehavior
{
    function let(ImageEncoderInterface $imageEncoder)
    {
        $this->beConstructedWith($imageEncoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PluginConfigExtend::class);
    }

    function it_is_subscriber()
    {
        $this->shouldImplement(SubscriberInterface::class);
    }

    function it_can_handle_icon(ImageEncoderInterface $imageEncoder)
    {
        $image = 'test.jpg';
        $imageEncoder->encodeImageByUrl(Argument::is($image))->willReturn(md5($image));

        // saves base64 from uploaded icon and resets value
        $this->handleIcon([[
            'value' => $image,
            'shopId' => 1
        ]])->shouldReturn([[
            'value' => '',
            'shopId' => 1
        ]]);

        $this->getBase64()->shouldReturn(md5($image));
    }

    function it_can_handle_empty_icon_base64()
    {
        // save empty field
        $this->handleIconBase64([])->shouldReturn([[
            'id' => 0,
            'shopId' => 1
        ]]);
    }

    function it_can_handle_icon_base64_if_already_filled()
    {
        // save just the base64 string
        $this->handleIconBase64([[
            'value' => '0412c29576c708cf0155e8de242169b1'
        ]])->shouldReturn([[
            'value' => '0412c29576c708cf0155e8de242169b1',
            'shopId' => 1,
        ]]);
    }

    function it_can_handle_icon_base64_if_icon_was_uploaded(ImageEncoderInterface $imageEncoder)
    {
        $image = 'test_upload.jpg';
        $imageEncoder->encodeImageByUrl(Argument::is($image))->willReturn(md5($image));

        // saves base64 from uploaded icon
        $this->handleIcon([[
            'value' => 'test_upload.jpg',
            'shopId' => 1
        ]]);

        // saves new base64 and overrides the old one
        $this->handleIconBase64([[
            'value' => '0412c29576c708cf0155e8de242169b1'
        ]])->shouldReturn([[
            'value' => md5($image),
            'shopId' => 1,
        ]]);
    }
}
