<?php

namespace ApcIcLoading\Tests;

use ApcIcLoading\ApcIcLoading as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'ApcIcLoading' => [],
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['ApcIcLoading'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
