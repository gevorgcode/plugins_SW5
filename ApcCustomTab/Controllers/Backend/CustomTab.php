<?php

use ApcCustomTab\Models\TabModel\TabModel;

class Shopware_Controllers_Backend_CustomTab extends Shopware_Controllers_Backend_ExtJs
{
    protected $modelManager;
    protected $alias = 'tabModel';
    protected $tabModel = TabModel::class;
    
    

    // set new tab in detail page for same article
    public function setTabAction()
    {

        $request = $this->Request()->getParams();

        if($request['action'] === 'setTab'){
            $articleId = $request['articleId'];
            $tabName = $request['tabName'];
            $tabContent = $request['tabContent'];
        }
         
        $this->modelManager = Shopware()->Container()->get('models');
        $tabModel =  new $this->tabModel;
        
        if($articleId) {
            $tabModel->setArticleId($articleId);
            $tabModel->setName($tabName);
            $tabModel->setContent($tabContent);
            
            Shopware()->Models()->persist($tabModel);
            Shopware()->Models()->flush();
            $tab = $tabModel->getTab();
                
            $this->View()->assign(
                [
                    'success' => true,
                    'data' => $tab,
                ]
            );
        }
        else{
            $this->View()->assign(
                [
                    'success' => false,
                ]
            );
        } 
        
    }

    public function listAction()
    {        
        $articleId = $this->Request()->getParam('articleId');
        if(!$articleId){
            return;
        }
        $tabModel = new $this->tabModel;
        $tabs = $tabModel->getTabsByArticle($articleId);
        $this->View()->assign(
            [
                'success' => true,
                'data' => $tabs,
                'total' => 1
            ]
        );
    }
    public function deleteTabAction()
    {        
        $id = $this->Request()->getParam('id');
        if(!id){
            return;
        }

        $tabModel =  new $this->tabModel;

        
        $success = $tabModel->destroyTab($id);
        if ($success){
            $this->View()->assign(
                [
                    'success' => true,
                ]
            );
        }
        else{
            $this->View()->assign(
                [
                    'success' => false,
                ]
            );
        }         
    }
 
    
}
?>
