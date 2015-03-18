Ext.define('User.model.Acompanhamento',{
extend:'Ext.data.Model',
fields:[
{name:'id_cadaco',type:'int'},
{name:'desc_cadaco',type:'string'},
{name:'cd_cadsol',type:'int'},
{name:'cd_cadcli',type:'int'},{name:'cd_cadsta',type:'int'},{name:'atualizacao_cadaco',type:'string'}],

associations:[
{type:'hasMany',model:'SistemaHelpDesk.model.Cliente',name:'clientes'},
{type:'hasMany',model:'SistemaHelpDesk.model.Departamento',name:'departamentos'},
{type:'hasMany',model:'SistemaHelpDesk.model.Perfil',name:'perfils'},
{type:'hasMany',model:'Atendente',name:'atendentes'},



]



});
Ext.define('Perfil',{
	extend:'Ext.data.Model',
	fields:['id_cadper','desc_cadper']
});
Ext.define('Departamento',{
	extend:'Ext.data.Model',
	fields:['id_caddep','desc_caddep']

});
Ext.define('Cliente',{
extend:'Ext.data.Model',
fields:['id_cadcli','desc_cadcli']

});
Ext.define('Atendente',{

	extend:'Ext.data.Model',
	fields:[
	{name:'id_atendente',type:'int'},
	{name:'descricao_atendente',type:'string'}

	]

});
