    var onException = function(proxy, response) {
        var result = Ext.decode(response.responseText);
        console.log(result);

    };
Ext.define('Admin.store.Solicitacaos',{
extend:'Ext.data.Store',
model:'Admin.model.Solicitacao',
remoteSort:false,
remoteFilter:true,
pageSize:15,



 proxy:{
        simpleSortMode:false,

        type:'ajax',
        api:{
            //read:'app/data/php/Departamento.php?listAll',
            read:endereco+'admin/solicitacao/list',
            create:endereco+'admin/solicitacao/add',    
            destroy:endereco+'admin/solicitacao/delete',             
            
        
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