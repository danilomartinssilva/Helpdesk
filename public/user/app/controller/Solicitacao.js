	Ext.define('User.controller.Solicitacao', {
	    extend: 'Ext.app.Controller',
	    views:['solicitacao.Listar','solicitacao.Cadastrar'],
	    stores:['Solicitacaos'],
	    Model:['Solicitacao'],
	    refs:[{
	    	ref:'cadsol',
	    	selector:'cadsol'
	    },{
	    	ref:'lissol',
	    	selector:'lissol'
	    }],
	    init:function(){
	    	this.control({
			'lissol':{
			render:this.CarregarGridSolicitacoes,
			itemdblclick:this.AbrirAbaDetalhesSolicitacao,
			
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
			},
			

	    	})
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
			  		record = Ext.create('User.model.Solicitacao');
			  		record.set(values);
			  		
			  		novo = true;
			  	}
			this.getSolicitacaosStore().add(record);
			  	 Ext.MessageBox.show({
		                    title: 'Notificando Departamento de Tecnologia',
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
	CarregarGridSolicitacoes:function(grid,eOpts){
		var store = grid.getStore();
		//var myFilter = [{property:'cd_cadsta',value:4,operator:'<',id:'status'}];
		//store.getProxy().setExtraParam('filter' , Ext.JSON.encode(myFilter) ); 
		//store.filter(myFilter);
		grid.getStore().load();

	},
	AbrirJanelaCadastrarSolicitacao:function(me,e,opt){
		this.AbrirJanela();

	},

	AbrirJanela:function(){	
		var component = Ext.create('User.view.solicitacao.Cadastrar');
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
					//	win.doLayout();
						win.show();
					}

					return win;

	},


	});
