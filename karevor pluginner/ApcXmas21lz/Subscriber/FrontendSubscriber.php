<?php

namespace ApcXmas21lz\Subscriber;

use Enlight\Event\SubscriberInterface;
use ApcXmas21lz\Components\Constants;

class FrontendSubscriber implements SubscriberInterface
{       
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_Predispatch' => 'onPredispatch',
        ];
    }    
     /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onPredispatch(\Enlight_Event_EventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        
        if ($request->getModuleName() == 'backend' || $request->getModuleName() == 'api'){
            return;
        }
        $locale = Shopware()->Shop()->getLocale()->getLocale();
        
        $products = Constants::XMAS21_PRODUCTS;
        
        $timestamp = time();
        if ($timestamp < 1638313199 || $timestamp > 1640386799){
            return;
        }
        $day = date('d', $timestamp);
        $product = $products["$day"];

        if ($product['cat']){
            $categoryName = $product['cat'];
            $categoryUrls = Constants::XMAS21_CATEGORY_URLS;
            $product['url'] = $categoryUrls["$categoryName"]["$locale"];

            if ($product['cat'] = 'Remote'){

                if ($locale == 'en_GB'){
                    $product['articleName2'] = 'Licenses';
                }elseif($locale == 'fr_FR'){
                    $product['articleName2'] = 'Licences';
                }elseif($locale == 'es_ES'){
                    $product['articleName2'] = 'Licencias';
                }elseif($locale == 'it_IT'){
                    $product['articleName2'] = 'Licenze';
                }                
            }

            if ($product['cat'] = 'Combo'){

                if ($locale == 'en_GB'){
                    $product['articleName1'] = 'Combo-Packs';
                }elseif($locale == 'fr_FR'){
                    $product['articleName1'] = ' Des packages-Combo';
                }elseif($locale == 'es_ES'){
                    $product['articleName1'] = 'Ahorre con';
                    $product['articleName2'] = 'paquetes combinados';
                }elseif($locale == 'it_IT'){
                    $product['articleName1'] = 'Risparmia con';
                    $product['articleName2'] = 'pacchetti combinati';
                }                
            }
        }
       
        $view->assign('xmas21', $product);
               
    }
}

