/**
 * Shopware 4.0
 * Copyright © 2012 shopware AG
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
 * @package    Category
 * @subpackage Settings
 * @copyright  Copyright (c) 2012, shopware AG (http://www.shopware.de)
 * @version    $Id$
 * @author shopware AG
 */

// {namespace name=backend/category/main}

/**
 * Shopware UI - Category Article Mapping
 *
 * Shows the drag and drop selector to map articles to a category
 */
//{block name="backend/category/view/tabs/article_mapping" append}
Ext.define('Gen.apps.Category.view.category.tabs.ArticleMapping', {
	override:'Shopware.apps.Category.view.category.tabs.ArticleMapping',
	
	/**
     * Available action buttons
     * @array
     */
    defaultButtons: [ 'top', 'up', 'down', 'bottom' ],

    /**
     * Default text which are used for the tooltip on the button.
     * @object
     */
    buttonsText: {
        top: "{s name=tabs/article_mapping/button_top}Top{/s}",
        up: "{s name=tabs/article_mapping/button_up}Up{/s}",
        down: "{s name=tabs/article_mapping/button_down}Down{/s}",
        bottom: "{s name=tabs/article_mapping/button_bottom}Bottom{/s}"
    },
    
    clsName:{
    	top: "sprite-control-double-090",
    	up: "sprite-control-090",
    	down: "sprite-control-270",
    	bottom: "sprite-control-double-270"
    },

    /**
     * Initialize the Shopware.apps.Category.view.category.tabs.ArticleMapping and defines the necessary
     * default configuration
     *
     * @returns { Void }
     */
    initComponent:function () {
        var me = this;
        me.fromGrid = me.createFromGrid();
        me.buttonContainer = me.createActionButtons();
        me.toGrid = me.createToGrid();

        me.items = [ me.fromGrid, me.buttonContainer, me.toGrid ];
        me.addEvents('storeschanged', 'add', 'remove','resetSortOfCategory');
        me.on('storeschanged', me.onStoresChanged, me);
        me.callParent(arguments);
    },

    /**
     * Creates the `from` grid
     * @returns { Ext.grid.Panel }
     */
    createFromGrid: function() {
        var me = this, grid, toolbar;

        grid = Ext.create('Ext.grid.Panel', {
            internalTitle: 'from',
            title: '{s name=tabs/article_mapping/available_articles}Available Articles{/s}',
            flex: 1,
            store: me.availableProductsStore.load(),
            selModel: me.createSelectionModel(),
            viewConfig: { loadMask: false, plugins: me.createGridDragAndDrop() },
            bbar: me.createPagingToolbar(me.availableProductsStore),
            columns: me.getColumns()
        });

        toolbar = me.createSearchToolbar(grid);
        grid.addDocked(toolbar);

        return grid;
    },

    /**
     * Creates the `to` grid
     * @returns { Ext.grid.Panel }
     */
    createToGrid: function() {
        var me = this, grid, toolbar;

        grid =  Ext.create('Ext.grid.Panel', {
            internalTitle: 'to',
            title: '{s name=tabs/article_mapping/mapped_articles}Mapped Articles{/s}',
            flex: 1,
            store: me.assignedProductsStore.load(),
            selModel: me.createSelectionModel(),
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
                    if(record.data.active == 0){
                    	return Ext.baseCSSPrefix + 'grid-row-inactive-article';
                    }
                }
            },
         //   bbar: me.createPagingToolbar(me.assignedProductsStore),
            columns: me.getColumns()
        });

        toolbar = me.createGenSearchToolbar(grid);
        grid.addDocked(toolbar);

        return grid;
    },

    /**
     * Creates the action buttons which are located between the `fromGrid` (on the left side)
     * and the `toGrid` (on the right side).
     *
     * The buttons are placed in an `Ext.container.Container` to apply the necessary layout
     * on it.
     *
     * @returns { Ext.container.Container }
     */
    createActionButtons: function() {
        var me = this;

        me.actionButtons = [];
        Ext.Array.forEach(me.defaultButtons, function(name) {

            var button = Ext.create('Ext.Button', {
                tooltip: me.buttonsText[name],
                cls: Ext.baseCSSPrefix + 'form-itemselector-btn',
                iconCls: me.clsName[name],
                action: name,
                navBtn: true,
                margin: '4 0 0 0',
                listeners: {
                    scope: me,
                    click: function() {
                        me.fireEvent(name, me);
                    }
                }
            });
            me.actionButtons.push(button);
        });


        return Ext.create('Ext.container.Container', {
            margins: '0 4',
            items:  me.actionButtons,
            width: 22,
            layout: {
                type: 'vbox',
                pack: 'center'
            }
        });
    },
    
    /**
     * Creates the necessary columns for both grids. Please
     * note that the `name` column has a specific renderer.
     *
     * @returns { Array }
     */
    getColumns: function() {
    	var me=this,columns,dropped;
    	columns = me.callParent(arguments);
    	dropped = {
                header: '',
                hidden: true,
                dataIndex: 'dropped'
            };
        columns.push(dropped);
    	return columns;
    },

    /**
     * Creates a toolbar which could be docked to the top of
     * a grid panel and contains a searchfield to filter
     * the associated grid panel.
     *
     * @returns { Ext.toolbar.Toolbar }
     */
    createSearchToolbar: function(cmp) {
        var me = this, searchField;

        searchField = Ext.create('Ext.form.field.Text', {
            name: 'searchfield',
            dock: 'top',
            cls: 'searchfield',
            width: 270,
            emptyText: 'Search...',
            enableKeyEvents: true,
            checkChangeBuffer: 500,
            listeners: {
                change: function(field, value) {
                    me.fireEvent('search', value, cmp);
                }
            }
        });

        return Ext.create('Ext.toolbar.Toolbar', {
            ui: 'shopware-ui',
            padding: '2 0',
            items: [ '->', searchField, ' ' ]
        });
    },
    
    /**
     * Creates a toolbar which could be docked to the top of
     * a grid panel and contains a searchfield to filter
     * the associated grid panel.
     *
     * @returns { Ext.toolbar.Toolbar }
     */
    createGenSearchToolbar: function(cmp) {
        var me = this, searchField, elements = [];

        searchField = Ext.create('Ext.form.field.Text', {
            name: 'searchfield',
            dock: 'top',
            cls: 'searchfield',
            width: 180,
            emptyText: 'Search...',
            enableKeyEvents: true,
            checkChangeBuffer: 500,
            listeners: {
                change: function(field, value) {
                    me.fireEvent('search', value, cmp);
                }
            }
        });
        
        var button = Ext.create('Ext.button.Button', {
            text: '{s name=tabs/article_mapping/button_reset}Reset Sortierung{/s}',
            iconCls:'sprite-minus-circle-frame',
            handler: function() {
            	me.fireEvent('resetSortOfCategory',me.assignedProductsStore.getProxy().extraParams.categoryId,me.toGrid);
            }
        });
        
        elements.push(button);
        elements.push({
            xtype: 'tbfill'
        });
        elements.push({
            xtype: 'tbfill'
        });
        elements.push(searchField);

        return Ext.create('Ext.toolbar.Toolbar', {
            ui: 'shopware-ui',
            items: elements
        });
    },

    createGridDragAndDrop: function() {
        return Ext.create('Ext.grid.plugin.DragDrop', {
            ddGroup: 'category-product-assignment-grid-dd'
        });
    }
});
//{/block}
