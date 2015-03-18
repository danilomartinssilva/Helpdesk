Ext.define('Admin.controller.Departamento', {
    extend: 'Ext.app.Controller',
    model:['Departamento'],
    stores:['Departamentos'],
    views:['departamento.Listar','departamento.Cadastrar'],
    refs:[{
    	ref:'lisdep',selector:'lisdep'
    },{
    	ref:'caddep',selector:'caddep'
    }],
    	init:function(){

				this.control({
					'lisdep':{
						render:this.CarregarGrid,
						itemdblclick:this.PopularFormulario,
					},
					'lisdep #btnCadastrarDepartamento':{
							click:this.AbrirCadastroDepartamento
						},
					'caddep #btnSalvarCadastro':{
						click:this.SalvarCadastroDepartamento
					},
					'caddep #desc_caddep':{
						beforerender:this.LimparMensagensValidacao,
						blur:this.ValidacaoRemotaTextField
					}
					
				});
		},
    	ValidacaoRemotaTextField:function(textfield,opt){
						var valorId = Ext.ComponentQuery.query('#id_caddep');    				
		                var id = valorId[valorId.length-1].value;
		                     if(id==null || id=="" || id==undefined){                         
		                        Ext.Ajax.request({
		                        url: endereco+'admin/departamento/validateremote',
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
		                        url: endereco+'admin/departamento/validateremote',
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
		LimparMensagensValidacao:function(me,opt){
			me.clearInvalid();
		    me.textValid = true;
		},
		AbrirCadastroDepartamento:function(btn,e,opt){
						this.AbrirJanela();
		},
		CarregarGrid:function(grid,eopts){
				grid.getStore().load();

		},
		PopularFormulario:function( grid, record, item, index, e, eOpts){
			  var win = this.AbrirJanela();	  
			  var form = win.down('form');
			  form.loadRecord(record);
			  
		},
		SalvarCadastroDepartamento:function(btn,e,Eopt){
			  var  form = btn.up('form');
			  var values = form.getValues();
			  var record = form.getRecord();
			  console.log(record);
			  var grid = Ext.ComponentQuery.query('lisdep');
			  var win = btn.up('window');
			  var novo = false; 

			  if(form.getForm().isValid()){	  
				if(values.id_caddep>0){					
			  	record.set(values);			  	
			  	novo = true;			  	
			  	}
			  else{
			  	record = Ext.create('Admin.model.Departamento');
			  	record.set(values);			  	
			  	novo = true;
			  	}
			  this.getDepartamentosStore().add(record);
			  win.close();

			  this.getDepartamentosStore().sync({
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
		AbrirJanela:function(){
			var component = Ext.widget('caddep');
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

});
