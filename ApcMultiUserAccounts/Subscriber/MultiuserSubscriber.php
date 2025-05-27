<?php

namespace ApcMultiUserAccounts\Subscriber;

use Enlight\Event\SubscriberInterface;

class MultiuserSubscriber implements SubscriberInterface
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

        //check multiuser user or not
        if (Shopware()->Modules()->Admin()->sCheckUser()){
            $userId = $this->session->offsetGet('sUserId');

            if ($userId) {
                // Check if there is a user ID in the multi user users table
                $sql = 'SELECT * FROM `multiuser_users` WHERE `user_id` = ?';
                $multiUser = $this->db->fetchRow($sql, [$userId]);

                if ($multiUser) {

                    /** @var \ApcMultiUserAccounts\Services\UserService $userService */
                    $userService = Shopware()->Container()->get('apc_multiuser_user_service');

                    //delete. block customer if he changes her email
                    if ($this->session->userInfo['email'] && $this->session->userInfo['email'] != $multiUser['email']) {    
                        $activeStatusId = 1;                    
                        $deletedStatusId = 5;                    
                        $this->db->query("UPDATE `s_user` SET `active` = 0 WHERE `id` = $userId");
                        $this->db->query("UPDATE `multiuser_users` SET `status_id` = $deletedStatusId WHERE `id` = :multiuser_id", ['multiuser_id' => $multiUser['id']]);
                        $userService->createStatusHistory($activeStatusId, $deletedStatusId, $multiUser['id'], $changedBy = 'System', $comment = 'Der Benutzer hat die E-Mail-Adresse auf ' . $this->session->userInfo['email'] . ' geändert, wodurch das Konto gesperrt wurde. Bitte wenden Sie sich an den Shop-Support, um das Konto wiederherzustellen.');
                        Shopware()->Modules()->Admin()->logout(); 
                        echo '<script>location.reload();</script>';
                    }

                    if (
                        $this->session->offsetGet('multiuser_user_id') 
                        && $this->session->offsetGet('multiuser_user_id') == $multiUser['user_id'] 
                        && $this->session->offsetGet('multiuser_id')
                        && $this->session->offsetGet('multiuser_id') == $multiUser['id']                        
                        && $this->session->offsetGet('multiuser_role_id')
                        && $this->session->offsetGet('multiuser_role_id') == $multiUser['role_id']                        
                        && $this->session->offsetGet('multiuser_status_id')
                        && $this->session->offsetGet('multiuser_status_id') == $multiUser['status_id']               
                    ) {
                        //nothing to do
                    }else{
                        //set session
                        $this->session->offsetSet('multiuser_id', $multiUser['id']);
                        $this->session->offsetSet('multiuser_user_id', $userId);
                        $this->session->offsetSet('multiuser_role_id', $multiUser['role_id']);
                        $this->session->offsetSet('multiuser_status_id', $multiUser['status_id']);

                        //create login log                        
                        $userService->createLog($multiUser['id'], $action = 'Login', $comment = 'Kunde hat sich erfolgreich angemeldet.');
                    }
                    $multiUser['statuseInfo'] = $this->db->fetchRow('SELECT * FROM `multiuser_statuses` WHERE `id` = :status_id', ['status_id' => $multiUser['status_id']]);
                    $multiUser['roleInfo'] = $this->db->fetchRow('SELECT * FROM `multiuser_roles` WHERE `id` = :role_id', ['role_id' => $multiUser['role_id']]);
                    //todo add all needed info
                    $view->assign('multiUser', $multiUser);
                } else {
                    // Clear if there is no entry
                    $this->session->offsetUnset('multiuser_user_id');
                }
            }            
        }
    }

    // private function clearParams($params = []) {
    //     foreach($params as &$param) {
    //         if (is_array($param)) {
    //             // Recursively clear nested arrays
    //             $param = $this->clearParams($param);
    //         } else {
    //             $param = htmlspecialchars(stripslashes(trim((string) $param)));
    //         }
    //     }
        
    //     return $params;
    // }
}
