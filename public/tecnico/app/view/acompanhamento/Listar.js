Ext.define('Tecnico.view.acompanhamento.Listar',{
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
            },{
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {itemId:'txPesquisar', xtype: 'textfield',name:'pesquisar',emptyText:'Pesquisar'},
                {itemId:'btnPesquisar',xtype:'button',name:'btnPesquisar',iconCls:'icone_lupa', action:'search'},
                {itemId:'btnAtualizar',xtype:'button',name:'btnAtualizar',iconCls:'icone_refresh', action:'refresh',text:'Atualizar'},
                
            ]
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
        
         
        
         {header:'Histórico',flex:1,dataIndex:'desc_cadaco'},
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
              {header:'Última Atualização',flex:1,dataIndex:'atualizacao_cadaco',renderer:function(value,metaData,record){

                var myDate = new Date(record.get('atualizacao_cadaco'));
                var formatDate = Ext.Date.format(myDate,'d-M-Y')+" às "+Ext.Date.format(myDate,'H:i');
                var dataAtual = Ext.Date.format(new Date(),'d-m-Y');
                var dataBanco = Ext.Date.format(myDate,'d-m-Y');
                
                if(dataBanco==dataAtual){
                    return "Hoje às "+Ext.Date.format(myDate,'H:i');
                }
                else{
                    return formatDate;
                }

                
        }},
       
      ],  
        emptyText: 'Não existem registros á serem visualizados',    
       tbar:[
            {
            
            text:'Imprimir',
            action:'print',
            iconCls:'icone_impressora'
            },
            {xtype:'tbseparator'},
            {
                hidden:true,
                text:'Gráficos',
                action:'clear',
                iconCls:'icone_grafico',    
            },
            {xtype:'tbseparator'},
            {
                text:'Limpar Filtro',
                action:'clear',
                iconCls:'icone_limpar', 
            }],

});