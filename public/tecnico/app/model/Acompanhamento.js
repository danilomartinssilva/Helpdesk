Ext.define('Tecnico.model.Acompanhamento',{
extend:'Ext.data.Model',
fields:[
{name:'id_cadaco',type:'int'},
{name:'desc_cadaco',type:'string'},
{name:'cd_cadsol',type:'int'},
{name:'cd_cadcli',type:'int'},{name:'cd_cadsta',type:'int'},{name:'atualizacao_cadaco',type:'string'}],

associations:[
{type:'hasMany',model:'Tecnico.model.Cliente',name:'clientes'},
{type:'hasMany',model:'Tecnico.model.Departamento',name:'departamentos'},
{type:'hasMany',model:'Tecnico.model.Perfil',name:'perfils'},
{type:'hasMany',model:'Atendente',name:'atendentes'},



]



});
Ext.define('Atendente',{

	extend:'Ext.data.Model',
	fields:[
	{name:'id_atendente',type:'int'},
	{name:'descricao_atendente',type:'string'}

	]

});
