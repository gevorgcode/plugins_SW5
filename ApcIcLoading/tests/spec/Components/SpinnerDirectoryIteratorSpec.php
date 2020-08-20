<?php

namespace spec\ApcIcLoading\Components;

use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use ApcIcLoading\Components\SpinnerDirectoryIterator;

/**
 * @mixin SpinnerDirectoryIterator
 * @package spec\ApcIcLoading\Components
 */
class SpinnerDirectoryIteratorSpec extends ObjectBehavior
{
    public function let()
    {
        $directory = [
            'testImage.jpg' => '',
            'testImage.svg' => '',
        ];

        $stream = vfsStream::setup('root', 444, $directory);
        $this->beConstructedWith($stream->url());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SpinnerDirectoryIterator::class);
    }

    public function it_should_be_a_directory_iterator()
    {
        $this->shouldImplement(\DirectoryIterator::class);
    }

    public function it_should_be_able_to_get_name()
    {
        $this->next();
        $this->next();

        $this->getName()->shouldReturn('testImage');
    }

    public function it_should_be_able_to_support()
    {
        // skip dots
        $this->next();
        $this->next();

        $this->isSupported()->shouldReturn(false);

        $this->next();

        $this->isSupported()->shouldReturn(true);
    }
}
