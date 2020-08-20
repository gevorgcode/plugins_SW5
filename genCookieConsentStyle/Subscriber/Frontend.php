<?php

namespace genCookieConsentStyle\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\Plugin\ConfigReader;
use Shopware\Components\Theme\LessDefinition;
use Doctrine\Common\Collections\ArrayCollection;

class Frontend implements SubscriberInterface
{
    /** @var ConfigReader */
    private $configReader;

    /** @var string */
    private $pluginName;

    /** @var string */
    private $pluginBaseDirectory;

    /**
     * @param string $pluginBaseDirectory
     */
    public function __construct(
        ConfigReader $configReader,
        $pluginName,
        $pluginBaseDirectory
    )
    {
        $this->configReader = $configReader;
        $this->pluginName = $pluginName;
        $this->pluginBaseDirectory = $pluginBaseDirectory;
    }

    /**
     * @param \Shopware\Models\Shop\Shop $shop
     * @return mixed
     */
    protected function getShopConfig($shop)
    {
        return $this->configReader->getByPluginName($this->pluginName, $shop);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Compiler_Collect_Plugin_Less' => 'addLessFiles',
        ];
    }

    /**
     * Provide the file collection for less
     *
     * @param \Enlight_Event_EventArgs $args
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function addLessFiles(\Enlight_Event_EventArgs $args)
    {
        $config = $this->getShopConfig($args->getShop());

        $lessConfig = [];
        foreach ($config as $field => $color) {
            if (strpos($field, 'section') !== false) {
                continue;
            }

            if ($field == 'consentBgColor') {
                $color = $this->colorLuminance($color, $config['consentBgColorTransparence']);
            }

            $lessConfig[$this->pluginName . '_' . $field] = ($color != '' ? $color : 'transparent');
        }

        $less = new LessDefinition(
            $lessConfig,
            [$this->pluginBaseDirectory . '/Resources/views/frontend/_public/src/less/all.less'],
            $this->pluginBaseDirectory
        );

        return new ArrayCollection([$less]);
    }

    /**
     * @param $hex
     * @param $percent
     * @return string
     */
    private function colorLuminance($color, $percent) {

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
            return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        $opacity = $percent / 100;
        if($opacity){
            if(abs($opacity) > 1) {
                $opacity = 1.0;
            }
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = $color;
        }

        //Return rgb(a) color string
        return $output;
    }
}
