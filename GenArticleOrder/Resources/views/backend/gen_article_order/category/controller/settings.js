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
 * @package    Category
 * @subpackage Controller
 * @version    $Id$
 * @author shopware AG
 */

/* {namespace name=backend/category/main} */

/**
 * Shopware Controller - category management controller
 *
 * The category management controller handles the initialisation of the category tree.
 */
//{block name="backend/category/controller/settings" append}
Ext.define('Gen.apps.Category.controller.Settings', {
    /**
     * Extend from the standard ExtJS 4 controller
     * @string
     */
    override: 'Shopware.apps.Category.controller.Settings',
    
    /**
     * Reacts if the event recordloaded is fired and hides or shows the template selection based
     * on the parent ID of the loaded record.
     *
     * @event recordloaded
     * @param record [Ext.data.Model]
     * @return void
     */
    onRecordLoaded : function(record, treeRecord) {
        var me = this,
            mainWindow = me.subApplication.mainWindow,
            articleMappingContainer = mainWindow.articleMappingContainer;

        if(record.getId() != me.subApplication.defaultRootNodeId){
            me.selectorView = Ext.create('Shopware.apps.Category.view.category.tabs.ArticleMapping', {
                availableProductsStore: me.subApplication.availableProductsStore,
                assignedProductsStore: me.subApplication.assignedProductsStore,
                record: record
            });
            articleMappingContainer.setDisabled(false);
            articleMappingContainer.removeAll(false);
            articleMappingContainer.add(me.selectorView);
        }
        else {
            //if the main category is clicked disable the settings form
            me.disableForm();
            mainWindow.tabPanel.setActiveTab(0);
        }
    
        me.callParent(arguments);
    }
});
//{/block}

