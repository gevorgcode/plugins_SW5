<?php

namespace ApcMultiUserAccounts\Subscriber;

use Enlight\Event\SubscriberInterface;

class Subscriber implements SubscriberInterface
{
    /**
     * @var
     */
    private $pluginDirectory;  
    private $session; 
    private $db;
   
    /**
     * @param $pluginDirectory
     */
    public function __construct($pluginDirectory)
    {
        $this->pluginDirectory  = $pluginDirectory;
        $this->session          = Shopware()->Session();
        $this->db               = Shopware()->Db();        
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Inheritance_Template_Directories_Collected' => 'onCollectTemplateDirs',    
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontend',
            // 'Enlight_Controller_Action_PostDispatchSecure_Widgets' => 'onFrontend',
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

    public function onFrontend(\Enlight_Event_EventArgs $args) {
        $multiUserShow = false;
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        if (!Shopware()->Modules()->Admin()->sCheckUser()){
            return;
        }
        
        $userId = $this->session->offsetGet('sUserId');
        $isCompanyAndActive = $this->db->fetchRow(
            'SELECT sa.company AS company, su.active
            FROM s_user_addresses sa
            JOIN s_user su ON sa.user_id = su.id
            WHERE sa.user_id = :userId',
            ['userId' => $userId]
        );

        if ($isCompanyAndActive) {

            $admin = $this->db->fetchRow("SELECT * FROM `multiuser_accounts` WHERE `master_user_id` = $userId");
            if ($admin) {
                $multiUserShow = true;
            }else{
                $user = $this->db->fetchRow("SELECT * FROM `multiuser_users` WHERE `user_id` = $userId");
                if (!$user) {
                    $multiUserShow = true;
                }
            }
        }

        $view->assign('multiUserShow', $multiUserShow); 
    }
}
