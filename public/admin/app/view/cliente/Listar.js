Ext.define('Admin.view.cliente.Listar', {
    extend:'Ext.grid.Panel',
    title: 'Lista de Clientes',
    xtype:'liscli',
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Clientes',
    initComponent:function()
    {
        this.dockedItems= [{
              xtype:'pagingtoolbar',
              store:'Clientes',
              dock:'bottom',
              displayinfo:true
            
        }];
        this.callParent();
    },
    
    columns: [
       // { header: 'Id',  dataIndex: 'id_cadcli' ,width:30},
        { header: 'Id', dataIndex: 'id_cadcli', width:40},
        { header:'Nome',dataIndex:'desc_cadcli',flex:1},
        { header:'Status',dataIndex:'status_cadcli',width:80,
        renderer:function(value,metaData,record){
            if(record.get('status_cadcli')){
                return "Ativo";
            }
            else{
                return "Bloqueado";
            }
        }}  ,
        {header:'Função',dataIndex:'funcao_cadcli',flex:1},

       {header:'Departamento Responsável',flex:1,renderer:function(value,metaData,record){        
            //console.log(record.responsaveis());
            var descricao='';
            record.departamentos().each(function(item,index,count){
                        descricao = item.get('desc_caddep');
            });
                return(descricao);
        }},
         {header:'Grupo',flex:1,renderer:function(value,metaData,record){        
            //console.log(record.responsaveis());
            var descricao='';
            record.direcionamentos().each(function(item,index,count){
                        descricao = item.get('descricao_caddir');
            });
                return(descricao);
        }},
        {header:'Nível',flex:1, hidden:true,renderer:function(value,metaData,record){
          var descricao='';
            record.perfils().each(function(item,index,count){
                        descricao = item.get('desc_cadper');
            });
                return(descricao);
            
        }},

        {
            xtype:'actioncolumn',
            header:'Excluir',
            items:[{
                iconCls:'icone_excluir',
                handler:function(grid,rowIndex,colIndex){
                    var store = grid.getStore();
                    store.proxy.writer.writeAllFields = true;
                    var records = grid.getStore().getAt(rowIndex);
            Ext.MessageBox.confirm('Warning!','Voce tem certeza que deseja excluir o registro selecionado?',function(btn1){
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
            itemId:'btnCadastrarDepartamento',
            iconCls:'icone_add',        
            },  
            {xtype:'tbseparator'},
            {text:'Imprimir',
            iconCls:'icone_impressora',
            href: endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=relUsuarios.xml&target_format=HTML',
            target: '_blank',
            },
            {xtype:'tbseparator'},
           ],
        
        
});