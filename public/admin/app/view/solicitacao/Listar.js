    Ext.define('Admin.view.solicitacao.Listar',{   
        extend:'Ext.grid.Panel',
        xtype:'lissol',
        title: 'Solicitações',    
        //selModel:{mode:'MULTI'},
        closable:true,    
        store:'Solicitacaos',
        emptyText:'Não existem solicitações para serem exibidas',
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
                   
                    { 
                    emptyText:'Buscar por status',    
                    xtype:"combobox",
                    allowBlank:true,
                    itemId:'statusVisualizacaoSolicitacoes',
                    store:Ext.create('Admin.store.Statuss'),
                    valueField:'id_cadsta',
                    displayField:'desc_cadsta',
                    queryMode:'local'
                    },
                    {
                    xtype: 'datefield',
                    emptyText:"Buscar por data de:",
                    anchor: '100%',                    
                    itemId: 'from_date',
                    maxValue: new Date(),
                    format:'d/m/Y'
                    },
                    {
                    xtype: 'datefield',
                    emptyText:"Até:",
                    anchor: '100%',                    
                    itemId: 'to_date',
                    maxValue: new Date(),
                    format:'d/m/Y'
                    },
                     {
                    text:'Filtrar',
                    action:'clear',
                    iconCls:'icone_refresh', 
                    itemId:'buscarFiltroPeriodo',
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

            {header:'Solicitante',flex:1,renderer:function(value,metaData,record){
              var descricao='';
                record.clientes().each(function(item,index,count){                        
                            descricao = item.get('desc_cadcli');
                });
                    return(descricao);
                
            }},


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
              {header:'Categoria',flex:1,hidden:true,renderer:function(value,metaData,record){
              var descricao='';
                record.servicos().each(function(item,index,count){                        
                            descricao = item.get('desc_cadser');
                });
                   
                    return(descricao);
                
            }},
             {header:'Direcionado à',flex:1,renderer:function(value,metaData,record){
              var descricao='';
                record.direcionamentos().each(function(item,index,count){                        
                            descricao = item.get('descricao_caddir');
                });
                    return(descricao);
                
            }},
            {header:'Atendimento',flex:1,dataIndex:'atendente'},

            {header:'Prioridade',flex:1,renderer:function(value,metaData,record){
              var descricao='';
                record.prioridades().each(function(item,index,count){                        
                            descricao = item.get('desc_cadpri');
                });
                    return(descricao);
                
            }},
        
            {header:'Departamento',hidden:true,flex:1,renderer:function(value,metaData,record){
              var descricao='';
                record.departamentos().each(function(item,index,count){                        
                            descricao = item.get('desc_caddep');
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
                header:'Atualizar',
                hidden:true,
                items:[{
                    iconCls:'icone_refresh',
                    handler:function(grid,rowIndex,colIndex){
                        var store = grid.getStore();
                        var records = grid.getStore().getAt(rowIndex);                    
                        var component = Ext.widget('cadaco');
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
                        form.getForm().findField('cd_cadsol').setValue(records.get('id_cadsol'));
                        form.loadRecord(records);
                        form.getForm().findField('cd_cadcli').setValue(idUsuario); 
                        
                    }
                }]
            },{
                header:'Prazo Final',
                dataIndex:'tempo_execucao',
                
                flex:1,
                
            },
            {
                header:'Tempo gasto',
                dataIndex:'tempo_gasto',            
                flex:1,
                

            },
            {
                xtype:'actioncolumn',
                header:'Excluir',
                hidden:true,
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
                    header:'Detalhar solicitação',
                    hidden:true,
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
                        store:Ext.create('Admin.store.Acompanhamentos',{
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
                }
            ], 
              plugins: [{
                ptype: 'rowexpander',
                rowBodyTpl: [
                    '<tpl for="servicos">',
                    '<p>Categoria de Servico: {desc_cadser}</p>',
                    '</tpl>',
                     '<p>Descrição: <strong>{desc_cadsol}</strong></p>'   

                ]
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
                {text:'Imprimir',
                action:'print',              
                iconCls:'icone_impressora',
                itemId:'btnImprimirSolicitacao'
                },

                {xtype:'tbseparator'},
                {
                    text:'Gráficos',
                    action:'clear',
                    iconCls:'icone_grafico',    
                    itemId:'abrirWindowGrafico',
                },
               
                ],



    })