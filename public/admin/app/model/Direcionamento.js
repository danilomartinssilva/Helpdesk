	Ext.define('Admin.model.Direcionamento',{
	extend:'Ext.data.Model',
	fields:[{
		name:'id_caddir',type:'int'
		},{
		name:'descricao_caddir',type:"string"
		},
	],

		associations:[
{
	type:'hasMany',model:'Admin.model.Cliente',name:'clientes'
},

{
	type:'hasMany',model:'Admin.model.Servico',name:'servicos'
}]



	});