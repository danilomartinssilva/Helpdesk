Ext.define('User.view.Main', {
    extend: 'Ext.container.Container',
    requires:[
        'Ext.tab.Panel',
        'Ext.layout.container.Border'
    ],
    
    xtype: 'appmain',

    layout: {
        type: 'border'
    },

    items: [{
        region:'north',
        xtype:'topo',

    },
    {
        region: 'west',
        xtype: 'app-menu',
        title: 'Menu',
        width: 300
    },{
        itemId:'conteudo',
        region: 'center',
        xtype: 'content',
        
    }]
});