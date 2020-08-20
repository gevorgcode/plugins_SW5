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
//{block name="backend/article/view/crossseling/base" append}
Ext.define('Gen.apps.Article.view.crossselling.Base', {

    /**
     * override Shopware.apps.Article.view.crossselling.Base
     * @string 
     */
    override: 'Shopware.apps.Article.view.crossselling.Base',

    /**
     * Creates the grid panel which displays the provided data of the component.
     *
     * @returns { Ext.grid.Panel }
     */
    createGridPanel: function() {
        var me = this, viewConfig = {};
        	
        //'accessory-listing' -> me.listingName
        
        return me.productGrid = Ext.create('Ext.grid.Panel', {
            title: me.systemTexts.gridTitle,
            cls: Ext.baseCSSPrefix + 'free-standing-grid',
            store: me.gridStore,
            name: me.listingName,
            height: 180,
            columnWidth: 0.65,
            viewConfig: {
            	loadMask: false, plugins: me.createGridDragAndDrop()
            },
            columns: [
                {
                    header: me.systemTexts.productSearch,
                    dataIndex: 'number',
                    width: 120
                }, {
                    header: me.systemTexts.name,
                    dataIndex: 'name',
                    flex: 1
                }, {
                    xtype: 'actioncolumn',
                    width: 30,
                    items: [
                        {
                            iconCls: 'sprite-minus-circle-frame',
                            tooltip: me.systemTexts.delete,
                            handler: function (view, rowIndex, colIndex, item, opts, record) {
                                me.fireEvent(me.customEvents.removeEvent, view, record);
                            }
                        }
                    ]
                }
            ]
        });
    },
    
    createGridDragAndDrop: function() {
    	var me = this;
   
    	if(me.listingName=='accessory-listing' || me.listingName=='similar-listing'){
	        return Ext.create('Ext.grid.plugin.DragDrop', {
	            ddGroup: 'article-accessory-assignment-grid-dd'
	        });
    	}
    	else{ 
    		return false;
    	}
    }
});
//{/block}