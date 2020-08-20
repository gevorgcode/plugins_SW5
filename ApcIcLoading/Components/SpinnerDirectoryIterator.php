<?php

namespace ApcIcLoading\Components;


class SpinnerDirectoryIterator extends \DirectoryIterator
{
    /**
     * @var array
     */
    protected $supportedExtensions = [
        'svg',
    ];

    /**
     * @return string
     */
    public function getName()
    {
        $omit = '.' . $this->getExtension();

        return $this->getBasename($omit);
    }

    /**
     * @return bool
     */
    public function isSupported()
    {
        return in_array($this->getExtension(), $this->supportedExtensions) && $this->isFile();
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return file_get_contents($this->getRealPath());
    }
}
