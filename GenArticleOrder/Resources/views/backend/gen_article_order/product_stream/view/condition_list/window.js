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
//{block name="backend/product_stream/view/condition_list/window" append}
Ext.define('Gen.apps.ProductStream.view.condition_list.Window', {
    override: 'Shopware.apps.ProductStream.view.condition_list.Window',

    createItems: function() {
        var me = this, container;

        me.previewGrid = Ext.create('Shopware.apps.ProductStream.view.condition_list.PreviewGrid', {
            flex: 1,
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
        me.conditionPanel = Ext.create('Shopware.apps.ProductStream.view.condition_list.ConditionPanel', {
            flex: 1,
            margin: '0 10 0 0'
        });

        container = Ext.create('Ext.container.Container', {
            layout: { type: 'vbox', align: 'stretch'},
            flex: 1,
            padding: 10,
            title: '{s name="configuration_title"}{/s}',
            items: [
                me.createSettingPanel(),
                {
                    xtype: 'container',
                    flex: 1,
                    margin: '10 0 0',
                    layout: { type: 'hbox', align: 'stretch' },
                    items: [
                        me.conditionPanel,
                        me.previewGrid
                    ]
                }
            ]
        });

        me.tabPanel = Ext.create('Ext.tab.Panel', {
            flex: 1,
            items: [container]
        });

        me.formPanel = Ext.create('Ext.form.Panel', {
            layout: 'fit',
            items: [me.tabPanel],
            name: 'product-stream-main-form',
            border: false,
            plugins: [{
                ptype: 'translation',
                translationType: 'productStream'
            }]
        });

        me.attributeForm = Ext.create('Shopware.apps.ProductStream.view.common.Attributes', {
            tabPanel: me.tabPanel,
            translationForm: me.formPanel
        });
        me.tabPanel.add(me.attributeForm);

        return [me.formPanel];
    },
    
    createGridDragAndDrop: function() {
        return Ext.create('Ext.grid.plugin.DragDrop', {
            ddGroup: 'product-stream-assignment-grid-dd'
        });
    }
});
//{/block}