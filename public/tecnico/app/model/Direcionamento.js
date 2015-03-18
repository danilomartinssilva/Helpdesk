	Ext.define('Tecnico.model.Direcionamento',{
	extend:'Ext.data.Model',
	fields:[{
		name:'id_caddir',type:'int'
		},{
		name:'descricao_caddir',type:"string"
		},
		{
		name:'cd_cadser',type:'int'
		}],

		associations:[
{
	type:'hasMany',model:'Tecnico.model.Cliente',name:'clientes'
},

{
	type:'hasMany',model:'Tecnico.model.Servico',name:'servicos'
}]



	});