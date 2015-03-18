Ext.define("Tecnico.view.content.Content", {
    extend: 'Ext.tab.Panel',    
    xtype:'content',
    items: [{
        xtype: 'panel',             
        html:'Navegue pelo menu lateral',
        autoDestroy:true,
        title:'Página Inicial',
    }]

});