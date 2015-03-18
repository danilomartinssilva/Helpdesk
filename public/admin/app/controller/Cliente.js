Ext.define('Admin.controller.Cliente', {
    extend: 'Ext.app.Controller',
    stores:['Clientes'],
    model:['Cliente'],
    views:['cliente.Cadastrar','cliente.Listar'],
    refs:[{
    	ref:'cadcli',
    	selector:'cadcli'
    },{
    	ref:'liscli',
    	selector:'liscli'
    }],
    init:function(){
    	this.control({
    		'liscli':{
    			render:this.CarregarGrid,
    			itemdblclick:this.PopularFormulario
    		},
			'liscli #btnCadastrarDepartamento':{
				click:this.AbrirCadastroCliente
			},
			'cadcli #btnSalvarCadastro':{
				click:this.SalvarCadastroCliente
			},
			'cadcli #desc_cadcli':{
				beforerender:this.LimparMensagensValidacao,
				blur:this.ValidacaoRemotaTextField
			},
			'cadcli #cpf_cadcli':{
				beforerender:this.LimparMensagensValidacao,
				blur:this.ValidacaoCpf,
				//blur:this.ValidacaoRemotaTextField,
			},
			'cadcli #email_cadcli':{
				beforerender:this.LimparMensagensValidacao,
				blur:this.ValidacaoRemotaTextField
			},
           
    	})
    },

    CarregarGrid:function(grid,e,eopts){
    	grid.getStore().load();
    },
    ValidacaoCpf:function(textfield,newValue,OldValue){
		
		value = textfield.value;
		var id = Ext.ComponentQuery.query("#id_cadcli");
		id = id[id.length-1].value;
		Ext.Ajax.request({
                        url: endereco+'admin/cliente/validatecpf',
                        params: {
                            cpf:value,idcampo:id
                        },
                        success: function(response){
                            //var result = response.responseText;
                             var result = Ext.JSON.decode(response.responseText, true);
                            if (result.success==true){
                             textfield.clearInvalid();
                             textfield.textValid = true; 
                             } 
                             else {
                            textfield.markInvalid(result.message);                            
                            textfield.textValid = false;                
                             }                         
                        }
                    });
},
ValidacaoRemotaTextField:function(textfield,opt){
				var valorId = Ext.ComponentQuery.query('#id_cadcli');    				
                var id = valorId[valorId.length-1].value;
                     if(id==null || id=="" || id==undefined){                         
                        Ext.Ajax.request({
                        url: endereco+'admin/cliente/validateremote',
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
                        url: endereco+'admin/cliente/validateremote',
                        params: {
                            field:'desc_cadcli',value:textfield.value,idcampo:id
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

AbrirCadastroCliente:function(btn,e,opt){
				this.AbrirJanela();

},
PopularFormulario:function( grid, record, item, index, e, eOpts){
	  var win = this.AbrirJanela();	  
	  var form = win.down('form');  
	  form.loadRecord(record);
	  
},
SalvarCadastroCliente:function(btn,e,Eopt){
	        var  form = btn.up('form');
          var values = form.getValues();
          var record = form.getRecord();          
          var grid = Ext.ComponentQuery.query('liscli');
          var win = btn.up('window');
          var novo = false; 
          if(form.getForm().isValid()){
          if(values.id_cadcli>0){
            record.set(values);
            novo = true;
          }
          else{
            record = Ext.create('Admin.model.Cliente');
            record.set(values);         
            novo = true;
          }
          this.getClientesStore().add(record);
        Ext.MessageBox.show({
                    title: 'Enviando email de notificação ao acesso liberado',
                    progressText:'Enviando emails',
                    wait:true,
                    waitConfig:{interval:200},
                    //msg: "Sua operação foi salva com sucesso!",
                    icon: Ext.MessageBox.INFORMATIONAL,
                    //buttons: Ext.Msg.OK
                }); 
         
          win.close();

          this.getClientesStore().sync({
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
	
	var component = Ext.create('Admin.view.cliente.Cadastrar');
				if(!win){
					var win = Ext.create('Ext.window.Window',{
						title:'Cadastro de cliente',
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
