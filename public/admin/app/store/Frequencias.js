    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);

    };
Ext.define('Admin.store.Frequencias',{
extend:'Ext.data.Store',
fields:['quantidade','servico'],
remoteSort:false,
remoteFilter:true,
pageSize:15,
//autoSync: true,
autoLoad:true,
autoSync:false,


 proxy:{
    	simpleSortMode:false,

    	type:'ajax',
    	api:{    		
            read:endereco+'admin/solicitacao/solicitacoesmaisfrequentes',
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