Ext.define('Admin.view.basedeconhecimento.Listar', {
	extend:'Ext.grid.Panel',

	xtype:'lisbase',
    title: 'Lista de Artigos',    
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Basedeconhecimentos',
    emptyText:'Sem artigos cadastrados',
    initComponent:function()
    {
    	this.dockedItems= [{
			  xtype:'pagingtoolbar',
			  store:'Basedeconhecimentos',
			  dock:'bottom',
			  displayinfo:true,

			}];
        this.callParent();
    },
    
    columns: [
       // { header: 'Id',  dataIndex: 'id_cadcli' ,width:30},
        { header: 'Id', dataIndex: 'id_cadbase', width:40},
        
        {header:'Autor:',dataIndex:'autor_cadbase',flex:1},

        {header:'Data de criação:',dataIndex:'atualizacao_cadbase',flex:1,renderer:function(value,record,metaData){
        	var newDate = new Date (value);
        	var newDateFormat= Ext.Date.format(newDate,'d-m-Y');
        	return newDateFormat;
        }},

      	{ header:'Titulo',dataIndex:'titulo_cadbase',flex:1},
      	{header:'Texto',dataIndex:'texto_cadbase',flex:1,hidden:true,disabled:true},

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
        },
        {
        	xtype:'actioncolumn',
        	header:'Ver',
        	items:[{
        		iconCls:'icone_lupa',
        		handler:function(grid,rowIndex,colIndex){
        		 		var store = grid.getStore();
                         record = store.getAt(rowIndex);
                         var id_artigo = record.get('id_cadbase');
                         var texto = record.get('texto_cadbase');
                         var titulo = record.get('titulo_cadbase');
                         var mainPanel = Ext.ComponentQuery.query('appmain');                    
                         var title = "Base de conhecimento -"+id_artigo;
                         var newTab = mainPanel[0].getComponent('conteudo').items.findBy(
                         function (tab){ 
                
                           return tab.title === title; 

                        });

                        if(!newTab){
                         newTab = mainPanel[0].getComponent('conteudo').add({
                        xtype:'verbase',
                        closable:true,
                        iconCls:'icone_lupa',
                        
                     	html:texto,
                        title:title
                             });
                        } 
                        mainPanel[0].getComponent('conteudo').setActiveTab(newTab);



        		}
        	}]
        },
        ],      
       tbar:[		
       {
       xtype:'textfield',       
       itemId:'txPesquisar',
       emptyText:'Pesquisar por título...'
       },
       {
        xtype:'button',
        iconCls:'icone_lupa',
        itemId:'btnPesquisar'
       },
			
			{text:'Imprimir',
			action:'print',
			iconCls:'icone_impressora',      
			href:endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=reldepartamentos.xml&target_format=HTML'
			}],
	    
	    
});