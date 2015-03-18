  Ext.onReady(function(){
  // loadScript('desktop');
   setTimeout(function(){
      Ext.get('loading').remove();
      Ext.get('loading-mask').fadeOut({remove:true});
   }, 250);
});


    var storeStatus =  Ext.create('Ext.data.Store',{
        autoLoad:true,
        fields:[
        {'name':'acesso','type':'int'},
        {'name':'descricao_acesso','type':'string'}],
        data:[
        {'acesso':"0","descricao_acesso":"Usuário"},
        {'acesso':"1","descricao_acesso":"Técnico"},
        {'acesso':"2","descricao_acesso":"Administrador"}]

    });


    var janelaLogin = Ext.create('Ext.form.Panel', {   
        bodyPadding: 10,
        width: 350,
        layout: 'anchor',
        xtype:'formLogin',
        defaults: {
            anchor: '100%',
             labelAlign: 'top',
             msgTarget: 'side',

        },        
        defaultType: 'textfield',
        items: [
        {
            fieldLabel:'Acesso',
            name:'tipo_acesso',
            xtype:'combobox',
            store:storeStatus,
            displayField:'descricao_acesso',
            valueField:'acesso'
            

        },

        {
            fieldLabel: 'Email',
            name: 'email_cadcli',
            allowBlank: false,
            vtype:'email',
            allowBlank:false,        
        },{
            fieldLabel: 'Senha',
            name: 'senha_cadcli',
            inputType:'password',
            allowBlank: false,        
        }],    
        buttons: [{
            text: 'Limpar',
            iconCls:'icone_limpar',
            handler: function() {
                this.up('form').getForm().reset();
            }
        }, {
            text: 'Entrar',
            name:'btn_cadastrar',
            iconCls:'icone_login',
            handler:function(btn,e,opt){
                var win = btn.up('window');
                var form = win.down('form');
                
                //Verifica se o formulário foi preenchido corrretamente - SE SIM
                if(form.getForm().isValid()!=false){                
                var values = form.getValues();
                
                var email_cadcli = values.email_cadcli;
                var senha_cadcli = values.senha_cadcli;
                var acesso = values.tipo_acesso;
                var url = endereco+'login/index/autenticate';
                var redirect = "";
                console.log(acesso);

                if(acesso==0){
                    url = endereco+'user/index/autenticate';

                     redirect = endereco+'user';       
                }
                if(acesso==1){
                     url = endereco+'tecnico/index/autenticate';
                    redirect = endereco+'tecnico';    
                }
                if(acesso==2){
                     url = endereco+'admin/index/autenticate';
                     redirect = endereco+'admin'; 
                    
                }
                    Ext.Ajax.request({                    
                        url:url,          
                        params:{
                            email_cadcli:email_cadcli,
                            senha_cadcli:senha_cadcli,
                            acesso:acesso
                        },
                        success:function(conn,response,options,eopts){                      
                             var result = Ext.JSON.decode(conn.responseText, true);
                             if (!result){ // caso seja null
                                    result = {};
                                    result.success = false;
                                    result.msg = conn.responseText;

                                }
                     
                                if (result.success) {    
                                //SE ONLINE /~hepshego/tecnico/index/index  
                                //SE LOCAL /helpdesk/tecnico/index/index         

                                    location.href = redirect;                  
                                } else {                                
                                    Ext.Msg.show({
                                        title:'Erro',
                                        msg: result.message,
                                        icon: Ext.Msg.ERROR,
                                        buttons: Ext.Msg.OK
                                    });
                                }
                        },
                        failure:function(conn,response,options,eopts){
                             Ext.Msg.show({
                                    title:'Erro - Contate Administrador do sistema!',
                                    msg: conn.responseText,
                                    icon: Ext.Msg.ERROR,
                                    buttons: Ext.Msg.OK
                                });
                        }
                    })
                
                }
          
            }
          
        },{

            text: 'Cadastrar',
            name:'abrirCadastro',
            iconCls:'icone_add',
            itemId:'abrirCadastro',
            disabled:false
        }],
     
    });

    Ext.define('Login.view.login.Login', {
        title: 'HelpDesk - Módulo Usuário',
        extend:'Ext.window.Window',
        xtype:"formLogin",
        autoHeight:true,
        width: 400,
        layout: 'fit',
        autoShow:true,
        modal:true,
        closable:false,
        items: {  // Let's put an empty grid in just to illustrate fit layout
            xtype: janelaLogin,
        },
        iconCls:'icone_cadeado'
        
    });