

Ext.define('Admin.view.basedeconhecimento.Cadastrar', {
    extend: 'Ext.form.Panel',
    xtype:'cadbase',    
    bodyPadding: 5,
    //width: 500,
  //  height:400,
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
    itemId:'id_cadbase',
    xtype: 'textfield',
    name : 'id_cadbase',
    fieldLabel: 'Meu Id',
    hidden:true
    },
    {
        fieldLabel: 'Titulo',
        name: 'titulo_cadbase',
        allowBlank: false,
        itemId:'titulo_cadbase',
        /* validator:function(){
            return this.textValid;
        },*/
    },{
        fieldLabel: 'Autor:',
        name: 'autor_cadbase',
        readOnly:true,
        allowBlank: false,
        itemId:'autor_cadbase',  
        value: nomeUsuario   
    },{
        xtype: 'htmleditor',
        itemId:'texto_cadbase',
        name:'texto_cadbase',
         height: 450,

        //enableColors: false,
        //enableAlignments: false
     }
    ],

    // Reset and Submit buttons
    buttons: [
    {
        text:'Salvar',
        iconCls:'icone_add', 
        itemId:"btnSalvarCadastro",

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


