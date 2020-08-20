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
 * @package    ProductStream
 * @subpackage Window
 * @version    $Id$
 * @author shopware AG
 */
//{namespace name=backend/product_stream/main}
//{block name="backend/product_stream/view/selected_list/product" append}
Ext.define('Gen.apps.ProductStream.view.selected_list.Product', {
    override: 'Shopware.apps.ProductStream.view.selected_list.Product',
    
    createGrid: function() {
    	var me = this;
        this.grid = Ext.create('Ext.grid.Panel', {
            flex: 1,
            store: this.store,
            dockedItems: [],
            columns: this.createColumns(),
            deferRowRender:false,
            viewConfig: { 
            	loadMask: false, 
            	plugins: me.createGridDragAndDrop(),
            	getRowClass: function(record, rowIndex, rp, ds){ // rp = rowParams
                    if(record.data.dropped == 1){
                        return Ext.baseCSSPrefix + 'grid-row-dropped-article';
                    }
                    if(record.data.found == 1){
                    	return Ext.baseCSSPrefix + 'grid-row-found-article';
                    }
                }
            }
        });
        this.grid.disabled = true;
        return this.grid;
    },
    
    createGridDragAndDrop: function() {
        return Ext.create('Ext.grid.plugin.DragDrop', {
            ddGroup: 'product-stream-assignment-grid-dd'
        });
    }
});
//{/block}