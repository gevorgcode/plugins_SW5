<?php

/**
 * Class Shopware_Controllers_Frontend_Spec
 */
class Shopware_Controllers_Frontend_Spec extends Enlight_Controller_Action
{
    /**
     * @throws Exception
     */
    public function indexAction(){
        $urlArticledetailsID = $this->Request()->getparam('sDetailsId');
        $urlPrice = $this->Request()->getparam('curPr');
        $urlToken = $this->Request()->getparam('token');
        
        //spec row for this article
        $sql = 'SELECT `spec_price`, `spec_price_link`, `spec_price_link_active` FROM `s_articles_attributes` WHERE `articledetailsID` = ?';
        $spec = Shopware()->Db()->fetchRow($sql, [$urlArticledetailsID]);        
        
        //spec price link active from DB for this article        
        $specPriceLinkActive = $spec['spec_price_link_active'];
        
        if ($specPriceLinkActive != 1){
            $this->redirect([
                'action' => 'error',                
            ]);
        }
                
        //spec price from DB for this article        
        $specPrice = $spec['spec_price'];
        
        $specPrice = abs(floatval($specPrice));
        $urlPrice = abs(floatval($urlPrice));
        
        if (($specPrice <= 0) || ($specPrice != $urlPrice)){
            $this->redirect([
                'action' => 'error',                
            ]);
        }
        
        //spec price link from DB for this article        
        $specPriceLink = $spec['spec_price_link']; 
        $pieces = explode("&", $specPriceLink);
        $lastPiece = end($pieces);
        $token = end(explode("=", $lastPiece));
        
        if ($urlToken != $token){
            $this->redirect([
                'action' => 'error',                
            ]);
        }
        
        $sql = 'SELECT `articleID` FROM `s_articles_details` WHERE `id` = ?';
        $articleId = Shopware()->Db()->fetchOne($sql, [$urlArticledetailsID]); 
        
        if (!$articleId){
            $this->redirect([
                'action' => 'error',                
            ]);
        }
                
        //25 minutes
        $this->Response()->setCookie( 'spec_article_id', $articleId, time()+1500, '/' );
        
        $this->forward('index', 'detail', 'frontend',
                       ['sViewport' => 'detail',
                        'sArticle' => $articleId, 
                        'fromSpec' => true,
                        'spfPrice' => $specPrice,                        
                       ]);
        
                    
                     
    }
    public function errorAction(){
        $this->redirect([
            'action' => 'index',
            'controller' => 'index'
        ]);
    }
    
}





















