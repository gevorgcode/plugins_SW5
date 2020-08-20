<?php

namespace spec\ApcIcLoading\Components;

use PhpSpec\ObjectBehavior;
use ApcIcLoading\Components\Config;
use ApcIcLoading\Components\ConfigInterface;
use Shopware\Components\Plugin\ConfigReader;

/**
 * @mixin Config
 * @package spec\ApcIcLoading\Components
 */
class ConfigSpec extends ObjectBehavior
{
    public function let(ConfigReader $configReader)
    {
        $configReader->getByPluginName('apcIc')->willReturn([
            'apcIcLoadingIconBase64' => 'image',
            'apcIcLoadingUsePreDefinedIcons' => false,
            'apcIcLoadingIconSets' => 'grid',
            'apcIcLoadingColor' => '#FFF',
            'apcIcLoadingIconSize' => 20,
            'apcIcLoadingEffect' => 'show',
            'apcIcLoadingEffectTime' => 1000,
            'apcIcLoadingProductImageSize' => 0,
            'apcIcLoadingInstantLoad' => true,
            'apcIcLoadingPreloadAfterLoad' => true,
        ]);

        $this->beConstructedWith($configReader, 'apcIc');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Config::class);
    }

    public function it_should_be_a_config()
    {
        $this->shouldImplement(ConfigInterface::class);
    }

    public function it_should_be_able_to_get_image_base64()
    {
        $this->getImageBase64()->shouldReturn('image');
    }

    public function it_should_be_able_to_is_using_defined_icons()
    {
        $this->isUsingDefinedIcons()->shouldReturn(false);
    }

    public function it_should_be_able_to_get_selected_icon_set()
    {
        $this->getSelectedIconSet()->shouldReturn('grid');
    }

    public function it_should_be_able_to_get_icon_color()
    {
        $this->getIconColor()->shouldReturn('#FFF');
    }

    public function it_should_be_able_to_get_icon_size()
    {
        $this->getIconSize()->shouldReturn(20);
    }

    public function it_should_be_able_to_get_effect()
    {
        $this->getEffect()->shouldReturn('show');
    }

    public function it_should_be_able_to_get_effect_time()
    {
        $this->getEffectTime()->shouldReturn(1000);
    }

    public function it_should_be_able_to_get_product_image_size()
    {
        $this->getProductImageSize()->shouldReturn(0);
    }

    public function it_should_be_able_to_check_loading_instant()
    {
        $this->isLoadingInstant()->shouldReturn(true);
    }

    public function it_should_be_able_to_check_preloading_after_load()
    {
        $this->isPreLoadingAfterLoad()->shouldReturn(true);
    }
}
