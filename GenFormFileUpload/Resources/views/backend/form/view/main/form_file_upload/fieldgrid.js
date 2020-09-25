//{block name="backend/form/view/main/fieldgrid"}
//{namespace name="backend/gen_form_file_upload/main"}
Ext.define('Shopware.apps.Form.view.main.Fieldgrid-GenFormFileUpload', {

    /**
     * Defines an override applied to a class.
     * @string
     */
    override: 'Shopware.apps.Form.view.main.Fieldgrid',

    /**
     * Override the getTypComboStore function of the overridden ExtJs Object
     * and insert new field
     *
     * @return [Ext.data.SimpleStore]
     */
    getTypComboStore: function () {
        var me = this;

        var store = me.callParent();
        store.on('load', function () {
            store.add({
                id: 'file',
                label: 'File'
            });
            store.add({
                id: 'files',
                label: 'Files'
            });
        });

        return store;
    }
});
//{/block}
