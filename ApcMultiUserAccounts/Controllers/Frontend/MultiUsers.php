<?php

use ApcMultiUserAccounts\Models\Account;
use ApcMultiUserAccounts\Models\User;
use ApcMultiUserAccounts\Models\Role;
use ApcMultiUserAccounts\Services\AccountService;
use ApcMultiUserAccounts\Services\UserService;
use ApcMultiUserAccounts\Components\Constants;

/**
 * Shopware_Controllers_Frontend_MultiUsers
 */

class Shopware_Controllers_Frontend_MultiUsers extends Enlight_Controller_Action{   
    
    private     $admin;
    private     $router;
    private     $db;
    private     $userId;
    private     $session;
    private     $accountService;
    private     $userService;
    private     $roles;
    private     $roles_sys;
    private     $statuses;
    private     $account;

    /**
     * Init controller method
     */
    public function init(){  
        $this->admin = Shopware()->Modules()->Admin();

        if (!$this->admin->sCheckUser()){
            $this->redirect([
                'controller' => 'account',
                'action' => 'login',
                'sTarget' => 'MultiUsers',
                'sTargetAction' => 'index',
            ]);
            return;
        }   

        $this->session          = Shopware()->Session();
        $this->router           = Shopware()->Container()->get('router');
        $this->userId           = $this->session->offsetGet('sUserId');
        $this->db               = Shopware()->Db();
        $this->roles            = $this->db->fetchAll('SELECT * FROM `multiuser_roles`');        

        //use like this $this->statuses['pending']['id']
        $multiuserStatuses = $this->db->fetchAll('SELECT * FROM `multiuser_statuses`');
        $this->statuses = [];
        foreach ($multiuserStatuses as $row) {            
            $this->statuses[$row['system_name']]['id'] = (int)$row['id'];
            $this->statuses[$row['system_name']]['name'] = $row['name'];
            $this->statuses[$row['system_name']]['description'] = $row['description'];
        } 

        $this->roles_sys = [];
        foreach ($this->roles as $rowRoles) {            
            $this->roles_sys[$rowRoles['system_name']]['id'] = (int)$rowRoles['id'];
            $this->roles_sys[$rowRoles['system_name']]['name'] = $rowRoles['name'];
            $this->roles_sys[$rowRoles['system_name']]['description'] = $rowRoles['description'];
        } 

        /** @var \ApcMultiUserAccounts\Services\AccountService $accountService */
        $this->accountService   = $this->container->get('apc_multiuser_account_service');
        /** @var \ApcMultiUserAccounts\Services\UserService $userService */
        $this->userService      = $this->container->get('apc_multiuser_user_service');

        $this->account          = $this->accountService->findByMasterUserId($this->userId);

        //hide page if no admin or no company or oter user for this company (Buyer, ...)
        $multiUserShow = $this->checkMultiuserShow();
        if (!$multiUserShow) {
            $this->redirect([
                'controller' => 'account',
                'action' => 'index',
            ]);
            return;
        }    
        
        if (is_object($multiUserShow) && !$multiUserShow->isActive()) {
            $this->View()->assign('multiUserAccountDisabled', true); 
        }

        $this->View()->assign('SeoMetaRobots', 'noindex,nofollow');    
    }

    public function indexAction(){

        $return = [];
        $users = [];               

        if ($this->account) {
            $accountArray = $this->account->toArray();
            //get All users list for this account ($this->userId = this account admin user id)
            $users = $this->getUsersArray($accountArray['id']);
        }
        
        $return = [
            'account'   => $accountArray,
            'users'     => $users,
            'roles'     => $this->roles,
            'statuses'  => $this->statuses,
        ];

        $this->View()->assign('multiUserInfo', $return);

        $params = $this->clearParams($this->Request()->getParams());
        $this->View()->assign('params', $params);
    }  

