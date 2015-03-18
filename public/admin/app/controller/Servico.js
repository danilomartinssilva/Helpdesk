Ext.define('Admin.controller.Servico', {
    extend: 'Ext.app.Controller',
    stores:['Servicos'],
    model:['Servico'],
    views:['servico.Listar','servico.Cadastrar'],
    refs:[{
    	ref:'cadser',
    	selector:'cadser'
    },{
    	ref:'lisser',
    	selector:'lisser'
    }],
    init:function(){
    	this.control({
    		'lisser':{
    			render:this.CarregarGrid,
    			itemdblclick:this.PopularFormulario,

    		},
    		'lisser #btnCadastrarServico':{
				click:this.AbrirJanelaCadastrarServico,
				
				
			},
			"cadser #desc_cadser":{
					beforerender:this.LimparMensagensValidacao,
					blur:this.ValidacaoRemotaTextField
			},
			"cadser #btnSalvarCadastro":{
					click:this.SalvarCadastroServico
			},
			
    	})
    },
    CarregarGrid:function(grid,e,eopts){
    	grid.getStore().load();
    },
    PopularFormulario:function( grid, record, item, index, e, eOpts){
    	  console.log("teste");
		  var win = this.AbrirJanela();	  
		  var form = win.down('form');
		  form.loadRecord(record);
	},
		SalvarCadastroServico:function(btn,e,Eopt){
			
		  var  form = btn.up('form');
		  var values = form.getValues();
		  var record = form.getRecord();
		  var grid = Ext.ComponentQuery.query('lisser');
		  var win = btn.up('window');
		  var novo = false; 
		  if(form.getForm().isValid()){
		  if(values.id_cadser>0){
		  	record.set(values);
		  	novo = true;
		  }
		  else{
		  	record = Ext.create('Admin.model.Servico');
		  	record.set(values);		  	
		  	novo = true;
		  }
		  this.getServicosStore().add(record);
		  win.close();

		  this.getServicosStore().sync({
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
			ValidacaoRemotaTextField:function(textfield,opt){
					var valorId = Ext.ComponentQuery.query('#id_cadser');    				
	                var id = valorId[valorId.length-1].value;
	                     if(id==null || id=="" || id==undefined){                         
	                        Ext.Ajax.request({
	                        url: endereco+'admin/servicos/validateremote',
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
	                        url: endereco+'admin/servicos/validateremote',
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
	                            textfield.markInvalid('Este nome já está cadastrado');
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
	AbrirJanelaCadastrarServico:function(btn,e,opt){
		this.AbrirJanela();
	},
	AbrirJanela:function(){	
	var component = Ext.create('Admin.view.servico.Cadastrar');
				if(!win){
					var win = Ext.create('Ext.window.Window',{
						title:'Catálogo de Serviços',
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
