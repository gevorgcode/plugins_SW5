<?php

/**
 * Shopware_Controllers_Frontend_MultiUserInvite
 */

class Shopware_Controllers_Frontend_MultiUserInvite extends Enlight_Controller_Action{

    private     $userService;
    private     $db;
    private     $statuses;
    private     $session;
    private     $admin;

     /**
     * Init controller method
     */
    public function init(){
        /** @var \ApcMultiUserAccounts\Services\UserService $userService */
        $this->userService      = $this->container->get('apc_multiuser_user_service');
        $this->db               = Shopware()->Db();
        $this->session          = Shopware()->Session();
        $this->admin            = Shopware()->Modules()->Admin();

        //use like this $this->statuses['pending']['id']
        $multiuserStatuses = $this->db->fetchAll('SELECT * FROM `multiuser_statuses`');
        $this->statuses = [];
        foreach ($multiuserStatuses as $row) {            
            $this->statuses[$row['system_name']]['id'] = (int)$row['id'];
            $this->statuses[$row['system_name']]['name'] = $row['name'];
            $this->statuses[$row['system_name']]['description'] = $row['description'];
        } 

        $this->View()->assign('SeoMetaRobots', 'noindex,nofollow');
    }

    //logic action to activate from email link
    public function activateAction () {        
        
        $params = $this->clearParams($this->Request()->getParams());

        //get user from multiuser_user by token
        $token = $params['token'] ?? '';
        $user = $this->userService->findByToken($token);

        //check if all params is correct
        if ($user && $user->getEmail() == $params['email'] && $user->getStatusId() == $this->statuses['pending']['id'] && !$this->db->fetchOne('SELECT `id` FROM `s_user` WHERE `email` = :email', ['email' => $params['email']])) {   
            
            // //logout navsyaki
            if ($this->session->OffsetGet('sUserId')) {
                $this->admin->logout(); 
                echo '<script>location.reload();</script>';
            }                       

            $this->session->offsetSet('multiuser_em', $params['email']);
            $this->session->offsetSet('multiuser_tok', $token);

            $this->View()->assign('country_list', Shopware()->Modules()->Admin()->sGetCountryList());
            $this->View()->Assign('multiUserInfo', $user);

            if ($params['redirectParams']) {
                $this->View()->Assign('multiUserInfoParams', $params);
            }
            return;            
        }

        //redirects to error page if incorrect params
        $this->redirect([
            'controller' => 'error',
            'action' => 'index',
        ]);
        return;      
    }

    //logic action to activate from email link
    public function rejectAction () {
        
        $params = $this->clearParams($this->Request()->getParams());

        //get user from multiuser_user by token
        $user = $this->userService->findByToken($params['token']);

        //check if all params is correct
        if ($user && $user->getEmail() == $params['email'] && ($user->getStatusId() == $this->statuses['pending']['id'] || $user->getStatusId() == $this->statuses['rejected']['id'])) {            
            if ($user->getStatusId() == $this->statuses['pending']['id']) {
                $user->setStatusId($this->statuses['rejected']['id']);
                $this->userService->update($user);
                $this->userService->createStatusHistory($previeousStatusId = $this->statuses['pending']['id'], $user->getStatusId(), $user->getId(), $changedBy = 'Benutzer', $comment = 'der Benutzer selbst die Einladung abgelehnt hat');
            }
            return;
        }

        //redirects to error page if incorrect params
        $this->redirect([
            'controller' => 'error',
            'action' => 'index',
        ]);
        return;
    }

    private function clearParams($params = []) {
        foreach($params as &$param) {
            if (is_array($param)) {
                // Recursively clear nested arrays
                $param = $this->clearParams($param);
            } else {
                $param = htmlspecialchars(stripslashes(trim((string) $param)));
            }
        }
        
        return $params;
    }
}