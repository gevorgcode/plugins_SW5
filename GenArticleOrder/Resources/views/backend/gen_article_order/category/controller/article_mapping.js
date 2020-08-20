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
 * The licensing of the program under the AGPLv3 does +not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 *
 * @category   Shopware
 * @package    Category
 * @subpackage Controller
 * @copyright  Copyright (c) 2012, shopware AG (http://www.shopware.de)
 * @version    $Id$
 * @author shopware AG
 */

// {namespace name=backend/category/main}

/**
 * Shopware Controller - category management controller
 *
 * The category management controller handles the initialisation of the category tree.
 */
//{block name="backend/category/controller/article_mapping" append}
Ext.define('Gen.apps.Category.controller.ArticleMapping', {
	override: 'Shopware.apps.Category.controller.ArticleMapping',
    /**
     * Extend from the standard ExtJS 4 controller
     * @string
     */
    extend: 'Ext.app.Controller',
    
    snippets:{
    	articleorder:{
    		title:'{s name="articleorder/title"}Artikelreihenfolge{/s}',
    		saved:'{s name="articleorder/saved"}Die Artikelreihenfolge wurde gespeichert!{/s}',
    		reset:'{s name="articleorder/reset"}Manuelle Artikelsortierung gelöscht!{/s}',
    		resetFailure:'{s name="articleorder/resetFailure"}Löschen fehlgeschlagen!{/s}'
    	}
    },
    
    /**
     * Contains all text messages for this controller
     * @object
     */
    messages: {
        resetDialogMessage : '{s name=articleorder/dialog_text}Möchten Sie wirklich Ihre Sortierung löschen?{/s}',
        resetDialogTitle : '{s name=articleorder/dialog_title}Manuelle Artikelsortierung{/s}'
    },

    /**
     * Initializies the necessary event listener for the controller.
     *
     * @returns { Void }
     */
    init: function() {
        var me = this;

        me.control({
            'category-category-tabs-article_mapping': {
                'search': me.onSearch,
                'add': me.onAddProducts,
                'remove': me.onRemoveProducts,
                'top': me.onTopProducts,
                'up': me.onUpProducts,
                'down': me.onDownProducts,
                'bottom': me.onBottomProducts,
                'resetSortOfCategory': me.onResetSortOfCategory
            },
            'category-category-tabs-article_mapping grid': {
                'selectionchange': me.onSelectionChange
            },
            'category-category-tabs-article_mapping gridview': {
                'drop': me.onDragAndDropAssignment
            }
        });
    },

    /**
     * Triggers a search by using an `extraParam` on the
     * associated store of the active grid.
     *
     * @param { String } value
     * @param { Ext.grid.Panel } activeGrid
     */
    onSearch: function(value, activeGrid) {
    	var me = this,
        store = activeGrid.getStore(),
        view = activeGrid.getView(),
        cellSelector = view.cellSelector,
        count = 0,
        recordToFocus;

        value = Ext.String.trim(value);
      
        if(activeGrid.internalTitle=='from'){
             store.currentPage = 1;

             store.getProxy().extraParams.search = (!value.length) ? '' : value;
             store.load();
        }
        else{
        	store.currentPage = 1;

            store.getProxy().extraParams.search = (!value.length) ? '' : value;
            store.load({
            	callback : function(records, options, success) {
                    if (success) {
	            		var rowIndex = store.find('found', 1);            
	            		var record = store.getAt(rowIndex);
	            		activeGrid.getView().focusRow(record);
                    }
            	}
            });
        }
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
            activeView = data.view,
            activeGrid = activeView.panel,
            store = activeGrid.getStore(),
            records = data.records, record = records[0], action, categoryId, ids = [], droppedArticleID;

        action = (activeGrid.internalTitle === 'from') ? 'add' : 'remove';
 
        if(activeGrid.internalTitle === 'to'){
        	   droppedArticleID = records[0].raw.articleId;
   
        	   Ext.Ajax.request({
                   url:'{url controller=GenArticleOrder action="savePositions"}',
                   params:{
                	   categoryId : store.getProxy().extraParams.categoryId,
                	//   value:Ext.encode(Ext.pluck(store.data.items, 'data'))
                	   articles : Ext.encode(Ext.pluck(store.data.items, 'data')),
                	   droppedArticleID: droppedArticleID
                   },
        	       success: function(res) {
        	   		     Shopware.Notification.createGrowlMessage(me.snippets.articleorder.title,me.snippets.articleorder.saved);
        	   		     var result = Ext.decode(res.responseText);
        	   		     var selection = activeGrid.getSelectionModel().getSelection();
        	   		     for(var i = 0; i < selection.length ; i++){
        	   		    	 record = selection[i];
        	   		    	 var rowIndex = store.indexOf(record);
        	   		    	 if(result.coloredArticles){
        	   		    		 activeGrid.getView().removeRowCls(rowIndex, Ext.baseCSSPrefix + 'grid-row-found-article');
        	   		    		 activeGrid.getView().addRowCls(rowIndex, Ext.baseCSSPrefix + 'grid-row-dropped-article');
        	   		    	 }
        	   	       }
        	       }
               })
        }
        else{
	        Ext.each(records, function(record) {
	            ids.push(record.data.articleId);
	        });
	
	        categoryId = store.getProxy().extraParams.categoryId;
	
	        me._sendRequest(action, ids, categoryId);
        }
    },
    
    /**
     * Event listener method which will be fired when the user reset sort of one category
     *
     * @param { int } categoryId
     */
    onResetSortOfCategory: function(categoryId,toGrid) {
        var me = this;
        var mapping = this.getArticleMappingView();
        // Get the user to confirm the reset sort of category
        Ext.MessageBox.confirm(me.messages.resetDialogTitle,
            Ext.String.format(me.messages.resetDialogMessage, me.messages.resetDialogTitle),
            function (response) {
                var errorOccurred = false;
                if (response !== 'yes') {
                    return false;
                }
                if(response=='yes'){  
                	mapping.setLoading(true);
                	Ext.Ajax.request({
	                    url:'{url controller=GenArticleOrder action="resetCategory"}',
	                    params:{
	                 	   categoryId : categoryId,
	                    },
             	        success: function(res) {
             	   		     Shopware.Notification.createGrowlMessage(me.snippets.articleorder.title,me.snippets.articleorder.reset);
             	   		     toGrid.getStore().load();
             	   		     mapping.setLoading(false);
             	        },
	                    failure: function(res){
	                    	Shopware.Notification.createGrowlMessage(me.snippets.articleorder.title,me.snippets.articleorder.resetFailure);
	                    	mapping.setLoading(false);
	                    }
                     });
                }
        });
    },
    
    savePositions: function(activeGrid, store){
    	var me = this;
    	Ext.Ajax.request({
            url:'{url controller=GenArticleOrder action="savePositions"}',
            params:{
         	   categoryId : store.getProxy().extraParams.categoryId,
         	//   value:Ext.encode(Ext.pluck(store.data.items, 'data'))
         	   articles : Ext.encode(Ext.pluck(store.data.items, 'data'))
            },
 	       success: function(res) {
 	   		     Shopware.Notification.createGrowlMessage(me.snippets.articleorder.title,me.snippets.articleorder.saved);
 	   		     var result = Ext.decode(res.responseText);
 	   		     var selection = activeGrid.getSelectionModel().getSelection();
 	   		     for(var i = 0; i < selection.length ; i++){
 	   		    	 record = selection[i];
 	   		    	 var rowIndex = store.indexOf(record);
 	   		    	 if(result.coloredArticles){
 	   		    		 activeGrid.getView().removeRowCls(rowIndex, Ext.baseCSSPrefix + 'grid-row-found-article');
 	   		    		 activeGrid.getView().addRowCls(rowIndex, Ext.baseCSSPrefix + 'grid-row-dropped-article');
 	   		    	 }
 	   		     }
 	       }
        })
    },
    
    onTopProducts: function(scope) {
        var me = this, grid = scope.toGrid,
            store = grid.getStore(),
            selection = grid.getSelectionModel().getSelection(),
            ids = [], categoryId;

        if(!selection.length) {
            return false;
        }
        
        store.remove(selection);
        store.insert(0, selection);
        
        me.savePositions(grid,store);

        return true;
    },
    
    onUpProducts: function(scope) {
        var me = this, grid = scope.toGrid,
            store = grid.getStore(),
            selection = grid.getSelectionModel().getSelection(),
            ids = [], categoryId, index = 0;

        if(!selection.length) {
            return false;
        }
        
        for (i=0; i < selection.length; i++) {
            index = Math.max(index, store.indexOf(selection[i]));
        }
      
        if (index > 0) {
            store.remove(selection);
            store.insert(index -1, selection);
            grid.getSelectionModel().select(selection);
        }
        
        me.savePositions(grid,store);
        return true;
    },
    
    onDownProducts: function(scope) {
        var me = this, grid = scope.toGrid,
            store = grid.getStore(),
            selection = grid.getSelectionModel().getSelection(),
            ids = [], categoryId, index = 0;

        if(!selection.length) {
            return false;
        }
        
        for (i=0; i < selection.length; i++) {
            index = Math.max(index, store.indexOf(selection[i]));
        }
       
        if (index < store.getCount() - 1) {
            store.remove(selection);
            store.insert(index + 2 - selection.length, selection);
            grid.getSelectionModel().select(selection);
        }
        
        me.savePositions(grid,store);
        return true;
    },
    
    onBottomProducts: function(scope) {
        var me = this, grid = scope.toGrid,
            store = grid.getStore(),
            selection = grid.getSelectionModel().getSelection(),
            ids = [], categoryId, index;

        if(!selection.length) {
            return false;
        }
        
        index = store.getCount();
        store.remove(selection);
        store.insert(index, selection);
        
        me.savePositions(grid,store);
        return true;
    },
    
    /**
     * Event listener method which will be fired when the user selects an entry
     * in either the `toGrid` or the `fromGrid`.
     *
     * The method handles the enables / disables the buttons in the middle column
     * of the view and deselects all entries in the inactive grid.
     *
     * @param { Ext.selection.CheckboxModel } selModel
     * @param { Array } selection
     * @returns { boolean }
     */
    onSelectionChange: function(selModel, selection) {
        var me = this,
            view = me.getArticleMappingView(),
            activeGrid = selModel.view.panel, inactiveGrid,
            activeBtn, inactiveBtn;

        // Prevent the grid to get a little sluggish
        if(!selection.length) {
            return false;
        }

        inactiveGrid = (activeGrid.internalTitle === 'from') ? view.toGrid : view.fromGrid;

        if(activeGrid.internalTitle === 'from') {
            activeBtn = me.getAddButton();
            inactiveBtn = me.getRemoveButton();
        } else {
            activeBtn = me.getRemoveButton();
            inactiveBtn = me.getAddButton();
        }

        // Enable / disable buttons
        if(typeof activeBtn !== 'undefined'){
	        activeBtn.setDisabled(false);
	    }
        if(typeof inactiveBtn !== 'undefined'){
        	inactiveBtn.setDisabled(true);
        }

        inactiveGrid.getSelectionModel().deselectAll(true);

        return true;
    },
    
    /**
     * Helper method which sents the AJAX request to add / remove
     * the records, which are associated with the incoming id's.
     *
     * @param { String } action - Action which will be used for the request: add (default), remove
     * @param { Array } ids - Array of record id's
     * @param { Integer } categoryId - Id of the selected category
     * @private
     */
    _sendRequest: function(action, ids, categoryId) {
        var mapping = this.getArticleMappingView();
        var url = '{url controller=Category action=addCategoryArticles}';
        var message = '{s name="category/action/add/success"}[0]x articles assigned{/s}';
        var failure = '{s name="category/action/add/failure"}The following error occurred while adding the articles:{/s}';

        if(action === 'remove') {
            message = '{s name="category/action/remove/success"}[0]x articles assignments removed{/s}';
            failure = '{s name="category/action/remove/failure"}The following error occurred while removing the articles:{/s}';

            url = '{url controller=Category action=removeCategoryArticles}';
        }
        mapping.setLoading(false);

        Ext.Ajax.request({
            url: url,
            params: { ids: Ext.JSON.encode(ids), categoryId: ~~(1 * categoryId) },
            success: function(response) {

                var result = Ext.decode(response.responseText);
                message = Ext.String.format(message, result.counter);
                Shopware.Notification.createGrowlMessage('',message);

                mapping.fireEvent('sendRequestSuccess', result);
            },
            failure: function(response) {
                mapping.setLoading(false);

                var result = Ext.decode(response.responseText);
                failure = failure + '<br>' + result.error;
                Shopware.Notification.createGrowlMessage('',message);
                mapping.fireEvent('sendRequestFailure', result);
            }
        });
    }
});
//{/block}

