Ext.define('Admin.view.direcionamento.Listar', {
    extend:'Ext.grid.Panel',
    title: 'Grupos de Servico',
    xtype:'lisdir',
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Direcionamentos',
    viewConfig: {
        deferEmptyText: false,
        emptyText: 'No data'        
    },
    initComponent:function()
    {
        this.dockedItems= [{
              xtype:'pagingtoolbar',
              store:'Direcionamentos',
              dock:'bottom',
              displayinfo:true
            }];
        this.callParent();
    },
    
    columns: [
       // { header: 'Id',  dataIndex: 'id_cadcli' ,width:30},
        { header: 'Id', dataIndex: 'id_caddir',width:30},
          { header: 'Descrição', dataIndex: 'descricao_caddir', flex:1},
          {
                xtype:'actioncolumn',
                header:'Excluir',
                
                items:[{
                    iconCls:'icone_excluir',
                    handler:function(grid,rowIndex,colIndex){
                        var store = grid.getStore();
                        var records = grid.getStore().getAt(rowIndex);
                Ext.MessageBox.confirm('Warning!','Se você excluir este grupo, os usuários irão automaticamente para o grupo "Nenhum"?',function(btn1){
                    if(btn1=="yes"){
                          store = grid.getStore(); 
                        record = store.getAt(rowIndex);        
                        store.remove(record);
                        grid.getStore().sync({
                            success:function(){
                                grid.getStore().load();     
                            },
                            failure:function(){
                                 grid.getStore().load();     

                            }
                        });
                        
                    }
                });             
                    }
                }]
            },
      
        ],      
       tbar:[{
            text:'Cadastrar',
            itemId:'btnCadastrarDirecionamento',
            iconCls:'icone_add',        
            },  
             {xtype:'tbseparator'},
            
            {text:'Imprimir',
            action:'print',
            iconCls:'icone_impressora'
            },
            {xtype:'tbseparator'}],
        
        
});