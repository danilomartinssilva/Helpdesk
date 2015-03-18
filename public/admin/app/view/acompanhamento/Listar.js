Ext.define('Admin.view.acompanhamento.Listar',{
	extend:'Ext.grid.Panel',
    title: 'Detalhe de solicitação',
    xtype:'lisaco',
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Acompanhamentos',
    initComponent:function()
    {
        this.dockedItems= [{
              xtype:'pagingtoolbar',
              store:'Acompanhamentos',
              dock:'bottom',
              displayinfo:true
           
        }];
        this.callParent();
    },
    
    columns: [
       // { header: 'Id',  dataIndex: 'id_cadcli' ,width:30},
        { header: 'Id', dataIndex: 'id_cadaco', width:40},  
        {header:'Ator',flex:1,renderer:function(value,metaData,record){        
            //console.log(record.responsaveis());
            var descricao='';
            record.atendentes().each(function(item,index,count){
                        descricao = item.get('descricao_atendente');
            });
                return(descricao);
        }},      
        
         {header:'Departamento',flex:1,renderer:function(value,metaData,record){        
            //console.log(record.responsaveis());
            var descricao='';
            record.departamentos().each(function(item,index,count){
                        descricao = item.get('desc_caddep');
            });
                return(descricao);
        }},
         {header:'Nivel',flex:1,renderer:function(value,metaData,record){        
            //console.log(record.responsaveis());
            var descricao='';
            record.perfils().each(function(item,index,count){
                        descricao = item.get('desc_cadper');
            });
                return(descricao);
        }},
         {header:'Histórico',flex:1,dataIndex:'desc_cadaco'},
         {header:'Atualização',flex:1,dataIndex:'atualizacao_cadaco'},
          {header:'Situação',flex:1,renderer:function(value,metaData,record){        
            if(record.get('cd_cadsta')==1){
                return "Aberto";
            }
            else if(record.get('cd_cadsta')==2){
                return "Processando";
            }
            else if(record.get('cd_cadsta')==3){
                return "Aguardando";
            }
            else if(record.get('cd_cadsta')==4){
                return "Fechado";
            }
            else if(record.get('cd_cadsta')==5){
                return "Concluído";
            }


        }},
       
        {
            xtype:'actioncolumn',
            header:'Excluir',
            items:[{
                iconCls:'icone_excluir',
                handler:function(grid,rowIndex,colIndex){
                    var store = grid.getStore();
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
        }],  
        emptyText: 'Não existem registros á serem visualizados',    
       tbar:[ 
             
            {text:'Imprimir',
            action:'print',
            iconCls:'icone_impressora'
            },
            {xtype:'tbseparator'},
            
            {xtype:'tbseparator'}],

});