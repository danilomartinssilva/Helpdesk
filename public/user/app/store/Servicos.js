    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);

    };
Ext.define('User.store.Servicos',{
extend:'Ext.data.Store',
model:'User.model.Servico',
remoteSort:false,
remoteFilter:true,
pageSize:15,
autoLoad:false,
autoSync:false,


 proxy:{
    	simpleSortMode:false,

    	type:'ajax',
    	api:{    		
            read:endereco+'user/servico/list',
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