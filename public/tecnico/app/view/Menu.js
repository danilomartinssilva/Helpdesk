/*Ext.define("Tecnico.view.Menu", {
	extend:'Ext.tree.Panel',
	store:'MenuStore',
    title: 'Hello',
    xtype:'app-menu',
    width: 200,
    rootVisible: false,
    //renderTo: Ext.getBody()
});

*/




 Ext.define('AccModel', {
    extend: 'Ext.data.Model',
    fields: ['id','text','iconCls']
  });
  
   Ext.define('Tecnico.view.Menu', {
    extend:'Ext.panel.Panel',
    xtype:'app-menu',
    //width: 300,
    height: 500,
    
    id: 'accordionPanel',
    defaults: {
     //bodyStyle: 'padding:15px'
    },
    layout: {
      type: 'accordion',
      titleCollapse: true,
      animate: true,
      activeOnTop: false
    },
    renderTo: Ext.getBody()
  });

  var addAccordion = function() {
    Ext.Ajax.request({
      url: endereco+'tecnico/index/menu',
      success: function(response) {
        var nodes = Ext.JSON.decode(response.responseText);   
        var menuAccordion = Ext.ComponentQuery.query('app-menu')[0];
        Ext.each(nodes.data, function(node) {
          menuAccordion.add({
            title: node.id,
            id: node.id,
            iconCls:node.iconCls,
            items: Ext.create('Ext.tree.Panel', {
              //header: false,
              
              rootVisible: false,
              root: {
                expanded: false,
                children: node.children
              }
            })
          });
        })
      }
    });
  }

  var init=function() {
    addAccordion();
  }

  Ext.onReady(function () {
    init();
  });