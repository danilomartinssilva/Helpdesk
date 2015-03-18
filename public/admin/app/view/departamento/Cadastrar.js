  var storeStatus =  Ext.create('Ext.data.Store',{
        autoLoad:true,
        fields:[
        {'name':'status_caddep','type':'int'},
        {'name':'descricao_status','type':'string'}],
        data:[
        {'status_caddep':"0","descricao_status":"Bloqueado"},
        {'status_caddep':"1","descricao_status":"Ativo"}]

    });

Ext.define("Admin.view.departamento.Cadastrar", {
    extend: 'Ext.form.Panel',
    xtype:'caddep',    
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
    itemId:'id_caddep',
    xtype: 'textfield',
    name : 'id_caddep',
    fieldLabel: 'Meu Id',
    hidden:true
    },
    {
        fieldLabel: 'Departamento',
        name: 'desc_caddep',
        allowBlank: false,
        itemId:'desc_caddep',
         validator:function(){
            return this.textValid;
        },
    },{
        fieldLabel: 'Contato (Responsavel pelo Departamento)',
        name: 'responsavel_caddep',
        allowBlank: false,
        itemId:'responsavel_caddep'
    },{
        xtype:"combobox",
        fieldLabel: 'Departamento Responsavel',
        store: 'Departamentos',
        queryMode: 'local',
        displayField: 'desc_caddep',
        valueField: 'id_caddep',
        name:'parent_caddep',
        itemId:'parent_caddep' 
     },{
        xtype:"textfield",
        name:"telefone_caddep",
        itemId:"telefone_caddep",
        fieldLabel:"Telefone/Ramal"
     },{
        xtype:"combobox",
        fieldLabel: 'Status departamento',
        store:storeStatus,
        queryMode: 'local',
        displayField:'descricao_status',
        valueField:'status_caddep',      
        itemId:'status_caddep' ,
        name:'status_caddep'
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