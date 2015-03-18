    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);

    };
Ext.define('Admin.store.Basedeconhecimentos',{
extend:'Ext.data.Store',
model:'Admin.model.Basedeconhecimento',
remoteSort:false,
remoteFilter:true,
pageSize:20,
//autoSync: true,
autoLoad:false,
autoSync:false,


 proxy:{
    	simpleSortMode:false,

    	type:'ajax',
    	api:{
    		//read:'app/data/php/Departamento.php?listAll',
            read:endereco+'admin/basedeconhecimento/list',
    		create:endereco+'admin/basedeconhecimento/add',    		
    	//	update:endereco+'admin/departamento/update',    		
    		destroy:endereco+'admin/basedeconhecimento/delete'
    	
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
		    writeAllFields: true,
            

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