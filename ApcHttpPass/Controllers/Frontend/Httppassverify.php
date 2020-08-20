<?php

/**
 * Class Shopware_Controllers_Frontend_Httppassverify
 */
class Shopware_Controllers_Frontend_Httppassverify extends Enlight_Controller_Action{
    
    public function indexAction(){
        
    }
    
    public function veryAction(){
        if (!$this->Request()->isPost()){
            return;
        }
        $httpPass = $this->Request()->getparam('http_pass');
        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('ApcHttpPass');
        $ConfigHttpPass = $config['http_pass'];
        if ($httpPass == $ConfigHttpPass){
            $this->Response()->setCookie( 'verify', 'ok', time()+86400, '/' );
            $this->redirect([
                'controller' => 'index',
                'action' => 'index',
            ]);
        }
    }
}