    //logic action to send invitation email
    public function inviteAction () {
        $params = $this->clearParams($this->Request()->getParams());

        if (!(isset($params['email']) && filter_var($params['email'], FILTER_VALIDATE_EMAIL)) || !in_array($params['role'], array_column($this->roles, 'id'), true)) {
            $this->redirect([
                'controller' => 'error',
                'action' => 'index',
            ]);
            return;
        }

        //if already has customer with this email
        if ($this->db->fetchOne('SELECT `id` FROM `s_user` WHERE `email` = :email', ['email' => $params['email']])) {
            $this->forward('index', 'MultiUsers', 'frontend', ['erroremail' => 'Die angegebene E-Mail-Adresse wird bereits verwendet und kann daher nicht erneut hinzugefügt werden.']);
            return;
        }

        //if already send email to this customer from this master
        if ($this->db->fetchOne("SELECT `email` FROM `multiuser_users` WHERE `email` = :email AND `account_id` = (SELECT `id` FROM `multiuser_accounts` WHERE `master_user_id` = :userId)", ['email' => $params['email'], 'userId' => $this->userId])) {
            $this->forward('index', 'MultiUsers', 'frontend', ['erroremail' => 'Eine erneute Einladung an diese E-Mail-Adresse ist nicht möglich.']);
            return;
        }

        $token = bin2hex(random_bytes(16));

        $role = [];
        foreach ($this->roles as $roleArr) {
            if ($roleArr['id'] === $params['role']) {
                $role = $roleArr;
            }
        }

        $userData = $this->admin->sGetUserData();

        $context = [
            'token' => $token,
            'invitation' => [
                'link' => $this->router->assemble(['controller'=>'MultiUserInvite', 'action' => 'activate', 'email' => $params['email'], 'token' => $token]),
                'rejectLink' => $this->router->assemble(['controller'=>'MultiUserInvite', 'action' => 'reject', 'email' => $params['email'], 'token' => $token]),
                'message' => $params['comment'],
            ],
            'user' => [
                'firstname' => $userData["billingaddress"]['firstname'],
                'lastname' => $userData["billingaddress"]['lastname'],
                'companyName' => $userData["billingaddress"]['company'],
            ],
            'role' => [
                'id' => $role['id'],
                'name' => $role['name'],
                'description' => $role['description'],
            ],
        ];

        //create master account if not exist
        $account = $this->account;
        
        if (!$account) {
            $account = $this->createMasterAccount($userData["billingaddress"]['company']);
        }

        $multiuserId = $this->createUserReccord($params['email'], $account->getId(),$role['id'], $token);

        $mail = Shopware()->TemplateMail()->createMail(Constants::EMAIL_TEMPLATE_MULTIUSER_INVITE, $context);
        $mail->addTo($params['email']);
        try {
            $mail->send();
            $this->userService->createLog($multiuserId, $action = 'Einladung gesendet', $comment = 'Einladung erfolgreich gesendet');
            $this->redirect([
                'controller' => 'MultiUsers',
                'action' => 'index',
                'successMessage' => 'Die Einladung wurde erfolgreich an die E-Mail-Adresse ' . $params['email'] . ' gesendet.'
            ]);
            return;
        } catch(\Exception $ex) {
            die($ex->getMessage()); 
        } 
    }
    
    //edit user tpl
    public function editUserAction () {
        if (!$this->Request()->isPost()){
            $this->redirect([
                'controller' => 'error',
                'action' => 'index',
            ]);
            return;
        }

        $params = $this->clearParams($this->Request()->getParams());

        //get admin info my user id
        if ($this->account) {
            //get All users list for this account ($this->userId = this account admin user id)
            $users = $this->userService->findAllByAccountId($this->account->getId());

            foreach ($users as $user) {                
                if ($user->getId() == $params['multiuser_id'] && $user->getEmail() == $params['multiuser_email']) {
                    $userToEdit = $user;
                    break;
                }                
            }
        }

        if (is_object($userToEdit)) {
            $userArray = $userToEdit->toArray();
            foreach ($this->statuses as $statusKey => $status) {            
                if ((int)$status['id'] === (int)$userArray['statusId']) {
                    $userArray['status'] = $status['name'];
                    $userArray['status_sys_name'] = $statusKey;
                    break;
                }
            }
            foreach ($this->roles as $role) {
                if ((int)$role['id'] === (int)$userArray['roleId']) {
                    $userArray['role'] = $role['name'];
                    break;
                }
            }     
            
            $this->View()->Assign('user', $userArray);
            $this->View()->Assign('roles', $this->roles);
            $this->View()->Assign('statuses', $this->statuses);            
            return;
        }

        $this->redirect([
            'controller' => 'error',
            'action' => 'index',
        ]);
        return;
    }

