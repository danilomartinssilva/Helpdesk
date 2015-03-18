	Ext.define('Admin.controller.Direcionamento', {
	    extend: 'Ext.app.Controller',
	    stores:['Direcionamentos'],
	    model:['Direcionamento'],
	    views:['direcionamento.Listar','direcionamento.Cadastrar'],
	    refs:[{
	    	ref:'lisdir',
	    	selector:'lisdir'
	    },{
	    	ref:'caddir',
	    	selector:'caddir'
	    }],
	    init:function(){
	    	this.control({
	    		'lisdir':{
	    			render:this.CarregarGrid
	    		},
	    		'caddir #btnSalvarCadastroDirecionamento':{
					click:this.SalvarDirecionamento
				},
				'lisdir #btnCadastrarDirecionamento':{
					click:this.CadastrarDirecionamento
				},
				'caddir #descricao_caddir':{
					beforerender:this.LimparMensagensValidacao,
					blur:this.ValidacaoRemotaTextField,
				}

	    	})
	    },
	    CarregarGrid:function(grid,e,eopts){
	    	grid.getStore().load();
	    },
	    CadastrarDirecionamento:function(btn,e,opt){
			this.AbrirJanelaCadastroDirecionamento();
		},
		AbrirJanelaCadastroDirecionamento:function(){

			var component = Ext.create('Admin.view.direcionamento.Cadastrar');
						if(!win){
							var win = Ext.create('Ext.window.Window',{
								title:'Cadstro de departamento',
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
		CarregarComboServicos:function(me,opts){

			var store = Ext.create('Admin.store.Servicos');
			var myFilter = [{property:'parent_cadser',value:1,operator:'=',id:'servico'}];
			store.getProxy().setExtraParam('filter' , Ext.JSON.encode(myFilter) ); 
			me.store = store;
		},
		CarregarComboAtendente:function(me,opts){
			var store = Ext.create('Admin.store.Clientes');
			var myFilter = [{property:'cd_cadper',value:2,operator:'=',id:'cliente'}];
			store.getProxy().setExtraParam('filter' , Ext.JSON.encode(myFilter) ); 
			me.store = store;

		},
		SalvarDirecionamento:function(btn,e,opt){		
		  var  form = btn.up('form');
		  var values = form.getValues();
		  var record = form.getRecord();
		  var grid = Ext.ComponentQuery.query('lisdir');
		  var win = btn.up('window');
		  var novo = false; 

		  if(form.getForm().isValid()){	  	
			if(values.id_caddir>0){
		  	record.set(values);
		  	novo = true;
		  	}
			else{
		  	record = Ext.create('Admin.model.Direcionamento');
		  	record.set(values);
		  	this.getDirecionamentosStore().add(record);
		  	novo = true;
			}
		  win.close();

		  this.getDirecionamentosStore().sync({
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
		LimparMensagensValidacao:function(me,opt){
				me.clearInvalid();
			    me.textValid = true;
		},
			ValidacaoRemotaTextField:function(textfield,opt){
						var valorId = Ext.ComponentQuery.query('#id_caddir');    				
		                var id = valorId[valorId.length-1].value;
		                     if(id==null || id=="" || id==undefined){                         
		                        Ext.Ajax.request({
		                        url: endereco+'admin/direcionamento/validateremote',
		                        params: {
		                            field:textfield.name,value:textfield.value
		                        },
		                        success: function(response){
		                            //var result = response.responseText;
		                             var result = Ext.JSON.decode(response.responseText, true);
		                            if (result.success==true){
		                             textfield.clearInvalid();
		                             textfield.textValid = true;
		                             } 
		                             else {
		                            textfield.markInvalid('Este registro está duplicado. Tente novamente!');
		                            textfield.textValid = false;                
		                             }                         
		                        }
		                    });
		                }
		                else{
		                        Ext.Ajax.request({
		                        url: endereco+'admin/direcionamento/validateremote',
		                        params: {
		                            field:textfield.name,value:textfield.value,idcampo:id
		                        },
		                        success: function(response){
		                            //var result = response.responseText;
		                             var result = Ext.JSON.decode(response.responseText, true);
		                            if (result.success==true){
		                             textfield.clearInvalid();
		                             textfield.textValid = true;
		                             //console.log('nao e igual');
		                             } 
		                             else {
		                            textfield.markInvalid('Este registro está duplicado. Tente novamente!');
		                            textfield.textValid = false;                
		                             } 
		                        
		                        }
		                    });
		                }
		              
		},



	});
