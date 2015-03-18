Ext.define('Tecnico.view.Viewport', {
    extend: 'Ext.container.Viewport',
    requires:[
        'Ext.layout.container.Fit',
        'Tecnico.view.Main'
    ],

    layout: {
        type: 'fit'
    },

    items: [{
        xtype: 'appmain'
    }]
});
