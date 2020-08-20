
//
Ext.define('Shopware.apps.ApcCustomTab.store.Tabmodel', {
    /**
     * Extends the default Ext Store
     * @string
     */
    extend: 'Ext.data.Store',
    // Do not load data, when not explicitly requested
    autoLoad: false,
    model: 'Shopware.apps.ApcCustomTab.model.Tabmodel',
    remoteFilter: true,
    remoteSort: true,
    /**
     * Configure the data communication
     * @object
     */
    proxy: {
        type: 'ajax',

        /**
         * Configure the url mapping
         * @object
         */
        api: {
            read: '{url controller=CustomTab action="list"}',
            destroy: '{url controller=CustomTab action="deleteTab" targetField=tabs}'
        },

        /**
         * Configure the data reader
         * @object
         */
        reader: {
            type: 'json',
            root: 'data',
            totalProperty:'total'
        }
    }
            
   
});