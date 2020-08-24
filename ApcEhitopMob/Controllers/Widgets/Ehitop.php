<?php

/**
 * Shopware_Controllers_Widgets_Ehitop
 */

class Shopware_Controllers_Widgets_Ehitop extends Enlight_Controller_Action{    

    public function indexAction(){
        $request = $this->Request();
        $response = $this->Response();
        $view = $this->View();

        $EhiTopHidden = false;              
        $ehiAjaxparam = $request->getParam('EhiTopCookie');
        if ($ehiAjaxparam && $ehiAjaxparam == 'Yes'){
            $response->setCookie( 'ehi_top_closed', $ehiAjaxparam, time()+86400, '/' );
        }
        
        $ehiCookie = $request->getCookie('ehi_top_closed');
        if ($ehiCookie){
            $EhiTopHidden = true;
        }
        
        $view->assign('EhiTopHidden', $EhiTopHidden);

    }
}