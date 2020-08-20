<?php

namespace ApcPrepayment\Subscriber;

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onFrontendCheckout'
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

     public function onFrontendCheckout(\Enlight_Event_EventArgs $args) {
         $controller = $args->getSubject();
         $view = $controller->View();
         $request = $controller->Request();
         $response = $controller->Response();
         $actionName = $request->getActionName();        
    
         if (($actionName == 'confirm')){
             $paymentId = $view->getAssign('sPayment')['id'];
             if ($paymentId == 90 || $paymentId == 89){
                  $comment = 'IT-NERD24 GmbH 
                  BIC: 231486 
                  Number : 06222297 
                  Name of the Bank: Barclays';
                  $view->assign('sComment', $comment);
                  $view->assign('Payoner', true);
             }
         }
         
         if (($actionName == 'finish')){
             $sOrderNumber = $view->getAssign('sOrderNumber');
             
             $paymentId = $view->getAssign('sPayment')['id'];
             if ($paymentId == 90 || $paymentId == 89){
                   $comment = 'IT-NERD24 GmbH <br> BIC: 231486 <br> Number : 06222297 <br> Name of the Bank: Barclays';

                 if (($_SERVER['HTTP_HOST'] == 'it-nerd24.uk') || ($_SERVER['HTTP_HOST'] == 'en.itnerd241.timmeserver.de')){
                    $sql = 'UPDATE `s_order` SET `customercomment` = ? WHERE `ordernumber` = ? AND `paymentID`=?;';
                    Shopware()->Db()->query($sql, [$comment, $sOrderNumber, $paymentId]);
                 }
                 $view->assign('Payoner', true);
                 $view->assign('sComment', $comment);
                 
                 /////
                 $userId = Shopware()->Session()->offsetGet('sUserId');
                 $userData = Shopware()->Db()->fetchRow("SELECT `salutation`,`lastname`,`email` FROM `s_user` WHERE `id` = ?",[$userId]);  
                 $orderData = Shopware()->Db()->fetchRow("SELECT * FROM `s_order` WHERE `ordernumber` = ?",[$sOrderNumber]);
                 $context['comment'] = $comment;
                 $context['userdata'] = $userData;                 
                 $context['orderData'] = $orderData;
                 $mail = Shopware()->TemplateMail()->createMail('itnerdPayoner',$context);
                 $mail->addTo($userData['email']);
                 if (!$request->getCookie(payoner_sended)){
                     try {
                    $mail->send();
                    } catch(\Exception $ex) {
                       die($ex->getMessage());
                    }
                    $response->setCookie('payoner_sended', 1, time()+200, '/');
                 }
                  
             } 
         }
                 
             
                  
         
     }   
}
