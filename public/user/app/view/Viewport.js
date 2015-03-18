Ext.define('User.view.Viewport', {
    extend: 'Ext.container.Viewport',
    requires:[
        'Ext.layout.container.Fit',
        'User.view.Main'
    ],

    layout: {
        type: 'fit'
    },

    items: [{
        xtype: 'appmain'
    }]
});
