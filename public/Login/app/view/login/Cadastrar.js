
	Ext.define('Login.view.login.Cadastrar', {
	            extend:'Ext.form.Panel',       
	            autoHeight: true,
	            xtype:'cadcli',
	            width   : 700,
	            bodyPadding: 10,
	            defaults: {
	                anchor: '100%',
	                labelWidth: 100,
	                  labelAlign:'top',
	            },
	            items   : [
	                {
	                xtype: 'textfield',
	                name : 'id_cadcli',
	                itemId:'id_cadcli',
	                fieldLabel: 'Meu Id',
	                hidden:true
	                },
	                {
	                    xtype     : 'textfield',
	                    name      : 'desc_cadcli',
	                    itemId    : 'desc_cadcli' ,
	                    fieldLabel: 'Nome',                
	                    msgTarget: 'side',
	                    allowBlank: false,
	                
	                },
	                 {
	                    xtype     : 'textfield',
	                    name      : 'email_cadcli',
	                    itemId    : 'email_cadcli',
	                    fieldLabel: 'Email',                
	                    msgTarget: 'side',
	                    allowBlank: false,
	                    vtype:'email',
	                },
	                 {
	                    xtype     : 'textfield',
	                    name      : 'cpf_cadcli',
	                    itemId    : 'cpf_cadcli',
	                    emptyText: '99999999999',

	                    fieldLabel: 'Cpf',                
	                    msgTarget: 'side',
	                    allowBlank: false,                
	                },
	                
	                {
	                    xtype: 'fieldset',
	                    title: 'Informações',
	                    //ollapsible: true,
	                    defaults: {
	                        labelWidth: 89,
	                        anchor: '100%',
	                        layout: {
	                            type: 'hbox',
	                            defaultMargins: {top: 0, right: 5, bottom: 0, left: 0}
	                        }
	                    },
	                    items: [
	                        {
	                            xtype: 'fieldcontainer',
	                            fieldLabel: 'Telefones',
	                            //combineErrors: true,

	                            msgTarget: 'side',
	                            defaults: {
	                                hideLabel: true
	                            },
	                            items: [
	                               
	                                {xtype: 'textfield',  emptyText: 'Telefone', name: 'telefone_cadcli', flex:1,plugins: 'textmask', mask:'(99) 9999-9999', allowBlank: false},
	                               
	                                {xtype: 'textfield',    emptyText: 'Celular', name: 'celular_cadcli', flex:1,plugins: 'textmask', mask:'(99) 9999-9999', allowBlank: false, margins: '0 5 0 0'},
	                               
	                                {xtype: 'textfield',    emptyText: 'Ramal', name: 'ramal_cadcli',flex:1, allowBlank: false}
	                            ]
	                        },
	                        {
	                            xtype: 'fieldcontainer',
	                            fieldLabel: 'Dados Profissionais',
	                            combineErrors: false,
	                            defaults: {
	                                hideLabel: true
	                            },
	                            items: [
	                               {
	                                   name : 'funcao_cadcli',
	                                   xtype: 'textfield',
	                                   itemId:'funcao_cadcli',
	                                   emptyText:'Função', 
	                                   flex:1,
	                                   allowBlank: false
	                               },
	                               {
	                                   xtype: 'combobox',
	                                   queryMode:'local',
	                                   store:'Departamentos',
	                                   valueField:'id_caddep',
	                                   name:'cd_caddep',
	                                   itemId:'cd_caddep',
	                                   displayField:'desc_caddep',
	                                   emptyText:'Departamento',
	                                   allowBlank:false,
	                                   flex:1,

	                                   
	                               },
	                            ]
	                        },
	                          {
	                            xtype: 'fieldcontainer',
	                            fieldLabel: 'Senha',
	                            combineErrors: false,
	                            defaults: {
	                                hideLabel: true
	                            },
	                            items: [
	                               {
	                                   name : 'senha_cadcli',
	                                   xtype: 'textfield',
	                                   flex:1,
	                                   allowBlank: false,
	                                   inputType:'password',
	                                   emptyText:'Password'
	                               },
	                               {
	                                   xtype:'textfield',
	                                   name:'status_cadcli',
	                                   itemId:'status_cadcli',
	                                   hidden:true
	                               },
	                            ]
	                        },
	                        {
	                            xtype: 'fieldcontainer',
	                            //fieldLabel: 'Perfil',
	                            combineErrors: false,
	                            defaults: {
	                                hideLabel: true
	                            },
	                            items: [
	                               {
	                                   xtype: 'textfield',
	                                   itemId:'cd_cadper',
	                                   name:'cd_cadper',
	                                   hidden:true,
	                                   value:3


	                               },
	                               {
	                                   xtype: 'textfield',
	                                   itemId:'cd_caddir',
	                                   name:'cd_caddir',
	                                   hidden:true,
	                                   value:1
	                                   
	                               },
	                            ]
	                        },
	                        
	                    ]
	                }
	            ],
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