<?php

namespace ApcIcLoading\Subscriber;

use Enlight\Event\SubscriberInterface;
use ApcIcLoading\Services\ImageEncoderInterface;


class PluginConfigExtend implements SubscriberInterface
{
    const CONFIG_NAME_ICON = 'apcIcLoadingIcon';
    const CONFIG_NAME_ICON_BASE64 = 'apcIcLoadingIconBase64';

    /**
     * @var string
     */
    protected $base64 = '';

    /**
     * @var int
     */
    protected $shopId = 1;

    /**
     * @var ImageEncoderInterface
     */
    private $encoder;

    /**
     * @param ImageEncoderInterface $encoder
     */
    public function __construct(ImageEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Backend_Config' => 'onPreDispatchBackendConfig',
        ];
    }

    /**
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function onPreDispatchBackendConfig(\Enlight_Controller_ActionEventArgs $args)
    {
        $request = $args->getSubject()->Request();

        if ($request->getActionName() !== 'saveForm') {
            return;
        }

        if (!$elements = $request->getParam('elements')) {
            return;
        }

        foreach ($elements as &$element) {
            $name = $element['name'];
            $values = $element['values'];

            if ($name === static::CONFIG_NAME_ICON) {
                $values = $this->handleIcon($values);
            }

            if ($name === static::CONFIG_NAME_ICON_BASE64) {
                $values = $this->handleIconBase64($values);
            }

            $element['values'] = $values;
        }

        $request->setParam('elements', $elements);
    }

    /**
     * @param array $values
     *
     * @return array
     */
    public function handleIcon($values)
    {
        foreach ($values as &$value) {
            $this->base64 = $this->encoder->encodeImageByUrl($value['value']);
            $this->shopId = $value['shopId'];

            $value['value'] = '';
        }

        return $values;
    }

    /**
     * @param array $values
     *
     * @return array
     */
    public function handleIconBase64($values)
    {
        if (empty($values)) {
            $values[0]['id'] = 0;
        }

        foreach ($values as &$value) {
            $value['shopId'] = $this->shopId;

            if ($this->base64 !== '') {
                $value['value'] = $this->base64;
            }
        }

        return $values;
    }

    /**
     * @return string
     */
    public function getBase64()
    {
        return $this->base64;
    }
}
