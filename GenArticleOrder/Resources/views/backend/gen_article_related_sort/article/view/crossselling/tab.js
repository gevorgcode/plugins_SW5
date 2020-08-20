/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 *
 * @category   Shopware
 * @package    Article
 * @subpackage Esd
 * @version    $Id$
 * @author shopware AG
 */

/**
 * Shopware UI - Article crosselling page
 */
//{namespace name=backend/article/view/main}
//{block name="backend/article/view/crossselling/tab" append}
Ext.define('Gen.apps.Article.view.crossselling.Tab', {

    /**
     * Extend from the standard ExtJS 4
     * @string
     */
    override: 'Shopware.apps.Article.view.crossselling.Tab',
    
    /**
     * Creates the similar products fieldset.
     *
     * @returns { Shopware.apps.Article.view.crossselling.Base }
     */
    createSimilarFieldset: function() {
        var me = this;
    
        return Ext.create('Shopware.apps.Article.view.crossselling.Base', {
            snippets: me.snippets.similar,
            listingName: 'similar-listing',
            gridStore: me.article.getSimilar(),
            articleId: me.article.data.id,
            id:'similarsellingId',
            customEvents: {
                addEvent: 'addSimilarArticle',
                removeEvent: 'removeSimilarArticle'
            }
        });
    },

    /**
     * Creates the accessory products fieldset.
     *
     * @returns { Shopware.apps.Article.view.crossselling.Base }
     */
    createAccessoryFieldset: function() {
		var me = this;
		
		me.callOverridden(arguments);
		
		if(Ext.ClassManager.isCreated('Shopware.apps.Article.AccessoriesGroups.store.List')){
			return Ext.create('Ext.form.Panel', {
	            layout: 'anchor',
				border: false,
				defaults:{
	                labelWidth: 120,
	                anchor: '100%'
	            },
				items: [
					me.createAccessoryFieldset2(),
					me.createAccessoriesGroupsFieldset()
				]
			});
		}
		else{
			return Ext.create('Ext.form.Panel', {
	            layout: 'anchor',
				border: false,
				defaults:{
	                labelWidth: 120,
	                anchor: '100%'
	            },
				items: [
					me.createAccessoryFieldset2()
				]
			});
		}
	},
   
	 /**
     * Creates the accessory products fieldset for compatibiltiy with plugin accessoires groups from Coolbax .
     *
     */
	createAccessoryFieldset2: function() {
        var me = this;

        return Ext.create('Shopware.apps.Article.view.crossselling.Base', {
        	snippets: me.snippets.accessory,
            listingName: 'accessory-listing',
            gridStore: me.article.getAccessory(),
            articleId: me.article.data.id,
            id:'crosssellingId',
            customEvents: {
                addEvent: 'addAccessoryArticle',
                removeEvent: 'removeAccessoryArticle'
            }
        });
    },
	
    /**
     * Creates the accessory group fieldset for compatibiltiy with plugin accessoires groups from Coolbax .
     *
     */
	createAccessoriesGroupsFieldset: function()
	{
		var me = this;
		
		me.groupStore = Ext.create('Shopware.apps.Article.AccessoriesGroups.store.List');
        me.groupStore.getProxy().extraParams.articleId = me.article.get('id');
		me.groupStore.load();

		return Ext.create('Shopware.apps.Article.AccessoriesGroups.view.AccessoriesGroupsTab', {
			groupStore: me.groupStore,
			article: me.article
		});
	}
});
//{/block}
