  var storeStatus =  Ext.create('Ext.data.Store',{
        autoLoad:true,
        fields:[
        {'name':'status_cadser','type':'int'},
        {'name':'descricao_status','type':'string'}],
        data:[
        {'status_cadser':"0","descricao_status":"Bloqueado"},
        {'status_cadser':"1","descricao_status":"Ativo"}]

    });
    var storeTempo =  Ext.create('Ext.data.Store',{
        autoLoad:true,
        fields:[
        {'name':'tempo_cadser','type':'string'},
        {'name':'descricao_tempo','type':'string'}],
        data:[
        {'tempo_cadser':"1:00:00","descricao_tempo":"1 Hora"},
        {'tempo_cadser':"2:00:00","descricao_tempo":"2 Horas"},
        {'tempo_cadser':"3:00:00","descricao_tempo":"3 Horas"},
        {'tempo_cadser':"4:00:00","descricao_tempo":"4 Horas"},
        {'tempo_cadser':"5:00:00","descricao_tempo":"5 Horas"},
        {'tempo_cadser':"6:00:00","descricao_tempo":"6 Horas"},
        {'tempo_cadser':"7:00:00","descricao_tempo":"7 Horas"},
        {'tempo_cadser':"8:00:00","descricao_tempo":"8 Horas"},
        {'tempo_cadser':"9:00:00","descricao_tempo":"9 Horas"},
        {'tempo_cadser':"10:00:00","descricao_tempo":"10 Horas"},
        {'tempo_cadser':"11:00:00","descricao_tempo":"11 Horas"},
        {'tempo_cadser':"12:00:00","descricao_tempo":"12 Horas"},
        {'tempo_cadser':"13:00:00","descricao_tempo":"13 Horas"},
        {'tempo_cadser':"14:00:00","descricao_tempo":"14 Horas"},
        {'tempo_cadser':"15:00:00","descricao_tempo":"15 Horas"},
        {'tempo_cadser':"16:00:00","descricao_tempo":"16 Horas"},
        {'tempo_cadser':"17:00:00","descricao_tempo":"17 Horas"},
        {'tempo_cadser':"18:00:00","descricao_tempo":"18 Horas"},
        {'tempo_cadser':"20:00:00","descricao_tempo":"19 Horas"},
        {'tempo_cadser':"21:00:00","descricao_tempo":"20 Horas"},
        {'tempo_cadser':"22:00:00","descricao_tempo":"21 Horas"},
        {'tempo_cadser':"23:00:00","descricao_tempo":"22 Horas"},
        {'tempo_cadser':"24:00:00","descricao_tempo":"23 Horas"},
        {'tempo_cadser':"19:00:00","descricao_tempo":"24 Horas"},
        {'tempo_cadser':"36:00:00","descricao_tempo":"36 Horas"},
        {'tempo_cadser':"48:00:00","descricao_tempo":"48 Horas"},
        {'tempo_cadser':"72:00:00","descricao_tempo":"72 Horas"}]

    });
Ext.define('Admin.view.servico.Cadastrar', {
	extend:'Ext.form.Panel',
    xtype:'cadser',   
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
    	itemId:'id_cadser',
    	hidden:true,
    	name:'id_cadser'

    },

    {
        fieldLabel: 'Descrição do Serviço',
        name: 'desc_cadser',
        itemId:'desc_cadser',
        allowBlank: false,
        validator:function(){
            return this.textValid;
        },
    },{
        xtype:"combobox",
        fieldLabel: 'Prioridade',
        store: Ext.create('Admin.store.Prioridades',{            
        }),
        queryMode: 'local',
        displayField: 'desc_cadpri',
        valueField: 'id_cadpri',
        name:'cd_cadpri',
        itemId:'cd_cadpri' ,
        allowBlank: false
    }, {
        xtype:'combobox',
        fieldLabel: 'Categoria',
        store:'Servicos',           
        valueField:'id_cadser',
        name:'parent_cadser',
        itemId:'parent_cadser',
        displayField:'desc_cadser',
        allowBlank: false
    },{
        xtype:'combobox',
        fieldLabel:'Tempo para execução',
       /* tipText: function(thumb){
            return Ext.String.format('<b>{0} Horas</b>', thumb.value);
        },
        */
        itemId:'tempo_cadser',
        name:'tempo_cadser',
        store:storeTempo,
        valueField:'tempo_cadser',
        displayField:'descricao_tempo',
        allowBlank:false

    },{
        xtype:'combobox',
        fieldLabel: 'Direcionado à',
        store:Ext.create('Admin.store.Direcionamentos'),                
        valueField:'id_caddir',
        name:'cd_caddir',
        itemId:'cd_caddir',
        displayField:'descricao_caddir',
        allowBlank: false
    },{
        xtype:'combobox',
        fieldLabel: 'Status',
        store:storeStatus,
        name: 'status_cadser',
        itemId:'status_cadser',
        valueField:'status_cadser',        
        displayField:'descricao_status',
        allowBlank: false
    },{
        fieldLabel:'Observação',
        xtype:'textarea',
        itemId:'obs_cadser',

    }],

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
    //renderTo: Ext.getBody()
});