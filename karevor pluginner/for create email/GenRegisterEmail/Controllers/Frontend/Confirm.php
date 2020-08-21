<?php

class Shopware_Controllers_Frontend_Confirm extends Enlight_Controller_Action
{
    public function indexAction()
    {
   		$hash = $this->Request()->getParam('hash');
   		
   		$sql = "SELECT `data` FROM `s_core_optin` WHERE `hash`= ? ";
   		$info = Shopware()->Db()->fetchOne($sql, $hash);

   		$sql = "SELECT `tur` FROM `s_user_attributes` WHERE `userID` = ? ";
   		$tur =  Shopware()->Db()->fetchOne($sql, [$info]);
 
        if($tur != 0){
            $sql = "UPDATE `s_user_attributes` SET `tur` = 0 WHERE `userID` = ?";
            Shopware()->Db()->query($sql, $info); 
            return $this->redirect(['controller' => 'account']);
        }
    }
   
}

?>

