Ext.define('Admin.view.solicitacao.TempoExecucao', {
	extend:'Ext.grid.Panel',
	xtype:'listempomedio',
    title: 'Tempo médio das Solicitações',    
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'TempoExecucaos',
    initComponent:function()
    {
    	this.dockedItems= [{
			  xtype:'pagingtoolbar',
			  store:'TempoExecucaos',
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
        
        { header:'Atividade',dataIndex:'desc_cadser',width:350},
        { header:'Tempo médio para realização',dataIndex:'tempo_execucao',flex:1}
  
      
        ],      
       tbar:[	
			
			
			{text:'Imprimir',
			action:'print',
			iconCls:'icone_impressora',
			
			href:endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=reltempomediosolicitacao.xml&target_format=HTML'
			},
			
			
			{xtype:'tbseparator'}],
	    
	    
});