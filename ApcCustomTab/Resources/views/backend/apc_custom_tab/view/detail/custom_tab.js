
//{namespace name=backend/article/view/main}
Ext.define('Shopware.apps.ApcCustomTab.view.detail.CustomTab', {


    extend: 'Ext.form.Panel',


    layout: {
        type: 'vbox',
        align : 'stretch',
        pack  : 'start'
    },
    plugins: [{
                ptype: 'translation',
                pluginId: 'translation',
                translationType: 'tab',
                translationMerge: false,
                translationKey: null
            }],
    // ?
    alias: 'widget.custom-tab',
    
   

    cls: Ext.baseCSSPrefix + 'article-esd-list',

    style: 'background: #ebedef',
    snippets:{
        title:'{s name=detail/tab/title}Tab Property{/s}',
        notice:'{s name=detail/tab/notice}.{/s}',
        property:'{s name=detail/tab/property}Select property{/s}',
        name:'{s name=detail/tab/name_column}Property{/s}',
        value:'{s name=detail/tab/value_column}Values{/s}',
        empty:'{s name=empty}Please type here...{/s}',
        button_text: '{s name=detail/tab/create_button_text}Create{/s}',
        comboset_label: '{s name=detail/tab/comboset_label}Choose set{/s}',
        set_tab_name: '{s name=detail/tab/set_tab_name}Set tab name{/s}',
        setTabContent: '{s name=detail/tab/set_tab_content}Set tab content{/s}',
        description: '{s name=detail/tab/description}.{/s}',
        delete : '{s name=detail/sidebar/similar/delete}Remove entry{/s}',
    },

    defaults: {
        labelWidth: 155,
        anchor: '100%'
    },

    bodyPadding: 10,

    title: "FAQ Tab",

    initComponent:function () {
        var me = this;

        
        me.items = [ me.createElements(), me.createGridPanel() ];
        me.callParent(arguments);
    },

    loadAttribute: function(articleId) {
        var me = this;

        me.articleId = articleId;
        me.loadStore();
    },
    
    loadStore: function(){
        var me = this;
        me.tabGrid.getStore().getProxy().extraParams.articleId = me.articleId;
        me.tabGrid.getStore().load();
    },
    getFields: function () {
        var me = this;

        return {
            items: [
                me.down('[name=field1]'),
                me.down('[name=field2]')
            ]
        };
    },
    createElements: function() {
        var me = this;

        me.tabName = Ext.create('Ext.form.field.Text', {
            fieldLabel: me.snippets.set_tab_name,
            name: 'tabName',
            emptyText: me.snippets.empty,
            labelWidth: 155,
            pageSize: 10,
            translatable: true,
            flex: 10,
            allowBlank: true,
            translationName: 'field1'
        });


        me.tabContent = Ext.create('Shopware.form.field.TinyMCE', {
            name: 'tabContent',
            fieldLabel: me.snippets.setTabContent,
            emptyText: me.snippets.empty,
            enableKeyEvents: true,
            labelWidth: 155,
            translatable: true,
            allowBlank: true,
            translationName: 'field2'
        });

        me.addButton = Ext.create('Ext.button.Button', {
            text: me.snippets.button_text,
            cls: 'small primary',
            margin: '2 900 0 160',

            handler: Ext.bind(me.assignValuesToStore, me)
        });

        me.fieldContainer = Ext.create('Ext.container.Container', {
            columnWidth: 0.5,
            layout: 'anchor',
            defaults: {
                labelWidth: 155,
                anchor: '100%'
            },
            items: [ me.tabName, me.tabContent, me.addButton ]
        });




        me.fieldset = Ext.create('Ext.form.FieldSet', {
            title: me.snippets.title,
            layout: 'anchor',
            defaults: {
                labelWidth: 155,
                anchor: '100%'
            },
            items: [
                me.noticeContainer,
                me.setComboBox,
                me.fieldContainer,
            ]
        });

        return me.fieldset;
    },
    


    
    assignValuesToStore: function() {
        var me = this,
            field = me.tabName,
            value = field.getValue();
        if (!value) {
            return;
        }

        me.createValue(
            value,
            me.tabContent.getValue()
        );
        field.setValue('');
    },



    /**
     * Creates a new property value using an AJAX requests and adds
     * the newly created value to the store.
     *
     * @param { Number } tabName
     * @param { String } newValue
     */
    createValue: function(tabName, tabContent) {
        var me = this,
            url = window.location.origin+"{url module=backend controller=customTab action=setTab}";
        
        Ext.Ajax.request({
            url: url,
            method: 'POST',
            params: {
                tabContent: tabContent,
                tabName: tabName,
                articleId: me.articleId,
            },
            success: function(operation, opts) {
                var response = Ext.decode(operation.responseText);

                if (response.success == false) {
                    Shopware.Notification.createGrowlMessage('', response.message);
                } else {
                    me.loadStore();
                }
            }
        });
    },
   
    createStore: function(){
        var me = this;
        return Ext.create('Shopware.apps.ApcCustomTab.store.Tabmodel');

    },
    
    createGridPanel: function() {
        var me = this;
        return me.tabGrid = Ext.create('Ext.grid.Panel', {
            title: "Tabs",
            cls: Ext.baseCSSPrefix + 'free-standing-grid',
            autoScroll: true,
            name: "tab-listing",
            store:  me.createStore(),
            height: 305,
            columnWidth: 0.65,
            columns: [
                {
                    header: "id",
                    dataIndex: 'id',
                    width: 120
                }, {
                    header: "tab name",
                    dataIndex: 'tab_name',
                    flex: 1,
                    width: 140
                }, {
                    header: "tab content",
                    dataIndex: 'tab_content',
                    flex: 1,
                }, {
                    xtype: 'actioncolumn',
                    width: 60,
                    items: [
                        {
                            iconCls: 'sprite-minus-circle-frame',
                            tooltip: me.snippets.delete,
                            handler: function (view, rowIndex, colIndex, item, opts, record) {
                                me.deleteItem(record);
                            }
                        },
                        
                        
                        
                    ]
                }
            ]
        });
    },
    
    deleteItem: function(record){
        var me = this,
            url = window.location.origin+"{url module=backend controller=customTab action=deleteTab}";
            console.log(record.internalId);
        Ext.Ajax.request({
            url: url,
            method: 'POST',
            params: {
                id: record.internalId,
            },
            success: function(operation, opts) {
                var response = Ext.decode(operation.responseText);

                if (response.success == false) {
                    Shopware.Notification.createGrowlMessage('', response.message);
                } else {
                    me.loadStore();
                }
            }
        });
    },

});
