Ext.define('User.controller.Main', {
    extend: 'Ext.app.Controller',
    views:['Main'],
    refs:[{
    	ref:'appmain',
    	selector:'appmain'
    }],
    init:function(){
	this.control({
		'treepanel':{
			itemclick:this.Selecionar
		}
	})
	},
	    Selecionar:function(me,record,index,eopts){
    	var mainPanel = this.getAppmain();    	
	    var newTab = mainPanel.getComponent('conteudo').items.findBy(
        function (tab){ 
        	
            return tab.title === record.get('text'); 

        	}
        );
		   if(!newTab){
	     	newTab = mainPanel.getComponent('conteudo').add({

	     		xtype:record.get('id'),
	     		closable:true,
	     		iconCls:record.get('iconCls'),
	     		title:record.get('text')

	     	});

	     }
	      mainPanel.getComponent('conteudo').setActiveTab(newTab);
	     
	}


});
