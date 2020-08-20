<?php

namespace GenComment\Subscriber;

use Enlight\Event\SubscriberInterface;
use PDO;

class GenCommentSubscriber implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;
    
    /**
     * @var \Enlight_Template_Manager
     */
    private $templateManager;

   /**
     * @param $pluginDirectory
     * @param \Enlight_Template_Manager $templateManager
     */
    public function __construct(string $pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;        
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onCollectedTemplates',
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Order' => 'onUpdateUserComment',            
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onAddCommentInCheckout'            
        ];
    }
     /**
     * @param \Enlight_Event_EventArgs $args
     */
    public function onCollectedTemplates(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->get('subject');
        $view = $controller->View();
        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');
    }
    
     
    public function onUpdateUserComment(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->get('subject');
        $request = $controller->Request();              
        $actionName = $request->getActionName();
        
        if ($actionName != 'save') {
            return;
        }   
        
        $customer = reset($request->getParam('customer'));        
        $comment = $request->getParam('comment');        
        $userId = $customer['id'];
        
        $sql = 'UPDATE `s_user_attributes` SET `comment` = ? WHERE `userID` = ?;';
        Shopware()->Db()->query($sql, [$comment, $userId]);
        
    } 
    
     public function onAddCommentInCheckout(\Enlight_Event_EventArgs $args)
    {
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();        
        $actionName = $request->getActionName();

        if($actionName != 'finish'){
            return;
        }         
        
        $userData = $view->getAssign('sUserData');
        $userIdStr = $userData['additional']['user']['userID'];
        $userId = intval($userIdStr);         
        $orderNumber = $view->getAssign('sOrderNumber');
         
        $sql = 'SELECT `comment` FROM `s_user_attributes` WHERE `userID` = ?';
        $comment = Shopware()->Db()->fetchOne($sql, $userId);
         
        if (!$comment){
            return;
        }
                 
        $sql = 'UPDATE `s_order` SET `comment` = ? WHERE `ordernumber` = ?;';
        Shopware()->Db()->query($sql, [$comment, $orderNumber]);
    } 
}














