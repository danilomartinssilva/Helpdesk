

Ext.define('Admin.view.servico.Listar', {
	extend:'Ext.grid.Panel',
    title: 'Catálogo de Serviços',
    xtype:'lisser',
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Servicos',
    initComponent:function()
    {
    	this.dockedItems= [{
			  xtype:'pagingtoolbar',
			  store:'Servicos',
			  dock:'bottom',
			  displayinfo:true
			}];
        this.callParent();
    },
    
    columns: [
       // { header: 'Id',  dataIndex: 'id_cadcli' ,width:30},
        { header: 'Id', dataIndex: 'id_cadser', width:40},
        { header:'Descricao',dataIndex:'desc_cadser',flex:1},
         {header:'Categoria',flex:1,renderer:function(value,metaData,record){
       		//console.log(record.responsaveis());
       		var descricao='';
       		record.categorias().each(function(item,index,count){
       					descricao = item.get('descricao');
       		});
       			return(descricao);
        }},
        { header:'Status',dataIndex:'status_cadser',width:80, hidden:true,
        renderer:function(value,metaData,record){
        	if(record.get('status_cadser')){
        		return "Ativo";
        	}
        	else{
        		return "Bloqueado";
        	}
        }}	,


       {header:'Prioridade',flex:1,renderer:function(value,metaData,record){
       		//console.log(record.responsaveis());
       		var descricao='';
       		record.prioridades().each(function(item,index,count){
       					descricao = item.get('desc_cadpri');
       		});
       			return(descricao);
        }},
         {header:'Descrição da Prioridade',flex:1,hidden:true,renderer:function(value,metaData,record){
       		//console.log(record.responsaveis());
       		var descricao='';
       		record.prioridades().each(function(item,index,count){
       					descricao = item.get('componente_cadpri');
       		});
       			return(descricao);
        }},
        {header:'Tempo de Solução',flex:1,hidden:true,renderer:function(value,metaData,record){
       		//console.log(record.responsaveis());
       		var descricao='';
       		record.prioridades().each(function(item,index,count){
       					descricao = item.get('tempo_cadpri');
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
			        		grid.getStore().load()
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
			itemId:'btnCadastrarServico',
			iconCls:'icone_add',		
			},	
			 {xtype:'tbseparator'},
		
		
			{text:'Imprimir',
			action:'print',
			iconCls:'icone_impressora',
      href:endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=relservicos.xml&target_format=HTML',
      itemId:'btnAbrirRelatorioPDF'
			},
			{xtype:'tbseparator'},
			
			
			],
	    
	    
});