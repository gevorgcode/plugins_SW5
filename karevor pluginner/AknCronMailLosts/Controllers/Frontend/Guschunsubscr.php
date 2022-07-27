<?php

/**
 * Class Shopware_Controllers_Frontend_Guschunsubscr
 */
class Shopware_Controllers_Frontend_Guschunsubscr extends Enlight_Controller_Action{

    protected $db;

    /**
     * Init controller method
     */
    public function init(){         
        
        $this->db = Shopware()->Db();

        $this->View()->assign('SeoMetaRobots', 'noindex,nofollow');         
    }
        
    public function indexAction(){      
        $params = $this->clearParams($this->Request()->getParams());
        
        if ($params['tp'] == 'l'){
            $this->db->query(
                'UPDATE s_user_attributes
                SET s_user_attributes.unsubscribe_lost_mail = 1
                WHERE s_user_attributes.userID = :userID',
                ['userID' => $params['ci']]           
            ); 
        }elseif ($params['tp'] == 'b'){
            $this->db->query(
                'UPDATE s_user_attributes
                SET s_user_attributes.unsubscribe_birthday_mail = 1
                WHERE s_user_attributes.userID = :userID',
                ['userID' => $params['ci']]           
            ); 
        }

        $this->redirect(
            [
                'controller' => 'Guschunsubscr',
                'action' => 'unsubscribe'
            ]
        );
    }     

    public function unsubscribeAction(){
        
        //tpl
    }

    //private functions    
    private function clearParams($params = []) {
        foreach($params as &$param) {
            $param = htmlspecialchars(stripslashes(trim($param)));
        }
        
        return $params;
    }     
}