Ext.define("Tecnico.view.solicitacao.Listar", {
	extend:'Ext.grid.Panel',
	xtype:'lissol', 
    closable:true,
    store:'Solicitacaos',
    emptyText:'Não existe solicitações cadastradas.',

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
                    itemId:'statusVisualizacaoSolicitacoes',
                    store:Ext.create('Tecnico.store.Statuss'),
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
        columns:[

        { header: 'Id', dataIndex: 'id_cadsol', width:40},
        {header:'Direcionamento',flex:1,renderer:function(value,metaData,record){
                  var descricao='';
                    record.direcionamentos().each(function(item,index,count){                        
                                descricao = item.get('descricao_caddir');
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

         {header:'Cliente',flex:1,renderer:function(value,metaData,record){
              var descricao='';
                record.clientes().each(function(item,index,count){                        
                            descricao = item.get('desc_cadcli');
                });
                   
                    return(descricao);
                
            }},

         {header:'Departamento',flex:1,renderer:function(value,metaData,record){
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
            
         {header:'Atendimento',flex:1,dataIndex:'atendente'},
          {
                xtype:'actioncolumn',
                header:'Atualizar',
                
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
            },
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
                             console.log(mainPanel);
                             var newTab = mainPanel[0].getComponent('conteudo').items.findBy(
                             function (tab){ 
                    
                               return tab.title === title; 

                            });

                            if(!newTab){
                             newTab = mainPanel[0].getComponent('conteudo').add({
                            xtype:'lisaco',
                            closable:true,
                            iconCls:'icone_lupa',
                            store:Ext.create('Tecnico.store.Acompanhamentos',{
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
                    xtype:'tbspacer',
                    width:750,      
                    },
                    {text:'Imprimir',
                    action:'print',
                    iconCls:'icone_impressora', 
                    href:endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=relsolicitacaoestotecnico.xml&target_format=HTML&caddir='+direcionamento,
                    },

                    {xtype:'tbseparator'},
                   
                    ],

   // title: 'Lista de Solicitações',
   // store:'Solicitacaos',
   // emptyText:"Sem solicitações para exibir",
    
    

    


	//



});