    //edit user logic
    public function editAction () {
        if (!$this->Request()->isPost()){
            $this->redirect([
                'controller' => 'error',
                'action' => 'index',
            ]);
            return;
        }

        $params = $this->clearParams($this->Request()->getParams());

        $this->View()->assign('errormsg', $params['errormsg']);        

        if ($this->account) {
            //get All users list for this account ($this->userId = this account admin user id)
            $users = $this->userService->findAllByAccountId($this->account->getId());
            foreach ($users as $user) {                
                if ($user->getId() == $params['multiuser_id'] && $user->getEmail() == $params['multiuser_email']) {
                    $userToEdit = $user;
                    break;
                }                
            }

            if (is_object($userToEdit)) {
                $oldRoleId = $userToEdit->getRoleId();
                $oldStatusId = $userToEdit->getStatusId();

                $newRoleId = $this->roles_sys[$params['role']]['id'];
                $newStatusId = $this->statuses[$params['status']]['id'];

                $statusIds = [
                    'active' => $this->statuses['active']['id'],
                    'pending' => $this->statuses['pending']['id'],
                    'inactive' => $this->statuses['inactive']['id'],
                    'rejected' => $this->statuses['rejected']['id'],
                    'deleted' => $this->statuses['deleted']['id'],
                ];

                $success = false;
                //pending to reject
                if ($oldStatusId == $statusIds['pending'] && $newStatusId && $params['status'] == 'rejected') {
                    //change pending status to rejected
                    $userToEdit->setStatusId($newStatusId);
                    $success = true;                  
                }
                //active, inactive
                elseif ($newRoleId && $newStatusId) {
                    //active logic
                    if ($oldStatusId == $statusIds['active']) {
                        if ($params['status'] == 'inactive' || $params['status'] == 'deleted') {
                            //change active status
                            $userToEdit->setStatusId($newStatusId);
                            $success = true;
                        }
                        if ($newRoleId != $oldRoleId) {
                            //change active role
                            $userToEdit->setRoleId($newRoleId);
                            $success = true;
                        }                        
                    }
                    //inactive logic
                    elseif ($oldStatusId == $statusIds['inactive']) {
                        if ($params['status'] == 'active' || $params['status'] == 'deleted') {
                            //change inactive status
                            $userToEdit->setStatusId($newStatusId);
                            $success = true;
                        }
                        if ($newRoleId != $oldRoleId) {
                            //change inactive role
                            $userToEdit->setRoleId($newRoleId);
                            $success = true;
                        }                        
                    }                    
                }   

                if ($success == true) {
                    //call useredit update
                    $this->userService->update($userToEdit);
                    //check if ststus changes add log, if role changes add log
                    if ($newStatusId != $oldStatusId) {
                        //call user history
                        $this->userService->createStatusHistory($oldStatusId, $newStatusId, $userToEdit->getId(), $changedBy = 'Admin', $comment = '');
                        if ($params['status'] == 'deleted' || $params['status'] == 'inactive') {
                            $this->db->query('UPDATE `s_user` SET `active` = 0 WHERE `id` = :userID', ['userID' => $userToEdit->getUserId()]);
                        }
                        if ($params['status'] == 'active' && $oldStatusId == $statusIds['inactive']) {
                            $this->db->query('UPDATE `s_user` SET `active` = 1 WHERE `id` = :userID', ['userID' => $userToEdit->getUserId()]);
                        }
                    }
                    if ($newRoleId != $oldRoleId && $newRoleId != null) {
                        //call role history
                        $this->userService->createRoleHistory($oldRoleId, $newRoleId, $userToEdit->getId(), $comment = 'Der Administrator hat die Benutzerrolle geändert');
                    }
                    
                    //forward to indexAction, with params success (role , status) true
                    $this->redirect([
                        'controller' => 'MultiUsers',
                        'action' => 'index',
                        'successMessage2' => 'Die Änderungen am Benutzer mit der E-Mail-Adresse ' . $params['multiuser_email'] . ' wurden erfolgreich gespeichert.'
                    ]);
                    return;
                }else{
                    //if nothing changes , return to same page
                    $this->redirect([
                        'controller' => 'MultiUsers',
                        'action' => 'index',
                        'errorMessage2' => 'Keine Änderungen zum Speichern vorhanden.'
                    ]);
                    return;
                }
            }            
        }
        
        $this->redirect([
            'controller' => 'error',
            'action' => 'index',
        ]);
        return;
    }

