Ext.define('Admin.view.administracao.Log', {
	extend:'Ext.grid.Panel',
	xtype:'lislog',
    title: 'Log de acessos',    
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Logs',
    initComponent:function()
    {
    	this.dockedItems= [{
			  xtype:'pagingtoolbar',
			  store:'Logs',
			  dock:'bottom',
			  displayinfo:true
			}];
        this.callParent();
    },
    
    columns: [
       // { header: 'Id',  dataIndex: 'id_cadcli' ,width:30},
        
        { header:'Código',dataIndex:'id_cadlog',width:350},
        { header:'Usuário',dataIndex:'usuario',flex:1},
        { header:'Target',dataIndex:'target',flex:1},
        { header:'Ação',dataIndex:'action',flex:1},
        { header:'Data',dataIndex:'date',flex:1,renderer:function(value,record){
        		var newDate = new Date(value);
        		var newDateFormat=(Ext.Date.format(newDate,'d-m-Y'));
        		return newDateFormat;
        		
  				
  			}
  		}
      
        ],      
       tbar:[	
			
			
			{text:'Imprimir',
			action:'print',
			iconCls:'icone_impressora',
			href:endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=relsolicitacoesfrequentes.xml&target_format=HTML'
			}],
	    
	    
});