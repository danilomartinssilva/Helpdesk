        var onException = function(proxy, response) {
            var result = Ext.decode(response.responseText);
            console.log(result);

        };
    Ext.define('Tecnico.store.Solicitacaos',{
    extend:'Ext.data.Store',
    model:'Tecnico.model.Solicitacao',
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
        		read:endereco+'tecnico/solicitacao/list',
                create:endereco+'tecnico/solicitacao/add',          
                
                //read:'/helpdesk/public/tecnico/solicitacao/list',
        	    //create:'/helpdesk/public/tecnico/solicitacao/add',    		
        		
        	
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