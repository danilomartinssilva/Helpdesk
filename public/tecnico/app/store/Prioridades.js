    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);

    };
Ext.define('Tecnico.store.Prioridades',{
extend:'Ext.data.Store',
model:'Tecnico.model.Prioridade',
remoteSort:false,
remoteFilter:true,
pageSize:15,
//autoSync: true,
autoLoad:false,
autoSync:false,


 proxy:{
    	simpleSortMode:false,

    	type:'ajax',
    	api:{
    		//read:'app/data/php/Departamento.php?listAll',
           // read:'/helpdesk/public/tecnico/prioridade/list',
            read:'../tecnico/prioridade/list',
    		//create:'/helpdesk/public/admin/departamento/add',    		
    		//update:'/helpdesk/public/admin/departamento/update',    		
    		//destroy:'/helpdesk/public/admin/departamento/delete'
    	
    	},
    	actionMethods:{
    		read:'POST'
    	},
    	reader:{
    		type:'json',
    		root:'data',
    		successPriority:'success',
    		messageProperty:'error',
    	},
    	writer:{
    		type:'json',
    		root:'data',
    		encode:true,
    		 writeAllFields: true
    	},
    	
    	
   	listeners: {
            exception: function(proxy, response, operation){            	 
            	 var result = Ext.JSON.decode(response.responseText, true);
                Ext.MessageBox.show({
                    title: 'Warning',
                    msg: result.message,
                    icon: Ext.MessageBox.ERROR,
                    buttons: Ext.Msg.OK
                }); 
            }
       },
    		
    }
});