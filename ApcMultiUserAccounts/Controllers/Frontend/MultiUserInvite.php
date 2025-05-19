<?php

/**
 * Shopware_Controllers_Frontend_MultiUserInvite
 */

class Shopware_Controllers_Frontend_MultiUserInvite extends Enlight_Controller_Action{

    private     $userService;
    private     $db;
    private     $statuses;

     /**
     * Init controller method
     */
    public function init(){
        /** @var \ApcMultiUserAccounts\Services\UserService $userService */
        $this->userService      = $this->container->get('apc_multiuser_user_service');
        $this->db               = Shopware()->Db();

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
        $user = $this->userService->findByToken($params['token']);

        //check if all params is correct
        if ($user && $user->getEmail() == $params['email'] && $user->getStatusId() == $this->statuses['pending']['id'] && !$this->db->fetchOne('SELECT `id` FROM `s_user` WHERE `email` = :email', ['email' => $params['email']])) {       
            

            



            $this->View()->Assign('multiUserInfo', $user);
            return;

            /**
             * TODO
             *              sessionum pahel email u token
             *              save -ic araj subscriberum stugel u mi ban anel
             *              get all country list
             * 1. stugel ete user chka cuyc tal es actioni tpl vortex klracni bolor partadir dashter@ logini parz teska@ usave
             * 2. hajox save @lneluc heto poxel status@ active, avelacnel userid multi user usersum, iran redirect anel logini ej
             * 3. logerum avelacnel acepti log, status changed log
             * 4. masterin mail uxarkel vor acept a arel, 
             */
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
        if ($user && $user->getEmail() == $params['email'] && ($user->getStatusId() == $this->statuses['pending']['id'] || $this->statuses['rejected']['id'])) {            
            if ($user->getStatusId() == $this->statuses['pending']['id']) {
                $user->setStatusId($this->statuses['rejected']['id']);
                $this->userService->update($user);
                $this->userService->createStatusHistory($previeousStatusId = $this->statuses['pending']['id'], $user->getStatusId(), $user->getId());
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