    //resend invitation for pending users
    public function resendAction () {
        if (!$this->Request()->isPost()){
            $this->redirect([
                'controller' => 'error',
                'action' => 'index',
            ]);
            return;
        }

        $params = $this->clearParams($this->Request()->getParams());

        if ($this->account) {
            //get All users list for this account ($this->userId = this account admin user id)
            $users = $this->userService->findAllByAccountId($this->account->getId());
            foreach ($users as $user) {                
                if ($user->getId() == $params['multiuser_id'] && $user->getEmail() == $params['multiuser_email']) {
                    $userToResend = $user;
                    break;
                }                
            }

            if (is_object($userToResend) && $userToResend->getUserId() == null && $userToResend->getStatusId() == $this->statuses['pending']['id']) {
                $token = $userToResend->getToken();

                $role = [];
                foreach ($this->roles as $roleArr) {
                    if ($roleArr['id'] == $userToResend->getRoleId()) {
                        $role = $roleArr;
                    }
                }

                $userData = $this->admin->sGetUserData();

                $context = [
                    'token' => $token,
                    'invitation' => [
                        'link' => $this->router->assemble(['controller'=>'MultiUserInvite', 'action' => 'activate', 'email' => $userToResend->getEmail(), 'token' => $token]),
                        'rejectLink' => $this->router->assemble(['controller'=>'MultiUserInvite', 'action' => 'reject', 'email' => $userToResend->getEmail(), 'token' => $token]),
                        'message' => $params['comment'],
                    ],
                    'user' => [
                        'firstname' => $userData["billingaddress"]['firstname'],
                        'lastname' => $userData["billingaddress"]['lastname'],
                        'companyName' => $userData["billingaddress"]['company'],
                    ],
                    'role' => [
                        'id' => $role['id'],
                        'name' => $role['name'],
                        'description' => $role['description'],
                    ],
                ];

                $mail = Shopware()->TemplateMail()->createMail(Constants::EMAIL_TEMPLATE_MULTIUSER_INVITE, $context);
                $mail->addTo($userToResend->getEmail());
                try {
                    $mail->send();
                    $this->userService->createLog($userToResend->getId(), $action = 'Erneute Einladung gesendet', $comment = 'Erneute Einladung erfolgreich gesendet');
                    $this->redirect([
                        'controller' => 'MultiUsers',
                        'action' => 'index',
                        'successMessage' => 'Die Einladung wurde erfolgreich ein weiteres Mal an die E-Mail-Adresse ' . $userToResend->getEmail() . ' gesendet.'
                    ]);
                    return;
                } catch(\Exception $ex) {
                    die($ex->getMessage()); 
                } 
            }
        }

        $this->redirect([
            'controller' => 'error',
            'action' => 'index',
        ]);
        return;
    }
    
