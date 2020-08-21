<?php

namespace GenRegisterEmail\Subscriber;

use Enlight\Event\SubscriberInterface;
use GenRegisterEmail\Components\Constants;
use Shopware\Components\Random;


/**
 * Class Resources
 * @package Shopware\GenRegisterEmail\Subscriber
 */
class RegisterEmail implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginBaseDirectory;

    /**
     * Subscriber class constructor.
     *
     * @param string $pluginBaseDirectory
     */
    public function __construct($pluginBaseDirectory)
    {
        $this->pluginBaseDirectory = $pluginBaseDirectory;
    }

    /**
     * Returns an array of events you want to subscribe to
     * and the names of the corresponding callback methods.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Modules_Admin_SaveRegister_Successful'=> 'onSuccessfullRegister',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Account' => 'onPreDispatchAccount',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout'=>'onPreDispatchCheckout',
            'Theme_Inheritance_Template_Directories_Collected' => 'onCollectTemplateDirs',
        ];
    }

    public function onCollectTemplateDirs(\Enlight_Event_EventArgs $args) {
        $dirs = $args->getReturn();
        
        
        $dirs[] = $this->pluginBaseDirectory . '/Resources/Views';
  
     
        return $dirs;
        
           
    }
    
    /**
     *
     * @param \Enlight_Event_EventArgs $args
     */
    public function onSuccessfullRegister(\Enlight_Controller_ActionEventArgs $args)
    { 
        $userId = $args->getId();
        $hash = Random::getAlphanumericString(32);
      
        $url = Shopware()->Container()->get('router')->assemble(['controller'=>'confirm','hash'=>$hash]);
        var_dump($url); 

        $sql = "SELECT `email`, `firstname`, `lastname` FROM `s_user` WHERE `id` = ?";
        $data = Shopware()->Db()->fetchRow($sql,$userId);
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
       
        $context = ["link" => $url, 'username' => $firstname, 'userlastname' => $lastname, 'usermail' => $email];
        $mail = Shopware()->TemplateMail()->createMail(Constants::EMAIL_TEMPLATE, $context);
       
        $mail->addTo($email);
      
        try {
            $mail->send();
        } catch(\Exception $ex) {
           die($ex->getMessage());
        }
      
        $sql = "INSERT INTO `s_core_optin` SET `hash` = ?, `data` = ? ";
        Shopware()->Db()->query($sql, [$hash, $userId]);

        $sql = "UPDATE `s_user_attributes` SET `tur` = 1 WHERE `userID` = ?";
        Shopware()->Db()->query($sql, $userId);
    }

    public function onPreDispatchAccount(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->getSubject();
        
        return $this->validateUser($controller);
    }
    
    public function onPreDispatchCheckout(\Enlight_Controller_ActionEventArgs $args) 
    {
        $controller = $args->getSubject();
        
        return $this->validateUser($controller);
    }
    
    private function validateUser($controller) {
        $userId = Shopware()->Session()->get('sUserId');
        $sql = "SELECT `tur` FROM `s_user_attributes` WHERE `userID` = ? ;";
        $confirm = Shopware()->Db()->fetchOne($sql, $userId);
        if($confirm == 1){ // if $confirm == 1 means user not authorized
            return $controller->redirect(['controller' => 'confirm']);
        } 
    }
 
}
?>