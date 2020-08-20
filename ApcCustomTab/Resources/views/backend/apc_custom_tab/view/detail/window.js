//{block name="backend/article/view/detail/window"}
// {$smarty.block.parent}
Ext.define('Shopware.apps.ApcCustomTab.view.detail.Window', {
    override: 'Shopware.apps.Article.view.detail.Window',


    createMainTabPanel: function() {
        var me = this,
            result = me.callParent();
            me.customTab = Ext.create('Shopware.apps.ApcCustomTab.view.detail.CustomTab',{
                autoScroll: true,
                bodyPadding: 10,
                disabled: true,
            })

        return me.mainTab = Ext.create('Ext.tab.Panel', {
            name: 'main-tab-panel',
            items: [
                me.createBaseTab(),
                me.categoryTab,
                me.imageTab,
                me.variantTab,
                me.propertiesTab,
                me.crossSellingTab,
                me.esdTab,
                me.statisticTab,
                me.resourcesTab,
                me.customTab
            ]
        });
    },
    onStoresLoaded: function(article, stores) {
      var me = this;
      me.article = article;

      me.unitComboBox.bindStore(stores['unit']);
      me.supplierStore = stores['suppliers'];
      window.setTimeout(function() {
        me.detailForm.loadRecord(me.article);
      }, 10);

      me.categoryTab.add(me.createCategoryTab());
      me.categoryTab.setDisabled(false);

      me.imageTab.add(me.createImageTab());
      me.imageTab.setDisabled(false);

      me.variantTab.add(me.createVariantTab());

      me.crossSellingTab.add(me.createCrossselingTab());
      me.crossSellingTab.setDisabled(false);

      me.propertiesTab.setDisabled(false);

      me.esdTab.add(me.createEsdTab());
      me.esdTab.setDisabled((me.article.get('id') === null));

      me.statisticTab.add(me.createStatisticTab());
      me.statisticTab.setDisabled(me.article.get('id') === null);

      me.resourcesTab.add(me.createResourcesTab());
      me.resourcesTab.setDisabled(false);

      me.variantListing.customerGroupStore = stores['customerGroups'];

      me.attributeForm.loadAttribute(article.get('mainDetailId'));
      me.attributeForm.disableForm(false);
          
      me.customTab.loadAttribute(article.get('mainDetailId'));
      me.customTab.setDisabled(false);

      if(me.subApp.splitViewActive) {
        me.variantTab.setDisabled(true);
      }

    },
 

});
//{/block}
