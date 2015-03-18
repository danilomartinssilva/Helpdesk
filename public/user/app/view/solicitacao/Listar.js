Ext.define('User.view.solicitacao.Listar',{   
    extend:'Ext.grid.Panel',
    title: 'Solicitações',
    xtype:'lissol',
    //selModel:{mode:'MULTI'},
    closable:true,    
    store:'Solicitacaos',
    emptyText:'Sem solicitações abertas  para exibir',
    initComponent:function()
    {
        this.dockedItems= [{
              xtype:'pagingtoolbar',
              store:'Solicitacaos',
              dock:'bottom',
              displayinfo:true
            },{
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {itemId:'txPesquisar', xtype: 'textfield',name:'pesquisar',emptyText:'Pesquisar'},
                {itemId:'btnPesquisar',xtype:'button',name:'btnPesquisar',iconCls:'icone_lupa', action:'search'},
                {itemId:'btnAtualizar',xtype:'button',name:'btnAtualizar',iconCls:'icone_refresh', action:'refresh',text:'Atualizar'},
                { 
                emptyText:'Buscar por status',    
                xtype:"combobox",
                itemId:'statusVisualizacaoSolicitacoes',
                store:'Statuss',
                valueField:'id_cadsta',
                displayField:'desc_cadsta',
                queryMode:'local',
                },
                {
                text:'Limpar Filtro',
                action:'clear',
                iconCls:'icone_limpar', 
                itemId:'limparFiltro',
                }
            ]
        }];
        this.callParent();
    },
    
    columns: [
       // { header: 'Id',  dataIndex: 'id_cadcli' ,width:30},
        { header: 'Id', dataIndex: 'id_cadsol', width:40},

       /* {header:'Solicitante',flex:1,renderer:function(value,metaData,record){
          var descricao='';
            record.clientes().each(function(item,index,count){                        
                        descricao = item.get('desc_cadcli');
            });
                return(descricao);
            
        }},
        */
    
         {header:'Situação',flex:1,renderer:function(value,metaData,record){
          var descricao='';
            record.statuss().each(function(item,index,count){    
                        //console.log(item.get('id_cadsta'));
                        if(item.get('id_cadsta')==1){
                        descricao = '<b><font color="red">'+item.get('desc_cadsta')+'</font></b>';
                        }                    
                        else if(item.get('id_cadsta')==2){
                        descricao = '<b><font color="orange">'+item.get('desc_cadsta')+'</font></b>';    
                        }
                        else  if(item.get('id_cadsta')==3){
                        descricao = '<b><font color="orange">'+item.get('desc_cadsta')+'</font></b>';  
                        }
                        else  if(item.get('id_cadsta')==4){
                        descricao = '<b><font color="green">'+item.get('desc_cadsta')+'</font></b>';    
                        }
                        else  {
                         descricao = '<b><font color="orange">'+item.get('desc_cadsta')+'</font></b>';       
                        }
                       
            });
           return   descricao;
            
        }},
          {header:'Categoria',flex:1,renderer:function(value,metaData,record){
          var descricao='';
            record.servicos().each(function(item,index,count){                        
                        descricao = item.get('desc_cadser');
            });
               
                return(descricao);
            
        }},

        {header:'Prioridade',flex:1,renderer:function(value,metaData,record){
          var descricao='';
            record.prioridades().each(function(item,index,count){                        
                        descricao = item.get('desc_cadpri');
            });
                return(descricao);
            
        }},
    


        {header:'Data de criação',flex:1,dataIndex:'data_cadsol',renderer:function(value,metaData,record){

                var myDate = new Date(record.get('data_cadsol'));
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

        
        
        {
                xtype:'actioncolumn',
                header:'Detalhar solicitação',
                items:[{
                iconCls:'icone_lupa',                 
                handler:function(grid,rowIndex,collIndex){
                     var store = grid.getStore();
                     record = store.getAt(rowIndex);
                     var idSolicitacao = record.get('id_cadsol');
                     var mainPanel = Ext.ComponentQuery.query('appmain');                    
                     var title = "Detalhe da solicitação: "+idSolicitacao;
                     var newTab = mainPanel[0].getComponent('conteudo').items.findBy(
                     function (tab){ 
            
                       return tab.title === title; 

                    });

                    if(!newTab){
                     newTab = mainPanel[0].getComponent('conteudo').add({
                    xtype:'lisaco',
                    closable:true,
                    iconCls:'icone_lupa',
                    store:Ext.create('User.store.Acompanhamentos',{
                            autoLoad:true,
                            remoteSort:true,
                            remoteFilter:true,
                            filters: [
                            {property:'cadsol.id_cadsol',value:idSolicitacao}
                            ],


                    }),
                    title:title
                         });
                    } 
                    mainPanel[0].getComponent('conteudo').setActiveTab(newTab);
                }
             }]
            },
            {
            xtype:'actioncolumn',
            header:'Enviar um feedback',
            items:[{
                iconCls:'icone_impressora',
                handler:function(grid,rowIndex,collIndex){
                var component = Ext.widget('cadaco');
                var store = grid.getStore();
                if(!win){
                var win = Ext.create('Ext.window.Window',{
                    title:'Atualizar solicitação',
                    autoHeigth:true,
                    width:450,
                    modal:true,
                    closable:true,
                    layout:'fit',
                });
                win.add(component);
                win.doLayout();
                win.show();
                }else{
                    win.show();
                }
               
                var form = win.down('form') ;
                record = store.getAt(rowIndex);
                form.getForm().findField('cd_cadsol').setValue(record.get('id_cadsol'));
                form.loadRecord(record);
                form.getForm().findField('cd_cadcli').setValue(idUsuario);
                form.getForm().findField('cd_cadsta').setValue(record.get('cd_cadsta'));
                }

            }]

            }
        ], 
        plugins: [{
            ptype: 'rowexpander',
            rowBodyTpl : new Ext.XTemplate(
                '<p><b>Tipo de Serviço: </b>{desc_cadser}</p> ',
                '<p><b>Descrição: </b>{desc_cadsol}</p> ',    
            {
                
            })
        }],   
       tbar:[{
            text:'Cadastrar',
            itemId:'btnCadastrarSolicitacao',
            iconCls:'icone_add',        
            },  
             {xtype:'tbseparator'},
            {
            text:'Excluir',
            action:'excluir',
            ItemId:'btn_Excluir',
            iconCls:'icone_excluir',        
            },            
            {
            xtype:'tbspacer',
            width:750,      
            },
            
           
           
            ],



})