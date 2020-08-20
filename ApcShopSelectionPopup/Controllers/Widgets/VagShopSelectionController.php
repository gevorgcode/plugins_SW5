<?php

class Shopware_Controllers_Widgets_VagShopSelectionController extends Enlight_Controller_Action {

   public function indexAction(){
        $view = $this->View();
       
        $shop = Shopware()->Container()->get('shop');
        $languages = $shop->getChildren()->toArray();
        $main = $shop->getMain() !== null ? $shop->getMain() : $shop;
        Shopware()->Models()->detach($main);
       
        foreach ($languages as $languageKey => &$language) {
            Shopware()->Models()->detach($language);
            if (!$language->getActive()) {
                unset($languageKey);
            }
        }
       
        array_unshift($languages, $main);
        $view->assign('languages', $languages);
        $view->assign('vagShop', $shop);
        $flags = $this->getFlags($languages);
        $view->assign('flags', $flags);
        $shop = Shopware()->Container()->get('shop');
        
        $languages = $shop->getChildren()->toArray();

        $main = $shop->getMain() !== null ? $shop->getMain() : $shop;
        Shopware()->Models()->detach($main);
        foreach ($languages as $languageKey => $language) {
            Shopware()->Models()->detach($language);
            if (!$language->getActive()) {
                unset($languages[$languageKey]);
            }
        }
        
        array_unshift($languages, $main);
        $this->View()->languages = $languages;
   }
    
    
    private function getFlags($languages){
        $ids = array(); 
        $locales = array(); 
        
        foreach($languages as $language){
            $ids[] = $language->getId();
        }
        
        $sql = "SELECT `locale_id` FROM `s_core_shops` WHERE `s_core_shops`.`id` IN (" . str_repeat("?,", count($ids) - 1) . "?);";
        $locales = Shopware()->Db()->fetchCol($sql, $ids);
        
        $sqlFlags = "SELECT `s_core_locales`.`locale`, `s_core_locales`.`language`
                     FROM `s_core_locales`
                     WHERE `s_core_locales`.`id` IN (" . str_repeat("?,", count($locales) - 1) . "?);";
        
        $flags = Shopware()->Db()->fetchAll($sqlFlags, $locales);
        
        return $flags;
    }
    

}

?>