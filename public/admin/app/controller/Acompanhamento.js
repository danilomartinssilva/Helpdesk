	Ext.define('Admin.controller.Acompanhamento', {
	    extend: 'Ext.app.Controller',
	    model:['Acompanhamento'],
	    stores:['Acompanhamentos'],
	    views:['acompanhamento.Listar','acompanhamento.Cadastrar'],
	    refs:[{
	    	ref:'lisaco',
	    	selector:'lisaco'
	    },{
	    	ref:'cadaco',
	    	selector:'cadaco'
	    }],
	    init:function(){
	    	this.control({
	    		'lisaco':{
	    			render:this.CarregarGrid
	    		},
	    		'cadaco #btnAtualizarStatusSolicitacao':{
					click:this.AtualizarStatusSolicitacao
				},




	    	})



	    },
	    CarregarGrid:function(grid,eopts){	
		grid.getStore().load();
		},
		AtualizarStatusSolicitacao:function(btn,e,opts){
		var form = btn.up('form');
		var values = form.getValues();
		var record = form.getRecord();
		var win = btn.up('window');
		var novo = false;
		if(form.getForm().isValid()){
			values.atualizacao_cadaco = Ext.Date.format(new Date(),'Y-m-d H:i:s');
			
			if(values.id_cadaco>0){
				record.set(values);
				novo = true;
			}
			else{
				record = Ext.create('Admin.model.Acompanhamento');			
				record.set(values);
				this.getAcompanhamentosStore().add(record);
				novo=true;
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
	        

		   this.getAcompanhamentosStore().sync({
		  	success:function(){
		  		if(novo){
		  			var AtualizarGrid = Ext.ComponentQuery.query('lissol');
		  			console.log(AtualizarGrid[0].getStore().load());
		  			 Ext.MessageBox.show({
	                    title: 'Confirmação',
	                    msg: "Sua operação foi salva com sucesso!",
	                    icon: Ext.MessageBox.INFORMATIONAL,
	                    buttons: Ext.Msg.OK
	                });
		  			
		  			
		 		 }
		  	}
		  });

		}

	}

	});
