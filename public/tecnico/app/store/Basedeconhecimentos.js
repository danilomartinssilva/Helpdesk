    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);

    };
Ext.define('Tecnico.store.Basedeconhecimentos',{
extend:'Ext.data.Store',
model:'Tecnico.model.Basedeconhecimento',
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
    	
            read:endereco+'tecnico/basedeconhecimento/list',
    		create:endereco+'tecnico/basedeconhecimento/add',    		
    			
    		
    	
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