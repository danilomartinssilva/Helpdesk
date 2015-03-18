Ext.define('Admin.view.solicitacao.Ranking', {
	extend:'Ext.grid.Panel',
	xtype:'lisranking',
    title: 'Lista de Departamentos',    
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Rankings',
    initComponent:function()
    {
    	this.dockedItems= [{
			  xtype:'pagingtoolbar',
			  store:'Rankings',
			  dock:'bottom',
			  displayinfo:true
			},{
		    xtype: 'toolbar',
		    dock: 'top',
		    
		}];
        this.callParent();
    },
    
    columns: [
       // { header: 'Id',  dataIndex: 'id_cadcli' ,width:30},
        
        { header:'Usuário',dataIndex:'usuario',width:350},
        { header:'Chamados',dataIndex:'chamados',flex:1}
  
      
        ],      
       tbar:[	
			
			
			{text:'Imprimir',
			action:'print',
			iconCls:'icone_impressora',
			
			href:endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=relrankingsolicitacoes.xml&target_format=HTML'
			},
			{xtype:'tbseparator'},
			{
				text:'Gráficos',
				action:'clear',
				iconCls:'icone_grafico',
				itemId:'btnGraficoRanking'

			},
			{xtype:'tbseparator'}],
	    
	    
});