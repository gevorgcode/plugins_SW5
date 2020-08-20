<?php

namespace ApcCustomPh\Subscriber;

use Enlight\Event\SubscriberInterface;

class TemplateSubscriber implements SubscriberInterface
{
    /**
     * @var
     */
    private $pluginDirectory;  
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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontend',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Account' => 'onFrontendRequestFrom',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Note' => 'onFrontendRequestFrom',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Forms' => 'onFrontendForms',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onFrontendFormsCheckout',
        ];
    }    
     /**
     * @param Enlight_Event_EventArgs $args
     */
    public function onCollectTemplateDirs(\Enlight_Event_EventArgs $args) {
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDirectory . '/Resources/views';
        return $dirs;
    }
    
    public function onFrontendFormsCheckout(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();        
        
        $params = $request->getParams();
        if ($params['action'] == 'cart' && $params['sfromform'] == 'form24'){
            $view->assign('sfromform', true);
        }        
    }
    
    public function onFrontendForms(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();        
        
        $sFid = $request->getParam('sFid');
        $success = $request->getParam('success');
        
        if ($sFid == 24 && $success){
            $controller->redirect([
                'controller' => 'checkout',
                'action' => 'cart',
                'sfromform' => 'form24'
            ]);
        }
    }
    
    public function onFrontendRequestFrom(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $params = $request->getParams();
        $sLicNotes = Shopware()->Modules()->Basket()->sGetNotes();
        if (!empty($sLicNotes)){
            $view->assign('sNotesEmpty', true);
        }        
        if ($params['request_from']){
            $RequestFrom = $params['request_from'];
            $view->assign('RequestFrom', $RequestFrom);
        }
        if ($params['sfrom']){            
            $sAction = $params['sfrom'];
            $view->assign('sAction', $sAction);
        }
        if ($params['sFromeNote']){            
            $sAction = 'note';
            $view->assign('sAction', $sAction);
            $controller->redirect([
                'controller' => 'account',
                'action' => 'index',
                'sfrom' => 'note'
            ]);
        }
        if (!$params['sFromeNote'] && !$params['sfrom'] && !$params['request_from'] && $params['controller'] == 'note' && !$params['action'] == 'add_article'){            
            $controller->redirect([
                'controller' => 'account',
                'action' => 'index',
                'sfrom' => 'note'
            ]);
        }
        
        
    }
    
    public function onFrontend(\Enlight_Event_EventArgs $args)
    {        
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        
        $trsh = false;
        $view->assign('trsh', $trsh);
        
        if (!Shopware()->Modules()->Admin()->sCheckUser()){
            return;
        }
        $userId = Shopware()->Session()->offsetGet('sUserId');
        $email = Shopware()->Db()->fetchOne(
            'SELECT s_user.email AS email
            FROM s_user                
            WHERE s_user.id = :userId',
            ['userId' => $userId]
        );
        
        if ($email == 'demo@gmail.com' || $email == 'bodewig@trustedshops.de'){
            $trsh = true;
            $view->assign('trsh', $trsh);
        }       
    }
}
