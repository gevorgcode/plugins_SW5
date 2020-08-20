//{namespace name=backend/plugin_manager/translation}
//{block name="backend/plugin_manager/controller/plugin"}
//{$smarty.block.parent}
Ext.define('Shopware.apps.ApcIcLoading.controller.Plugin', {
    override:'Shopware.apps.PluginManager.controller.Plugin',

    icLoadingPluginName: 'ApcIcLoading',

    /**
     * List of caches which will be cleared
     */
    caches: [
        'template',
        'config',
        'theme'
    ],

    /**
     * Overrides the saveConfiguration function from plugin manager
     * @param plugin
     * @param form
     */
    saveConfiguration: function(plugin, form) {
        var me = this;

        if (plugin.data.technicalName !== me.icLoadingPluginName) {
            return me.callParent(arguments);
        }

        // Close plugin config and clear cache
        form.onSaveForm(form, true, function() {
            me.clearCache(me.caches);
        });
    }
});
//{/block}
