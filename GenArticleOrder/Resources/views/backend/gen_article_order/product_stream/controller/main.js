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
 * @subpackage Controller
 * @version    $Id$
 * @author shopware AG
 */
//{namespace name=backend/product_stream/main}
//{block name="backend/product_stream/controller/main" append}
Ext.define('Gen.apps.ProductStream.controller.Main', {
    override: 'Shopware.apps.ProductStream.controller.Main',

    init: function() {
        var me = this;

        me.control({
            'product-stream-selected-list-window': {
                'save-selection-stream': me.saveSelectionStream
            },
            'product-stream-condition-panel': {
                'load-preview': me.loadPreview
            },
            'product-stream-preview-grid gridview': {
                'drop': me.onDragAndDropAssignment
            },
            'product-stream-selected-list-grid gridview': {
                'drop': me.onDragAndDropAssignmentSelectedGrid
            },
            'product-stream-detail-window': {
                'save-condition-stream': me.saveConditionStream
            },
            'product-stream-listing-grid': {
                'open-selected-list-window': me.openSelectedListWindow,
                'stream-delete-item': me.onDeleteItem,
                'stream-duplicate-item': me.onDuplicateItem
            }
        });

        me.mainWindow = me.getView('list.Window').create({ }).show();
    },
    
    loadPreview: function(conditions) {
        var me = this;

        var conditionPanel = me.getConditionPanel();
        var previewGrid = me.getPreviewGrid();
        var shopCombo = me.getShopCombo();
        var currencyCombo = me.getCurrencyCombo();
        var customerGroupCombo = me.getCustomerGroupCombo();
        var settingsPanel = me.getFormPanel();
        var record = settingsPanel.getForm().getRecord();

        if (!conditions || Object.getOwnPropertyNames(conditions).length === 0) {
            if (!conditionPanel.validateConditions()) {
                return;
            }
            conditions = me.getConditions();
        }

        var sort = me.getSorting();

        previewGrid.getStore().getProxy().extraParams = {
            sort: sort,
            streamId : record.get('id'),
            conditions: Ext.JSON.encode(conditions),
            shopId: shopCombo.getValue(),
            currencyId: currencyCombo.getValue(),
            customerGroupKey: customerGroupCombo.getValue()
        };

        previewGrid.getStore().load();
    },

    /**
     * Event listener method which will be fired when the user drags
     * records from one grid to the other one.
     *
     * The method collects the id's of the dropped records.
     *
     * @param { HTMLElement } node
     * @param { Object } data
     * @returns { Void }
     */
    onDragAndDropAssignment: function(node, data) {
        var me = this,
            previewGrid = me.getPreviewGrid(),
            store = previewGrid.store,
            settingsPanel = me.getFormPanel(),
            record = settingsPanel.getForm().getRecord();

        if(record.get('id') == null){
        	Shopware.Notification.createGrowlMessage('{s name="save_title"}Stream speichern{/s}','{s name="save_message"}Bitte erst Stream speichern!{/s}');
        	return;
        }
        Ext.Ajax.request({
        	url:'{url controller=GenArticleOrder action="saveProductStreamPositions"}',
        	params:{
        		streamId : record.get('id'),
        		articles : Ext.encode(Ext.pluck(store.data.items, 'data'))
        	},
        	success: function(res) {
        		Shopware.Notification.createGrowlMessage('{s name="saved_title"}Sortierung gespeichert{/s}','{s name="saved_message"}manuelle Sortierung gespeichert{/s}');
        	}
        })
    },
    
    /**
     * Event listener method which will be fired when the user drags
     * records from one grid to the other one.
     *
     * The method collects the id's of the dropped records.
     *
     * @param { HTMLElement } node
     * @param { Object } data
     * @returns { Void }
     */
    onDragAndDropAssignmentSelectedGrid: function(node, data) {
        var  me = this,
            detailGrid = me.getProductStreamDetailGrid(),
            store = detailGrid.store;

        if(detailGrid.streamId == null){
        	Shopware.Notification.createGrowlMessage('{s name="save_title"}Stream speichern{/s}','{s name="save_message"}Bitte erst Stream speichern!{/s}');
        	return;
        }
        Ext.Ajax.request({
        	url:'{url controller=GenArticleOrder action="saveProductStreamPositions"}',
        	params:{
        		streamId : detailGrid.streamId,
        		articles : Ext.encode(Ext.pluck(store.data.items, 'data'))
        	},
        	success: function(res) {
        		Shopware.Notification.createGrowlMessage('{s name="saved_title"}Sortierung gespeichert{/s}','{s name="saved_message"}manuelle Sortierung gespeichert{/s}');
        	}
        })
    }
});
//{/block}