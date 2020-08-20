<?php

namespace ApcIcLoading\Components;

use ApcIcLoading\Services\CustomizerSpinner;


class SpinnerProvider
{
    /**
     * @var array|null
     */
    protected $spinners = [];

    /**
     * @var SpinnerDirectoryIterator
     */
    protected $iterator;

    /**
     * @var \Zend_Cache_Core
     */
    private $cache;

    /**
     * @var string
     */
    private $cacheKey;

    /**
     * @var CustomizerSpinner
     */
    private $customizer;

    /**
     * @param string            $imageDir
     * @param string            $cacheKey
     * @param \Zend_Cache_Core  $cache
     * @param CustomizerSpinner $customizer
     */
    public function __construct($imageDir, $cacheKey, \Zend_Cache_Core $cache, CustomizerSpinner $customizer)
    {
        $this->cache = $cache;
        $this->cacheKey = $cacheKey;
        $this->customizer = $customizer;

        $this->iterator = new SpinnerDirectoryIterator($imageDir);
    }

    /**
     * @throws \Zend_Cache_Exception
     */
    public function collect()
    {
        $this->assignProviderCache();

        if (!empty($this->spinners)) {
            return;
        }

        $this->addSpinnerFromDirectory();
    }

    /**
     * @param string $name
     * @param string $data
     */
    public function setSpinner($name, $data)
    {
        $this->spinners[$name] = $data;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getSpinner($name)
    {
        if (isset($this->spinners[$name])) {
            return $this->spinners[$name];
        }

        return '';
    }

    /**
     * Assigns the cache data if its exists
     */
    protected function assignProviderCache()
    {
        $this->spinners = $this->cache->load($this->cacheKey);
    }

    /**
     * Adds the spinner (from 'img/spinners') to the provider
     */
    protected function addSpinnerFromDirectory()
    {
        /** @var SpinnerDirectoryIterator $file */
        foreach ($this->iterator as $file) {
            if ($file->isSupported() === false) {
                continue;
            }

            $content = $file->getContent();
            $extension = $file->getExtension();

            $this->customizer->customize($content);
            $base64 = $this->customizer->getBase64ImageContent($extension);

            $this->setSpinner(
                $file->getName(),
                $base64
            );
        }

        try {
            $this->cache->save($this->spinners, $this->cacheKey);
        } catch (\Zend_Cache_Exception $ex) {
            // @todo: log exception.
        }
    }
}
