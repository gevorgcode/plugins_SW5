<?php

namespace ApcCustomTab\Subscriber;

use Enlight\Event\SubscriberInterface;
use ApcCustomTab\Models\TabModel\TabModel;

class TemplateSubscriber implements SubscriberInterface
{
    /**
     * @var
     */
    private $pluginDirectory;
    protected $modelManager;
    protected $alias = 'tabModel';
    protected $tabModel = TabModel::class;
    /**
     * @param $pluginDirectory
     */
    public function __construct($pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Inheritance_Template_Directories_Collected' => 'onCollectTemplateDirs',
            'Enlight_Controller_Action_PostDispatchSecure' => 'onArticlePostDispatch',
            'Enlight_Controller_Action_PreDispatch_Frontend_Detail' => 'onFrontendPreDishpatch'
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onFrontendPreDishpatch(\Enlight_Event_EventArgs $args){
        $tabGroup = new $this->tabModel;
        $controller = $args->getSubject();
        $request = $controller->Request();
        $articleId = $request->sArticle;
//        var_dump($request->sArticle); exit;
        if(!$articleId){
            return;
        }
        $sql= "SELECT `main_detail_id` FROM `s_articles` WHERE `id` = ?" ;
        
        $detailId = Shopware()->Db()->fetchOne($sql, [$articleId]);
        $tabs = $tabGroup->getTabsByArticle($detailId);
        $view = $controller->View();
        $view->assign('tabs', $tabs);
    }
    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onCollectTemplateDirs(\Enlight_Event_EventArgs $args) {
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDirectory . '/Resources/views';
        return $dirs;
    }

    public function onArticlePostDispatch(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Backend_Article $controller */
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');
        if ($request->getActionName() == 'index') {
           $view->extendsTemplate('backend/apc_custom_tab/app.js');
            
        }

        if ($request->getActionName() == 'load') {
           $view->extendsTemplate('backend/apc_custom_tab/view/detail/window.js');
        }
    }

}
