    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);
    };
Ext.define('Tecnico.store.Statuss',{
	extend:'Ext.data.Store',
	model:'Tecnico.model.Status',
	remoteSort:true,
	autoLoad:true,
    proxy:{
    	simpleSortMode:true,
    	type:'ajax',
    	api:{
    		//read:'/helpdesk/public/tecnico/status/list'
              read:endereco+'tecnico/status/list',
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