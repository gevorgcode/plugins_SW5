<?php
/**
 * Plugin-Backend-Controller for article order
 * @package GenArticleOrder
 * @subpackage Controller
 * @author Mathias Bauer <info@gen.de>
 */
class Shopware_Controllers_Backend_GenArticleOrder extends Shopware_Controllers_Backend_ExtJs {
	/**
	 * save manual article order of one category
	 */
	public function savePositionsAction() {
		$categoryId = $this->Request ()->getParam ( 'categoryId' );
		$droppedArticleID = $this->Request ()->getParam ( 'droppedArticleID' );
		$articles = json_decode ( $this->Request ()->getParam ( 'articles' ) );
		$articles = ( array ) $articles;
		$counter = 0;
		$amount = count($articles);
		$configReader = $this->container->get('shopware.plugin.config_reader');
		$config = $configReader->getByPluginName('GenArticleOrder');
		
		if(empty($articles)){
			// delete last article from s_articles_categories_ro and s_articles_categories
			$sql = "DELETE FROM s_articles_categories WHERE categoryID=?";
			Shopware ()->Db ()->query ( $sql, array (
			$categoryId
			) );
			
			$sql = "DELETE FROM s_articles_categories_ro WHERE categoryID=?";
			Shopware ()->Db ()->query ( $sql, array (
			$categoryId
			) );
		}
		else{
			$sql="DELETE FROM gen_articles_categories WHERE categoryID = ?";
			Shopware()->Db()->query($sql,array($categoryId));
	
			// insert
			$sql = "INSERT IGNORE INTO gen_articles_categories (articleID,categoryID,`order`,dropped) VALUES ";
			foreach ( $articles as $article ) {
				$sql.="(".$article->articleId.",".$categoryId.",".$counter.",".$article->dropped;
				if($counter<$amount-1){
					$sql.="),";
				}
				else{
					$sql.=");";
				}
				$counter ++;
			}
			Shopware ()->Db ()->query ( $sql);
			
			$counter=0;
			$sql="DELETE FROM s_articles_categories WHERE categoryID = ? AND articleID NOT IN (";
			foreach ( $articles as $article ) {
				$sql.=$article->articleId;
				if($counter<$amount-1){
					$sql.=",";
				}
				else{
					$sql.=");";
				}
				$counter ++;
			}
			Shopware ()->Db ()->query ( $sql, array (
				$categoryId
			) );
			
			$counter=0;
			$sql="DELETE FROM s_articles_categories_ro WHERE categoryID = ? AND articleID NOT IN (";
			foreach ( $articles as $article ) {
				$sql.=$article->articleId;
				if($counter<$amount-1){
					$sql.=",";
				}
				else{
					$sql.=");";
				}
				$counter ++;
			}
			Shopware ()->Db ()->query ( $sql, array (
			$categoryId
			) );
			
			$sql = "UPDATE gen_articles_categories SET dropped = 1 WHERE categoryID = ? AND articleID = ?";
			Shopware ()->Db ()->query ( $sql, array (
				$categoryId,
				$droppedArticleID
			) );
		}

		$this->View ()->assign ( array (
				'success' => true,
				'coloredArticles' => $config['genHideColoredArticles']
		) );
	}

	/**
	 * reset manual article order of one category
	 */
	public function resetCategoryAction() {
		$categoryId = $this->Request ()->getParam ( 'categoryId' );
		if (isset ( $categoryId )) {
			$sql = "DELETE FROM gen_articles_categories WHERE categoryID = ?";
			Shopware ()->Db ()->query ( $sql, array (
					$categoryId
			) );
		}
		$this->View ()->assign ( array (
				'success' => true
		) );
	}
	
	public function saveProductStreamPositionsAction() {
		$streamId = $this->Request ()->getParam ( 'streamId' );
		$articles = json_decode ( $this->Request ()->getParam ( 'articles' ) );
		$articles = ( array ) $articles;
		$counter = 0;
		$amount = count($articles);
		
		if(!empty($articles)){
			$sql="DELETE FROM gen_product_streams_sort WHERE streamID = ?";
			Shopware()->Db()->query($sql,array($streamId));
		
			// insert
			$sql = "INSERT IGNORE INTO gen_product_streams_sort (articleID,streamID,`order`) VALUES ";
			foreach ( $articles as $article ) {
				$sql.="(".$article->id.",".$streamId.",".$counter;
				if($counter<$amount-1){
					$sql.="),";
				}
				else{
					$sql.=");";
				}
				$counter ++;
			}
			Shopware ()->Db ()->query ( $sql);
		}
		
		$this->View ()->assign ( array (
				'success' => true
		) );
	}
}
?>