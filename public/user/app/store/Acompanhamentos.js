    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);

    };
Ext.define('User.store.Acompanhamentos',{
extend:'Ext.data.Store',
model:'User.model.Acompanhamento',
remoteSort:true,
remoteFilter:true,
pageSize:15,
//autoSync: true,
autoLoad:false,
autoSync:false,
 proxy:{
    	simpleSortMode:false,

    	type:'ajax',
    	api:{    		
            read:endereco+'user/acompanhamento/list',
    		create:endereco+'user/acompanhamento/add',    		
    		//update:'/helpdesk/public/admin/cliente/update',    		
    		//destroy:'/helpdesk/public/admin/cliente/delete'
    	
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