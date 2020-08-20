<?php

namespace spec\ApcIcLoading\Components;

use PhpSpec\ObjectBehavior;
use org\bovigo\vfs\vfsStream;
use ApcIcLoading\Components\SpinnerProvider;
use ApcIcLoading\Services\CustomizerSpinner;

/**
 * @mixin SpinnerProvider
 * @package spec\ApcIcLoading\Components
 */
class SpinnerProviderSpec extends ObjectBehavior
{
    /**
     * @param \Zend_Cache_Core  $cache
     * @param CustomizerSpinner $customizer
     */
    public function let(\Zend_Cache_Core $cache, CustomizerSpinner $customizer)
    {
        $this->beConstructedWith(vfsStream::url('root'), 'testCache', $cache, $customizer);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SpinnerProvider::class);
    }
    
    public function it_is_able_to_set_get_spinner()
    {
        $this->getSpinner('test')->shouldReturn('');
        $this->setSpinner('test', 'test');
        $this->getSpinner('test')->shouldReturn('test');
    }
}
