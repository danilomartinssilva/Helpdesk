        var onException = function(proxy, response) {
            var result = Ext.decode(response.responseText);
            console.log(result);

        };
    Ext.define('Tecnico.store.Clientes',{
    extend:'Ext.data.Store',
    model:'Tecnico.model.Cliente',
    remoteSort:false,
    remoteFilter:true,
    pageSize:15,
    autoLoad:false,
    autoSync:false,

     proxy:{
        	simpleSortMode:false,

        	type:'ajax',
        	api:{    		
                //read:'/helpdesk/public/tecnico/cliente/list',
                read:endereco+'tecnico/cliente/list',
        		//create:'/helpdesk/public/admin/cliente/add',    		
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