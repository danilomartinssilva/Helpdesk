		Ext.define('Admin.controller.Solicitacao',{
		extend:'Ext.app.Controller',
		models:['Solicitacao'],
		stores:['Solicitacaos','Rankings'],
		views:['solicitacao.Listar','solicitacao.Cadastrar','solicitacao.Ranking','solicitacao.Frequencia','solicitacao.TempoExecucao'],
		refs:[
		{ref:'lissol',selector:'lissol'},
		{ref:'cadsol',selector:'cadsol'},
		{ref:'lisranking',selector:'lisranking'},
		{ref:'lissolfrequencia',selector:'lissolfrequencia'},
		{ref:'listempomedio',selector:'listempomedio'}
		],
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
				'lissol #abrirWindowGrafico':{
					click:this.AbrirJanelaGrafico
				},
				'lissol #btnAbrirRelatorioPDF':{
				},
				'lissol #buscarFiltroPeriodo':{
					click:this.buscarFiltroPeriodo
				},
				'lissol #btnImprimirSolicitacao':{
					click:this.ImprimirSolicitacao
				},
				'lisranking #btnGraficoRanking':{
					click:this.AbrirJanelaGraficoRanking
				},
				'lissolfrequencia #btnGraficoFrequencia':{
					click:this.AbrirJanelaGraficoFrequencia
				},
				

			})
		},
		AbrirJanelaGraficoFrequencia:function(btn,e,opts){
				var component = Ext.create('Admin.view.solicitacao.Barfrequencia');
		                    if(!win){
		                    var win = Ext.create('Ext.window.Window',{
		                        title:'Grafico com as solicitações mais frequentes',                      
		                        autoHeigth:true,
		                        width:600,
		                        modal:true,
		                        closable:true,
		                        layout:'fit',
		                        tbar: [{
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
		},
		AbrirJanelaGraficoRanking:function(btn,e,opts){
				var component = Ext.ComponentQuery.query('lissolbar');
				//console.log(component);
				
				var component = Ext.create('Admin.view.solicitacao.Bar');
		                    if(!win){
		                    var win = Ext.create('Ext.window.Window',{
		                        title:'Lista de usuários com mais solicitações',                      
		                        autoHeigth:true,
		                        width:600,
		                        modal:true,
		                        closable:true,
		                        layout:'fit',
		                        tbar: [{
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
		                   
		                    
		 



		},
		ImprimirSolicitacao:function(btn,e,opts){

		var datefrom = Ext.ComponentQuery.query('lissol #from_date')[0].value;
		var dateto =  Ext.ComponentQuery.query('lissol #to_date')[0].value;

		var comboboxSetarStatus = Ext.ComponentQuery.query('#statusVisualizacaoSolicitacoes');	
		
		var url = endereco+'reportico/run.php?execute_mode=EXECUTE&project=HelpDesk&xmlin=relsolicitacoes.xml&target_format=HTML';
		if(datefrom!=null && dateto!=null){
			var formatDateFrom = Ext.Date.format(new Date(datefrom),'d/m/Y');
			var formatDateTo = Ext.Date.format(new Date(dateto),'d/m/Y');
			url += "&MANUAL_daterange_FROMDATE="+formatDateFrom+"&MANUAL_daterange_TODATE="+formatDateTo;
		}
		
		else{
			url+="&MANUAL_daterange_FROMDATE=01/06/2014&MANUAL_daterange_TODATE=31/12/2099&status=4";
		}

		if(comboboxSetarStatus[0].value>0){
			url+="&status="+comboboxSetarStatus[0].value;
		}
		else{

			url+="&status=0";
		}

		window.open(url);


		},
		buscarFiltroPeriodo:function(btn,e,opts){
			
			var datefrom = Ext.ComponentQuery.query('lissol #from_date')[0].value;
			var dateto =  Ext.ComponentQuery.query('lissol #to_date')[0].value;
			//console.log(Ext.ComponentQuery.query('lissol #to_date'));
			var grid = Ext.ComponentQuery.query('lissol');
			var store = grid[0].getStore();


			if(datefrom!="" && dateto!=""){	
			var formatDateFrom = Ext.Date.format(new Date(datefrom),'Y-m-d');		
			var formatDateTo =  Ext.Date.format(new Date(dateto),'Y-m-d');		

			var myFilter = [{property:'data_cadsol',from:formatDateFrom,to:formatDateTo,id:'buscaPorPeriodo'}];
			store.getProxy().setExtraParam('filter' , Ext.JSON.encode(myFilter) ); 
			store.load();
			}


			
		},
		btnAbrirRelatorioPDF:function(btn,e,eopts){
			window.open('/helpdesk/admin/servicos/gerarpdf');
		},
		AbrirJanelaGrafico:function(btn,e,opts){	
		                 
		                    var component = Ext.create('Admin.view.solicitacao.Bar');
		                    if(!win){
		                    var win = Ext.create('Ext.window.Window',{
		                        title:'Gráfico de situação dos chamados',                      
		                        autoHeigth:true,
		                        width:600,
		                        modal:true,
		                        closable:true,
		                        layout:'fit',
		                        tbar: [{
		           				xtype:"textfield"
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
			var datefrom = Ext.ComponentQuery.query("lissol #from_date")[0];		
			var dateto = Ext.ComponentQuery.query("lissol #to_date")[0];
			var grid = Ext.ComponentQuery.query('lissol');
			var store = grid[0].getStore();
			var myFilter = [{property:'id_cadsol',value:0,operator:'>',id:'status'}];
			var comboboxSetarStatus = Ext.ComponentQuery.query('#statusVisualizacaoSolicitacoes');	      	
			store.getProxy().setExtraParam('filter' , Ext.JSON.encode(myFilter) ); 
			store.load();
			comboboxSetarStatus[0].reset();
			datefrom.reset();
			dateto.reset();
		},


		AbrirAbaDetalhesSolicitacao:function(grid, record, item, index, e, eOpts){
				 			var store = grid.getStore();                    
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
		                    form.getForm().findField('cd_cadsol').setValue(record.get('id_cadsol'));
		                    form.loadRecord(record);
		                    form.getForm().findField('cd_cadcli').setValue(idUsuario); 

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
			  
				  	if(values.id_cadsol>0){
				  		record.set(values);
				  		novo = true;
				  	}
				  	else
				  	{
				  		record = Ext.create('Admin.model.Solicitacao');
				  		record.set(values);
				  		this.getSolicitacaosStore().add(record);
				  		novo = true;
				  	}
			  	win.close();
			  	
			  	 Ext.MessageBox.show({
		                    title: 'Enviando email',
		                    progressText:'Enviando emails',
		                    wait:true,
		                    waitConfig:{interval:200},
		                    //msg: "Sua operação foi salva com sucesso!",
		                    icon: Ext.MessageBox.INFORMATIONAL,
		                    //buttons: Ext.Msg.OK
		                }); 
		        

			  	this.getSolicitacaosStore().sync({
			  		success:function(){
			  			if(novo){
			  				 Ext.MessageBox.show({
		                    title: 'Confirmação',
		                    progressText:'Atualizando....',
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
			var myFilter = [{property:'cd_cadsta',value:4,operator:'<',id:'status'}];
			store.getProxy().setExtraParam('filter' , Ext.JSON.encode(myFilter) ); 
			store.filter(myFilter);
			grid.getStore().load();

		},
		AbrirJanelaCadastrarSolicitacao:function(me,e,opt){		
			this.AbrirJanela();
		},

		AbrirJanela:function(){	
			var component = Ext.create('Admin.view.solicitacao.Cadastrar');
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

		}

		});