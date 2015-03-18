	Ext.define('Tecnico.controller.Acompanhamento', {
	    extend: 'Ext.app.Controller',
	    views:['acompanhamento.Cadastrar','acompanhamento.Listar'],
	    stores:['Acompanhamentos'],
	    model:['Acompanhamento'],
	    refs:[
	    {
	    	ref:'cadaco',
	    	selector:'cadaco'
	    },{
	    	ref:'lisaco',
	    	selector:'lisaco'
	    }],
	    init:function(){
	    	this.control({
			'cadaco #btnAtualizarStatusSolicitacao':{
				click:this.SalvarAcompanhamento	
			},
			'lisaco':{
				render:this.RenderizarGrid
			}

	    	})


	    },
	    RenderizarGrid:function(grid,e,opts){
	    	grid.getStore().load();

	    },
	    SalvarAcompanhamento:function(btn,e,opt){

	    	var form = btn.up('form');
	    	var values= form.getValues();
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
	    			record = Ext.create('Tecnico.model.Acompanhamento');
	    			record.set(values);
	    			
	    			novo = true;
	    		}
	    		this.getAcompanhamentosStore().add(record);
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
	    		this.getAcompanhamentosStore().sync({
				 	success:function(){
			  		if(novo){
			  			var AtualizarGrid = Ext.ComponentQuery.query('lissol');
			  			AtualizarGrid[0].getStore().load();
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
