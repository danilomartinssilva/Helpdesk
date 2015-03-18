Ext.define('Admin.view.solicitacao.Frequencia', {
	extend:'Ext.grid.Panel',
	xtype:'lissolfrequencia',
    title: 'Solicitações mais Frequentes',    
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Frequencias',
    initComponent:function()
    {
    	this.dockedItems= [{
			  xtype:'pagingtoolbar',
			  store:'Frequencias',
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
        
        { header:'Serviço',dataIndex:'servico',width:350},
        { header:'Quantidade',dataIndex:'quantidade',flex:1}
  
      
        ],      
       tbar:[	
			
			
			{text:'Imprimir',
			action:'print',
			iconCls:'icone_impressora',
			href:endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=relsolicitacoesfrequentes.xml&target_format=HTML'
			},
			{xtype:'tbseparator'},
			{
				text:'Gráficos',
				action:'clear',
				iconCls:'icone_grafico',
				itemId:'btnGraficoFrequencia'

			},
			{xtype:'tbseparator'}],
	    
	    
});