<?php
/**
 * Plugin-Backend-Controller for article related 
 * @package GenArticleRelatedSort
 * @subpackage Controller
 * @author Mathias Bauer <info@gen.de>
 */
class Shopware_Controllers_Backend_GenArticleRelatedSort extends Shopware_Controllers_Backend_ExtJs {
	/**
	 * save manual article order of one category
	 */
	public function saveCrosssellingPositionsAction() {
		$articleId = $this->Request ()->getParam ( 'articleId' );
		$articles = json_decode ( $this->Request ()->getParam ( 'articles' ) );
		$articles = ( array ) $articles;
		$counter = 0;
		$amount = count ( $articles );
		
		if(!empty($articleId)){
			$sql = "DELETE FROM gen_articles_related_sort WHERE articleID = ?";
			Shopware ()->Db ()->query ( $sql, array (
					$articleId 
			) );
			
			// insert
			$sql = "INSERT IGNORE INTO gen_articles_related_sort (relatedarticle,articleID,`sort`) VALUES ";
			foreach ( $articles as $article ) {
				$sql .= "(" . $article->id . "," . $articleId . "," . $counter;
				if ($counter < $amount - 1) {
					$sql .= "),";
				} else {
					$sql .= ");";
				}
				$counter ++;
			}
			
			Shopware ()->Db ()->query ( $sql );
		}
		
		$this->View ()->assign ( array (
				'success' => true 
		) );
	}
	
	/**
	 * save manual article order of one category
	 */
	public function saveSimilarPositionsAction() {
		$articleId = $this->Request ()->getParam ( 'articleId' );
		$articles = json_decode ( $this->Request ()->getParam ( 'articles' ) );
		$articles = ( array ) $articles;
		$counter = 0;
		$amount = count ( $articles );
		
		if(!empty($articleId)){
			$sql = "DELETE FROM gen_articles_similar_sort WHERE articleID = ?";
			Shopware ()->Db ()->query ( $sql, array (
			$articleId
			) );
			
			// insert
			$sql = "INSERT IGNORE INTO gen_articles_similar_sort (relatedarticle,articleID,`sort`) VALUES ";
			foreach ( $articles as $article ) {
				$sql .= "(" . $article->id . "," . $articleId . "," . $counter;
				if ($counter < $amount - 1) {
					$sql .= "),";
				} else {
					$sql .= ");";
				}
				$counter ++;
			}
			
			Shopware ()->Db ()->query ( $sql );
		}
		
		$this->View ()->assign ( array (
				'success' => true
		) );
	}
}
?>