Ext.define('Admin.view.departamento.Listar', {
	extend:'Ext.grid.Panel',
	xtype:'lisdep',
    title: 'Lista de Departamentos',    
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Departamentos',
    initComponent:function()
    {
    	this.dockedItems= [{
			  xtype:'pagingtoolbar',
			  store:'Departamentos',
			  dock:'bottom',
			  displayinfo:true
			}];
        this.callParent();
    },
    
    columns: [
       // { header: 'Id',  dataIndex: 'id_cadcli' ,width:30},
        { header: 'Id', dataIndex: 'id_caddep', width:40},
        { header:'Descricao',dataIndex:'desc_caddep',flex:1},
        { header:'Status',dataIndex:'status_caddep',width:80,
        renderer:function(value,metaData,record){
        	if(record.get('status_caddep')){
        		return "Ativo";
        	}
        	else{
        		return "Bloqueado";
        	}
        }}	,
        {header:'Responsável',dataIndex:'responsavel_caddep',flex:1},
       {header:'Departamento Responsável',flex:1,renderer:function(value,metaData,record){
       		//console.log(record.responsaveis());
       		var descricao='';
       		record.responsaveis().each(function(item,index,count){
       					descricao = item.get('descricao');
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
					store.proxy.writer.writeAllFields = true;
			        record = store.getAt(rowIndex);        
			        console.log(store);

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
			itemId:'btnCadastrarDepartamento',
			iconCls:'icone_add',		
			},	
			 {xtype:'tbseparator'},
			
			
			{text:'Imprimir',
			action:'print',
			iconCls:'icone_impressora',
			href:endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=reldepartamento.xml&target_format=HTML'
			},
			{xtype:'tbseparator'},			
		],
	    
	    
});