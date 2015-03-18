
Ext.define('Admin.view.solicitacao.Cadastrar', {
	extend:'Ext.form.Panel',
    xtype:"cadsol",   
    bodyPadding: 5,
    width: 350,   

    // Fields will be arranged vertically, stretched to full width
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
    	itemId:'id_cadsol',
    	hidden:true,
    	name:'id_cadsol'

    },
    {
        xtype:'combobox',
        fieldLabel:'Solicitante',
        store:'Clientes',
        queryMode:'local',
        displayField:'desc_cadcli',
        valueField:'id_cadcli',
        name:'cd_cadcli',
        itemId:'cd_cadcli',
        allowBlank:false,
    },
    {
        fieldLabel:'Status',
        itemId:'cd_cadsta',
        name:'cd_cadsta',
        value:1,
        hidden:true,
    },
    

   {
        xtype:"combobox",
        fieldLabel: 'Tipo de solicitação',  
        store:'Servicos',
        queryMode: 'local',
        displayField: 'desc_cadser',
        valueField: 'id_cadser',
        name:'cd_cadser',
        itemId:'cd_cadser' ,
        allowBlank: false,

    },
      {
        xtype:'textarea',
        height:200,
        fieldLabel: 'Descrição',
        name: 'desc_cadsol',
        allowBlank: false,
        itemId:'desc_cadsol',
         
    },{
        xtype: 'datefield',
        format:"d-m-Y",
        //anchor: '100%',
        fieldLabel: 'Data atual',
        name: 'data_cadsol',
        value: new Date(),
        itemId:'data_cadsol',
        readOnly:true,

    }],

    // Reset and Submit buttons
   buttons: [
    {
        text:'Salvar',
        iconCls:'icone_add', 
        itemId:"btnSalvarCadastroSolicitacao",     


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
    //renderTo: Ext.getBody()
});