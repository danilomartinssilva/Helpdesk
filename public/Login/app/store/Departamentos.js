   var endereco = window.dataServerUsuario.endereco;
    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);

    };
Ext.define('Login.store.Departamentos',{
extend:'Ext.data.Store',
model:'Login.model.Departamento',
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
            /*read:endereco+'admin/departamento/list',
    		create:endereco+'admin/departamento/add',    		
    		update:endereco+'admin/departamento/update',    		
    		destroy:endereco+'admin/departamento/delete'
            */
            read:endereco+'admin/departamento/list',
            
            
            
    	
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