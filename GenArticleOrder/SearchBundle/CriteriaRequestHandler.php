<?php
namespace GenArticleOrder\SearchBundle;

use Enlight_Controller_Request_RequestHttp as Request;
use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\CriteriaRequestHandlerInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use GenArticleOrder\SearchBundle\ManualArticleSorting;

class CriteriaRequestHandler implements CriteriaRequestHandlerInterface
{
    /**
     * @inheritdoc
     */
    public function handleRequest(
        Request $request,
        Criteria $criteria,
        ShopContextInterface $context
    ) {
    	$baseSorting = Shopware ()->Config ()->get ( 'defaultListingSorting' );
    	if($this->assertMinimumVersion('5.3')){
    		$exist = $this->existBaseSorting($baseSorting);
    		if(!$exist){
    			unset($baseSorting);
    		}
    	}
    	$manufacturerId = $request->getParam('sSupplier', null);
    	if(empty($baseSorting) && empty($manufacturerId)){
   			$criteria->addSorting(new ManualArticleSorting());
    	}
    }
    
    /**
     *
     * @param unknown $baseSorting
     * @return boolean
     */
    public function existBaseSorting($baseSorting){
    	if(!empty($baseSorting)){
    		$sql = "SELECT id FROM s_search_custom_sorting WHERE id = ? AND active = 1";
    		$id = Shopware()->Db()->fetchOne($sql,array($baseSorting));
    		if(!empty($id)){
    			return true;
    		}
    	}
    	return false;
    }
    
    /**
     * Check if a given version is greater or equal to
     * the currently installed shopware version.
     *
     * Attention: If your target shopware version may
     * include a version less than 4.1.3 you have to
     * use assertVersionGreaterThen().
     *
     * @since 4.1.3 introduced assertMinimumVersion($requiredVersion)
     * @param  string $requiredVersion string Format: 3.5.4 or 3.5.4.21111
     * @return bool
     */
    protected function assertMinimumVersion($requiredVersion)
    {
    	$version = Shopware()->Application()->Config()->version;
    	if ($version === '___VERSION___') {
    		return true;
    	}
    	return version_compare($version, $requiredVersion, '>=');
    }
}
