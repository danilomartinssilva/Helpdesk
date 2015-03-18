Ext.define('Tecnico.controller.Basedeconhecimento', {
    extend: 'Ext.app.Controller',
    stores:['Basedeconhecimentos'],
    model: ['Basedeconhecimento'],
    views:['basedeconhecimento.Listar','basedeconhecimento.Cadastrar'],
    refs:[{
    	ref:'cadbase',
    	selector:'cadbase'
    }],
    init:function(){
    	this.control({
    		'cadbase #btnSalvarCadastro':{
    			click:this.CadastrarArtigo	

    		},
        'lisbase ':{
          render:this.CarregarGrid
        }


    	})


    },
    CarregarGrid:function(grid,eopts){
      grid.getStore().load();

    },
    CadastrarArtigo:function(btn,e,opts){
    	 var  form = btn.up('form');
          var values = form.getValues();
          console.log(values);	
          var record = form.getRecord();          
          //var grid = Ext.ComponentQuery.query('liscli');
          //var win = btn.up('window');
          var novo = false; 
          if(form.getForm().isValid()){
          if(values.id_cadcli>0){
            record.set(values);
            novo = true;
          }
          else{
            record = Ext.create('Tecnico.model.Basedeconhecimento');
            record.set(values);         
            novo = true;
          }
          this.getBasedeconhecimentosStore().add(record);     
          //win.close();

          this.getBasedeconhecimentosStore().sync({
            success:function(){
                if(novo){
                     Ext.MessageBox.show({
                        title: 'Confirmação',
                        msg: "Sua operação foi salva com sucesso!",
                        icon: Ext.MessageBox.INFORMATIONAL,
                        buttons: Ext.Msg.OK
                    }); 
                    
                    //grid[0].getStore().load();
                 }
            }
          });
        }

    }
});
