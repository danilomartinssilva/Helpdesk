    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);
    };
Ext.define('Admin.store.Statuss',{
	extend:'Ext.data.Store',
	model:'Admin.model.Status',
	remoteSort:true,
	remoteFilter:true,
	
	//autoLoad:true,	
    proxy:{
    	simpleSortMode:true,
    	type:'ajax',
    	api:{
    		read:endereco+'admin/status/list'
    		
    	
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

    }
})