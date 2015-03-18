
    Ext.define('User.view.acompanhamento.Cadastrar',{
    extend:'Ext.form.Panel',
    xtype:'cadaco',
    bodyPadding: 5,
    width: 350,
    layout: 'anchor',
    defaults: {
        anchor: '100%',
        labelAlign:'top',
         msgTarget:'side',
    },

    // The fields
    defaultType: 'textfield',
    items: [
    {
    itemId:'id_cadaco',
    xtype: 'textfield',
    name : 'id_cadaco',
    fieldLabel: 'Meu Id',
    hidden:true
    },
    {
        xtype:'textarea',
        fieldLabel: 'Descrição',
        name: 'desc_cadaco',        
        itemId:'desc_cadaco',        
    },{
        fieldLabel: 'Contato (Responsavel pelo Departamento)',
        name: 'cd_cadcli',        
        itemId:'cd_cadcli',
        hidden:true
      
        //hidden:true,
        //readOnly:true,
        

    },{
        xtype:'textfield',
        itemId:'cd_cadsta',
        name:'cd_cadsta',
        hidden:true,
     },{
        xtype:"datefield",
        name:"atualizacao_cadaco",
        itemId:"atualizacao_cadaco",
        fieldLabel:"Data atual:",
        value:new Date(),
        format:'d-m-Y',
        readOnly:true,
     },{
       
        fieldLabel: 'Solicitacao',
        name: 'cd_cadsol',        
        itemId:'cd_cadsol',
        hidden:true,   
     }
    ],

    // Reset and Submit buttons
    buttons: [
    {
        text:'Salvar',
        iconCls:'icone_add', 
        itemId:"btnAtualizarStatusSolicitacao",

    },
    {
        text: 'Limpar',
        iconCls:'icone_limpar',
        handler: function() {
            this.up('form').getForm().reset();
        }
    }, {
        text: 'Cancelar',
        iconCls:"icone_cancelar",
        handler: function() {
            this.up('form').getForm().reset();
            this.up('window').hide();
        }
    }],
});