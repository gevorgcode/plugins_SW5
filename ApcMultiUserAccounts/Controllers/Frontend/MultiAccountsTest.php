<?php

use ApcMultiUserAccounts\Models\Account;
use ApcMultiUserAccounts\Services\AccountService;
use ApcMultiUserAccounts\Services\UserService;

/**
 * Shopware_Controllers_Frontend_MultiAccountsTest
 */

class Shopware_Controllers_Frontend_MultiAccountsTest extends Enlight_Controller_Action{   

    /**
     * Init controller method
     */
    public function init(){       
        // $this->View()->assign('SeoMetaRobots', 'noindex,nofollow');    
    }

    ////ACCOUNT////
    //create account
    public function indexAction()
    {
        /** @var AccountService $accountService */
        $accountService = $this->container->get('apc_multiuser_account_service');
        
        $customerId = 32060;        

        $account = new \ApcMultiUserAccounts\Models\Account();
        $account->setCompanyName('MyCompany');
        $account->setMasterUserId($customerId);

        $accountService->create($account);
    }

    // get account, update account
    public function getAccountAction () {
        /** @var \ApcMultiUserAccounts\Services\AccountService $accountService */
        $accountService = $this->container->get('apc_multiuser_account_service');        

        $account = $accountService->find(1);
        if ($account) {
            $account->setCompanyName('MyCompany');
            $account->setActive(true);
            $accountService->update($account);
        }

        var_dump(12131); exit;
    }

    ///USER////
    public function createUserAction () {
        /** @var \ApcMultiUserAccounts\Services\UserService $userService */
        $userService = $this->container->get('apc_multiuser_user_service');

        $customerId = 32061;

        $accountId = 3;
        $roleId = 2; //Buyer
        $statusId = 4; //pending
        

        $user = new \ApcMultiUserAccounts\Models\User();
        $user->setAccountId($accountId);
        $user->setUserId($customerId);       
        $user->setRoleId($roleId);
        $user->setStatusId($statusId);

        $userService->create($user);

        var_dump('user created'); exit;
    }

    public function getUserAction () {
        /** @var \ApcMultiUserAccounts\Services\UserService $userService */
        $userService = $this->container->get('apc_multiuser_user_service');
        // $user = $userService->findAll();
        $user = $userService->find(1);
        if ($user){
            $user->setRoleId(3);
            $user->setStatusId(3);
            $userService->update($user);
            var_dump('user updateed'); exit;
        }
        
    }

}