    //log info
    public function logsAction () {
        if (!$this->Request()->isPost()){
            $this->redirect([
                'controller' => 'error',
                'action' => 'index',
            ]);
            return;
        }

        $params = $this->clearParams($this->Request()->getParams());
        
        if ($this->account) {
            //get All users list for this account ($this->userId = this account admin user id)
            $users = $this->userService->findAllByAccountId($this->account->getId());
            foreach ($users as $user) {                
                if ($user->getId() == $params['multiuser_id'] && $user->getEmail() == $params['multiuser_email']) {
                    $userForLog = $user;
                    break;
                }                
            }

            if (is_object($userForLog)) {
                $logs = $this->userService->getLogs($userForLog);
                
                //status history
                $processedStatusHistory = [];
                foreach ($logs['statusHistory'] as $statusHistoryItem) {
                    $previousStatusId = $statusHistoryItem->getPreviousStatusId();
                    $currentStatusId = $statusHistoryItem->getCurrentStatusId();

                    $previousStatusName = null;
                    $currentStatusName = null;

                    foreach ($this->statuses as $status) {
                        if ($status['id'] === $previousStatusId) {
                            $previousStatusName = $status['name'];
                        }
                        if ($status['id'] === $currentStatusId) {
                            $currentStatusName = $status['name'];
                        }
                    }

                    $processedStatusHistory[] = [
                        'date' => $statusHistoryItem->getChangedAt()->format('Y-m-d H:i:s'),
                        'previous' => $previousStatusName,
                        'current' => $currentStatusName,
                        'changedBy' => $statusHistoryItem->getChangedby(),
                        'comment' => $statusHistoryItem->getDetails(),
                    ];
                }
                
                //role history
                $processedRoleHistory = [];
                foreach ($logs['roleHistory'] as $roleHistoryItem) {
                    $previousRoleId = $roleHistoryItem->getPreviousRoleId();
                    $currentRoleId = $roleHistoryItem->getCurrentRoleId();

                    $previousRoleName = null;
                    $currentRoleName = null;

                    foreach ($this->roles_sys as $role) {
                        if ($role['id'] === $previousRoleId) {
                            $previousRoleName = $role['name'];
                        }
                        if ($role['id'] === $currentRoleId) {
                            $currentRoleName = $role['name'];
                        }
                    }

                    $processedRoleHistory[] = [
                        'date' => $roleHistoryItem->getChangedAt()->format('Y-m-d H:i:s'),
                        'previous' => $previousRoleName,
                        'current' => $currentRoleName,
                        'comment' => $roleHistoryItem->getDetails(),
                    ];
                }

                //logs history
                $processedLogHistory = [];
                foreach ($logs['logHistory'] as $logItem) {
                    $processedLogHistory[] = [
                        'date'    => $logItem->getTimestamp()->format('Y-m-d H:i:s'),
                        'action'  => $logItem->getAction(),
                        'details' => $logItem->getDetails(),
                    ];
                }

                $this->View()->assign('statusHistory', $processedStatusHistory);
                $this->View()->assign('roleHistory', $processedRoleHistory);
                $this->View()->assign('logHistory', $processedLogHistory);
                $this->View()->assign('email', $params['multiuser_email']);
                return;
            }            
        }
        $this->redirect([
            'controller' => 'error',
            'action' => 'index',
        ]);
        return;
    }

    //returns account all users by admin id
    private function getUsersArray($accountId) {

        $users = $this->userService->findAllByAccountId($accountId);

        if (!$users) {
            return null;
        }

        $userArray = User::manyToArray($users);

        foreach ($userArray as &$user) {
            // //get user emaail
            // $user['email'] = $this->db->fetchOne('SELECT `email` FROM `s_user` WHERE `id` = :id', ['id' => $user['userId']]);
            //get user status name
            foreach ($this->statuses as $statusKey => $status) {            
                if ((int)$status['id'] === (int)$user['statusId']) {
                    $user['status'] = $status['name'];
                    $user['status_sys_name'] = $statusKey;
                    break;
                }
            }
            
            foreach ($this->roles as $role) {
                if ((int)$role['id'] === (int)$user['roleId']) {
                    $user['role'] = $role['name'];
                    break;
                }
            }            
        }

        return $userArray;
    }

    private function checkMultiuserShow () {
        $isCompanyAndActive = $this->db->fetchOne(
                'SELECT sa.company AS company
                FROM s_user_addresses sa
                JOIN s_user su ON sa.user_id = su.id
                WHERE sa.user_id = :userId
                AND su.active = 1',
                ['userId' => $this->userId]
            );  

        if (!$isCompanyAndActive) {
            return false;
        }

        //if admin or not
        $account = $this->account;

        if ($account) {            
            //update company name if it changed
            if ($account->getCompanyName() != $isCompanyAndActive) {
                $account->setCompanyName($isCompanyAndActive);
                $this->accountService->update($account);
            }
            return $account;
        }

        $user = $this->db->fetchRow("SELECT * FROM `multiuser_users` WHERE `user_id` = $this->userId");
        if (!$user) {
            return true;
        }

        return false;
    }

    private function createMasterAccount($company) {
        
        $account = new Account();
        $account->setCompanyName($company);
        $account->setMasterUserId($this->userId);

        $this->accountService->create($account);
        return $account;
    }

    private function createUserReccord($email,$accountId,$roleId, $token) {        
        $user = new User();
        $user->setAccountId($accountId);
        $user->setEmail($email);       
        $user->setRoleId($roleId);
        $user->setStatusId($this->statuses['pending']['id']);
        $user->setToken($token);

        $this->userService->create($user);
        return $user->getId();
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