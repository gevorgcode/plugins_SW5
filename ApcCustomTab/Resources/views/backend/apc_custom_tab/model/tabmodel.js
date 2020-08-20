
//
Ext.define('Shopware.apps.ApcCustomTab.model.Tabmodel', {

    extend: 'Ext.data.Model',

    fields: [
        { name : 'article_id', type: 'int' },    
        { name : 'id', type: 'int'},
        { name : 'tab_name', type: 'string' },
        { name : 'tab_content', type: 'string' },
    ]
});
