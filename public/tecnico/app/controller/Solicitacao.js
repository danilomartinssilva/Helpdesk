  Ext.define('Tecnico.controller.Solicitacao', {
      extend: 'Ext.app.Controller',
      stores:['Solicitacaos'],
      model:['Solicitacao'],
      views:['solicitacao.Listar','solicitacao.Cadastrar'],
      refs:[{
      	ref:'lissol',
      	selector:'lissol'
      },{
        ref:'cadsol',
        selector:'cadsol'
      }],
      init:function(){
        		this.control({
        			'lissol':{
        				render:this.CarregarGrid
        			},
              'lissol #btnCadastrarSolicitacao':{
                click:this.AbrirJanelaCadastrarSolicitacao
              },
              'cadsol #btnSalvarCadastroSolicitacao':{
                click:this.CadastrarSolicitacao
              },
              'lissol #limparFiltro':{
                click:this.LimparFiltro
              } ,
              'lissol #statusVisualizacaoSolicitacoes':{
                change:this.PesquisarPorStatus
              }
             /* 'lissol #abrirWindowGrafico':{
                click:this.AbrirJanelaGrafico
              }*/




        		});

       },
       CarregarGrid:function(grid,e,opts){
       	grid.getStore().load();
       },
       AbrirJanela:function(){  
        var component = Ext.create('Tecnico.view.solicitacao.Cadastrar');
              if(!win){
                var win = Ext.create('Ext.window.Window',{
                  title:'Adicionar solicitação',
                  autoHeight:true,
                  width:450,
                  modal:true,
                  closeAction:'hide',
                  layout:'fit',
                });
                win.add(component);
                win.doLayout();
                win.show();
              }else{
                //win.remove(component,true);
              //  win.doLayout();
                win.show();
              }

              return win;

      },
      AbrirJanelaCadastrarSolicitacao:function(me,e,opt){
        this.AbrirJanela();

      },
        CadastrarSolicitacao:function(btn,e,opt){
        var  form = btn.up('form');
        var values = form.getValues();
        var record = form.getRecord();
        var grid = Ext.ComponentQuery.query('lissol');
        var win = btn.up('window');
        var novo = false;
        var date = new Date();
        var now = Ext.Date.format(date,'Y-m-d H:i:s');
        
        if(form.getForm().isValid()){
          values.data_cadsol = now;
          //values.cd_cadcli = idUsuario;
          
            if(values.id_cadsol>0){
              record.set(values);
              novo = true;
            }
            else
            {
              record = Ext.create('Tecnico.model.Solicitacao');
              record.set(values);
             
              novo = true;
            } 
          this.getSolicitacaosStore().add(record);
             Ext.MessageBox.show({
                        title: 'Enviando email',
                        progressText:'Enviando emails',
                        wait:true,
                        waitConfig:{interval:200},
                        //msg: "Sua operação foi salva com sucesso!",
                        icon: Ext.MessageBox.INFORMATIONAL,
                        //buttons: Ext.Msg.OK
                    }); 
          win.close();
          this.getSolicitacaosStore().sync({
            success:function(){
              if(novo){
                 Ext.MessageBox.show({
                        title: 'Confirmação',
                        msg: "Sua operação foi salva com sucesso!",
                        icon: Ext.MessageBox.INFORMATIONAL,
                        buttons: Ext.Msg.OK
                    }); 
              
              grid[0].getStore().load();
              }
            }


          });
        }

    },
    AbrirJanelaGrafico:function(btn,e,opts){  
                 
                    var component = Ext.create('Tecnico.view.solicitacao.Bar');
                    if(!win){
                    var win = Ext.create('Ext.window.Window',{
                        title:'Gráfico de situação dos chamados',                      
                        autoHeigth:true,
                        width:600,
                        modal:true,
                        closable:true,
                        layout:'fit',
                        tbar: [{
                  xtype:"textfield",
                  //fieldLabel:'teste', 
        }, {
            text: 'Reload Data',
            handler: function() {
                // Add a short delay to prevent fast sequential clicks
                window.loadTask.delay(100, function() {
                    store.loadData(generateData());
                });
            }
        }],
                        
                    });
                    component.store.load();

                    win.add(component);
                    win.doLayout();
                    win.show();
                    }else{
                        win.show();
                    }
                   
                    var form = win.down('form') ;
                    



},
PesquisarPorStatus:function( me, newValue, oldValue, eOpts){
  var grid = Ext.ComponentQuery.query('lissol');
  var store = grid[0].getStore();
  var myFilter = [{property:'cd_cadsta',value:newValue,operator:'=',id:'status'}];
  store.getProxy().setExtraParam('filter' , Ext.JSON.encode(myFilter) ); 
  store.load();
},

LimparFiltro:function(btn,e,opts){
  var grid = Ext.ComponentQuery.query('lissol');
  var store = grid[0].getStore();
  var myFilter = [{property:'id_cadsol',value:0,operator:'>',id:'status'}];
  var comboboxSetarStatus = Ext.ComponentQuery.query('#statusVisualizacaoSolicitacoes');  
  comboboxSetarStatus[0].setemptyText = "Buscar por status";
  
  store.getProxy().setExtraParam('filter' , Ext.JSON.encode(myFilter) ); 
  store.load();
  
},
AbrirAbaDetalhesSolicitacao:function(grid, record, item, index, e, eOpts){
           var store = grid.getStore();
                     //record = store.getAt(rowIndex);
                     var idSolicitacao = record.get('id_cadsol');
                     var mainPanel = Ext.ComponentQuery.query('viewport');                    
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
                    store:Ext.create('SistemaHelpDesk.store.Acompanhamentos',{
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

     



  });
