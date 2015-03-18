	Ext.define('Login.controller.Login', {
	    extend: 'Ext.app.Controller',
	    model:['Cliente'],
	    stores:['Clientes'],
	    views:['login.Cadastrar','login.Login'],
	    refs:[{
	    	ref:'cadcli',
	    	selector:'cadcli'
	    },{
	    	ref:'formLogin',
	    	selector:'formLogin'
	    }],
	    init:function(){
	    	this.control({
				' #abrirCadastro':{
					click:this.AbrirJanelaCadastroUsuario
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
			'cadcli #btnSalvarCadastro':{
				click:this.SalvarCadastroCliente
			},

			})

	    },
	  SalvarCadastroCliente:function(btn,e,Eopt){
	      var  form = btn.up('form');
          var values = form.getValues();
          var record = form.getRecord();
          var win = btn.up('window');
          var novo = false; 
          if(form.getForm().isValid()){          
            record = Ext.create('Login.model.Cliente');            
            record.set(values);         
            novo = true;
            
            
          
          this.getClientesStore().add(record);
           Ext.MessageBox.show({
                    title: 'Processando cadastro',
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
                        msg: "Cadastro efetuado com sucesso. Você deve aguardar o email com a ativação do seu registro!",
                        icon: Ext.MessageBox.INFORMATIONAL,
                        buttons: Ext.Msg.OK
                    });
                     window.location.href=endereco+'login'
                 }
            }
          });
        }

},
	    ValidacaoCpf:function(textfield,newValue,OldValue){
		
		value = textfield.value;
		var id = Ext.ComponentQuery.query("#id_cadcli");
		id = id[id.length-1].value;
		Ext.Ajax.request({

                        //url: endereco+'admin/cliente/validatecpf',
                        url:endereco+'admin/cliente/validatecpf',
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
	    AbrirJanelaCadastroUsuario:function(btn,e,opets){
	    	btn.up('window').hide();
	    	this.AbrirJanela()
	    	

	    },
	    AbrirJanela:function(){
			var component = Ext.widget('cadcli');
						if(!win){
							var win = Ext.create('Ext.window.Window',{
								title:'Cadastro de Usuário',
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
		ValidacaoRemotaTextField:function(textfield,opt){
				var valorId = Ext.ComponentQuery.query('#id_cadcli');    				
                var id = valorId[valorId.length-1].value;
                     if(id==null || id=="" || id==undefined){                         
                        Ext.Ajax.request({
                        //DESCOMENTA QUANDO FOR PUBLICARurl: endereco+'admin/cliente/validateremote',
                        url:endereco+'admin/cliente/validateremote',
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

                       // url: endereco+'admin/cliente/validateremote',
                       url:endereco+'admin/cliente/validateremote',
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

	});
