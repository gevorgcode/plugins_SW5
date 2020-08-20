// This is the controller


Ext.define('Shopware.apps.ApcCustomTab.controller.MyOwnController', {
     /**
     * Override the article main controller
     * @string
     */
    override: 'Shopware.apps.Article.controller.Detail',

    init: function () {
        var me = this;
        // me.callParent will execute the init function of the overridden controller
        me.callParent(arguments);
    },
});
