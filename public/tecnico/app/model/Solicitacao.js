Ext.define('Tecnico.model.Solicitacao',{
extend:'Ext.data.Model',
requires:['Tecnico.model.Departamento',
			'Tecnico.model.Cliente',
			'Tecnico.model.Status',
			'Tecnico.model.Direcionamento',

			],

fields:[
{name:'id_cadsol',type:'int'},
{name:'desc_cadsol',type:'string'},
{name:'cd_cadcli',type:'int'},
{name:'cd_cadser',type:'int'},
{name:'tempo_execucao',type:'string'},
{name:'data_cadsol',type:'string'},
{name:'cd_cadsta',type:'int'},
{name:'cd_caddir' , type:'int'},{
	name:'atendente',type:'string'
}],


associations:[
{
	type:'hasMany',model:'Tecnico.model.Status',name:'statuss'

},
{

	type:'hasMany',model:'Tecnico.model.Departamento',name:'departamentos'
},
{

	type:'hasMany',model:'Tecnico.model.Cliente',name:'clientes'
},
{

	type:'hasMany',model:'Tecnico.model.Status',name:'statuss'
},

{

	type:'hasMany',model:'Tecnico.model.Direcionamento',name:'direcionamentos'
},

]


});

