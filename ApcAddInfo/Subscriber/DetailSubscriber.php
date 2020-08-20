<?php

namespace ApcAddInfo\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;

class DetailSubscriber implements SubscriberInterface
{
    private $pluginDir = null;

    public function __construct($pluginBaseDirectory)
    {
        $this->pluginDir = $pluginBaseDirectory;
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onDetailIndex',
            // 'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onPostDispatch'
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
     // public function onPostDispatch(\Enlight_Event_EventArgs $args){
     //     $controller = $args->getSubject();
     //     $request = $controller->Request();
     //     if($request->getParam('isDebug')){
     //         $controller->View()->assign('isDebug', 'true');
     //     }
     // }

     public function onDetailIndex(\Enlight_Event_EventArgs $args){
         $controller = $args->getSubject();
         $request = $controller->Request();


        $actionName = $request->getActionName();

        if($actionName != 'index'){
            return;
        }

        $view = $controller->View();


        $catInfo = $view->sCategoryInfo;
        $articleInfo = $view->sArticle;
        $catInfo = Shopware()->Modules()->sCategories()->sGetCategoriesByParent($articleInfo['categoryID']);
        $cat = end($catInfo);
        $sql = 'SELECT * FROM `s_categories_attributes` WHERE `categoryID` = ? AND `display_add_info` = "1" ;';
        $attr = Shopware()->Db()->fetchRow($sql,$cat['id']);
        if(empty($attr)){
            return;
        }
        $mediaId = [
            '1' => $attr['tab_image1'],
            '2' => $attr['tab_image2'],
            '3' => $attr['tab_image3']
        ];
        foreach($mediaId as $key => $id){
            $mediaPath = Shopware()->Db()->fetchOne('SELECT `path` FROM `s_media` WHERE `id` = ?',array($id));
            $media[$key] = Shopware()->Container()->get('shopware_media.media_service')->getUrl($mediaPath);
        }

        $addInfo = [
            '1' => [
                'title' => $attr['tab_title1'],
                'image' => $media[1],
                'text' => $attr['tab_text1']
            ],
            '2' => [
                'title' => $attr['tab_title2'],
                'image' => $media[2],
                'text' => $attr['tab_text2']
            ],
            '3' => [
                'title' => $attr['tab_title3'],
                'image' => $media[3],
                'text' => $attr['tab_text3']
            ]
        ];
        $view->addInfo = $addInfo;

    }


}
