<?php

namespace ApcKetchupAndMayo\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;

class CheckoutSubscriber implements SubscriberInterface
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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onCheckoutAddArticle',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendPostDispatch'
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onCheckoutAddArticle(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();


        $actionName = $request->getActionName();
        if($actionName == 'ajax_add_article'){
            $view = $controller->View();
            $id = $view->sArticle['articleID'];

            $articleData = Shopware()->Modules()->Articles()->sGetArticleById($id);

            if(empty($articleData['sRelatedArticles'])){
                return;
            }

            $view->accessoryArticles = $articleData['sRelatedArticles'];
            return;
      }

      if($actionName == 'finish'){
          $view = $controller->View();
          $basket = $view->sBasket;
          $accessoryArticles = [];
          foreach($basket['content'] as $article){
              $articleData = Shopware()->Modules()->Articles()->sGetArticleById($article['articleID']);
              $accessoryArticles = array_merge($accessoryArticles, $articleData['sRelatedArticles']);
              $accessoryArticles = array_intersect_key($accessoryArticles, array_unique(array_map('serialize', $accessoryArticles)));
          }
          if(empty($accessoryArticles)){
              return;
          }
          $view->accessoryArticles = $accessoryArticles;

      }

    }

    public function onFrontendPostDispatch(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();

        $sUserLoggedIn = Shopware()->Modules()->Admin()->sCheckUser();
        $controller->View()->assign('sUserLoggedIn', $sUserLoggedIn);
        if($sUserLoggedIn){
            $controller->View()->assign('userInfo', Shopware()->Container()->get('shopware_account.store_front_greeting_service')->fetch());
        }
    }


}
