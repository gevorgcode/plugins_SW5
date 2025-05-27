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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Register' => 'onFrontendRegister',
            // 'Enlight_Controller_Action_PostDispatchSecure_Widgets' => 'onFrontend',
            'Shopware_Modules_Admin_SaveRegister_Successful' => 'onAfterSuccessfulRegister',
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

        //show multiuser section on sidebar or not
        if (Shopware()->Modules()->Admin()->sCheckUser()){
            $userId = $this->session->offsetGet('sUserId');
            $isCompanyAndActive = $this->db->fetchOne(
                'SELECT sa.company AS company
                FROM s_user_addresses sa
                JOIN s_user su ON sa.user_id = su.id
                WHERE sa.user_id = :userId
                AND su.active = 1',
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

    //redirect to multiuser register
    public function onFrontendRegister(\Enlight_Event_EventArgs $args) {
        $controller = $args->getSubject();
        $request = $controller->Request();

        $multiuserEmail = $this->session->offsetGet('multiuser_em');
        $multiuserToken = $this->session->offsetGet('multiuser_tok');
        if ($multiuserEmail && $multiuserToken && $request->getActionName() == 'index') {
            $controller->forward('activate', 'MultiUserInvite', 'frontend', ['email' => $multiuserEmail, 'token' => $multiuserToken, 'redirectParams' => 1]);
            return;
        }
    }

    public function onAfterSuccessfulRegister(\Enlight_Event_EventArgs $args) {
        $userId = $args->get('id');
        $multiuserEmail = $this->session->offsetGet('multiuser_em');
        $multiuserToken = $this->session->offsetGet('multiuser_tok');

        if ($multiuserEmail && $multiuserToken && $userId) {
            $user = Shopware()->Modules()->Admin()->sGetUserData();

            if ($user['additional']['user']['email'] == $multiuserEmail) {
                /** @var \ApcMultiUserAccounts\Services\UserService $userService */
                $userService = Shopware()->Container()->get('apc_multiuser_user_service');

                $multiuser = $userService->findByToken($multiuserToken);

                if ($multiuser && is_object($multiuser)) {
                    $statuses = $this->db->fetchAll('SELECT * FROM `multiuser_statuses`');

                    $pendingId = null;
                    $activeId = null;
                    $rejectedId = null;

                    foreach ($statuses as $status) {
                        if ($status['system_name'] == 'pending') {
                            $pendingId = $status['id'];
                        }
                        if ($status['system_name'] == 'active') {
                            $activeId = $status['id'];
                        }
                        if ($status['system_name'] == 'rejected') {
                            $rejectedId = $status['id'];
                        }
                    }
                    
                    if ($multiuser->getStatusId() == $pendingId) {

                        //1. modify user 
                        $multiuser->setStatusId($activeId);
                        $multiuser->setUserId($userId);
                        $userService->update($multiuser);


                        //2. add log and status history
                        //add status change pending->com_get_active_object
                        $userService->createStatusHistory($pendingId, $activeId, $multiuser->getId(), $changedBy = 'Benutzer', $comment = 'der Benutzer hat die Einladung angenommen');
                        //add log invite confirmed
                        $userService->createLog($multiuser->getId(), $action = 'Einladung angenommen', $comment = 'Der Benutzer hat die Einladung angenommen');


                        //3. remove sessions multiuser x2
                        $this->session->offsetSet('multiuser_em', null);
                        $this->session->offsetSet('multiuser_tok', null);
                        

                        //4. reject all other pending with this email
                        $allByEmail = $userService->findAllByEmail($multiuserEmail);
                        foreach ($allByEmail as $item) {
                            if (is_object($item) && $item->getStatusId() == $pendingId) {
                                $item->setStatusId($rejectedId);
                                $userService->update($item);
                                $userService->createStatusHistory($pendingId, $rejectedId, $item->getId(), $changedBy = 'System', $comment = 'Der Benutzer hat die Einladung eines anderen Benutzers angenommen');
                                $userService->createLog($item->getId(), $action = 'Einladung abgelehnt', $comment = 'Der Benutzer hat die Einladung eines anderen Benutzers angenommen');
                            }
                        }
                    }
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
