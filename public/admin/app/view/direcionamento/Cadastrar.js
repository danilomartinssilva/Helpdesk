
    Ext.define('Admin.view.direcionamento.Cadastrar',{
    extend:'Ext.form.Panel',
    xtype:'caddir',
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
    itemId:'id_caddir',
    xtype: 'textfield',
    name : 'id_caddir',
    fieldLabel: 'Meu Id',
    hidden:true
    },
    {
        fieldLabel: 'Descrição',
        name: 'descricao_caddir',
        allowBlank: false,
        itemId:'descricao_caddir', 
        
         validator:function(){
            return this.textValid;
        },       
    }],

    // Reset and Submit buttons
    buttons: [
    {
        text:'Salvar',
        iconCls:'icone_add', 
        itemId:"btnSalvarCadastroDirecionamento",

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