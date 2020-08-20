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
 * @subpackage Detail
 * @version    $Id$
 * @author shopware AG
 */

/**
 * Shopware Controller - Detail
 * The detail controller handles all events of the detail page main form element and the sidebar.
 */
//{namespace name=backend/article/view/main}
//{block name="backend/article/controller/crossselling" append}
Ext.define('Gen.apps.Article.controller.Crossselling', {

    /**
     * override Shopware.apps.Article.controller.Crossselling
     * @string
     */
    override: 'Shopware.apps.Article.controller.Crossselling',

    /**
     * A template method that is called when your application boots.
     * It is called before the Application's launch function is executed
     * so gives a hook point to run any code before your Viewport is created.
     *
     * @params  - The main controller can handle a orderId parameter to open the order detail page directly
     * @return void
     */
    init:function () {
        var me = this;
        me.control({
            'article-detail-window article-crossselling-base gridview': {
            	'drop': me.onDragAndDrop
            }
        });

        me.callParent(arguments);
    },

    /**
     * Event listener method which will be fired when the user drags
     * records.
     *
     * The method collects the id's of the dropped records.
     *
     * @param { HTMLElement } node
     * @param { Object } data
     * @returns { Void }
     */
    onDragAndDrop: function(node, data) {
        var me = this,
            activeView = data.view,
            activeGrid = activeView.panel,
            store = activeGrid.getStore(),
            records = data.records, action, categoryId, ids = [];
        
        if(activeGrid.name=="accessory-listing"){
	        Ext.Ajax.request({
	            url:'{url controller=GenArticleRelatedSort action="saveCrosssellingPositions"}',
	            params:{
	            	   articleId: Ext.getCmp('crosssellingId').articleId,
	            	   articles : Ext.encode(Ext.pluck(store.data.items, 'data'))
	            },
	            success: function(res) {
	         		  Shopware.Notification.createGrowlMessage('{s name="articlerelatedsort/title"}Artikelreihenfolge{/s}','{s name="articlerelatedsort/saved"}Die Zubehörreihenfolge wurde gespeichert!{/s}');
	        	}
	        })
        }
        if(activeGrid.name=="similar-listing"){
        	Ext.Ajax.request({
	            url:'{url controller=GenArticleRelatedSort action="saveSimilarPositions"}',
	            params:{
	            	   articleId: Ext.getCmp('similarsellingId').articleId,
	            	   articles : Ext.encode(Ext.pluck(store.data.items, 'data'))
	            },
	            success: function(res) {
	         		   Shopware.Notification.createGrowlMessage('{s name="articlerelatedsort/title"}Artikelreihenfolge{/s}','{s name="articlerelatedsimilarsort/saved"}Die Reihenfolge der ähnlichen Artikel wurde gespeichert!{/s}');
	            }
	        })
        }
    },
});
//{/block}
