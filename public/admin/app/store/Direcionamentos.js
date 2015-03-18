    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);

    };
Ext.define('Admin.store.Direcionamentos',{
extend:'Ext.data.Store',
model:'Admin.model.Direcionamento',
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
            read:endereco+'admin/direcionamento/list',
            create:endereco+'admin/direcionamento/add',            
            destroy:endereco+'admin/direcionamento/delete',            
            
        
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