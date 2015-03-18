Ext.define('Admin.model.Solicitacao',{
extend:'Ext.data.Model',

fields:[
{name:'id_cadsol',type:'int'},
{name:'desc_cadsol',type:'string'},
{name:'cd_cadcli',type:'int'},
{name:'cd_cadser',type:'int'},
{name:'tempo_execucao',type:'string'},
{name:'data_cadsol',type:'string'},
{name:'cd_cadsta',type:'int'},
{name:'cd_caddir' , type:'int'},
{name:'tempo_gasto' , type:'string'},
{name:'atendente',type:"string"},'servicos'],


associations:[
{
	type:'hasMany',model:'Admin.model.Status',name:'statuss'
},

{
	type:'hasMany',model:'Admin.model.Servico',name:'servicos'
},
{
	type:'hasMany',model:'Admin.model.Prioridade',name:'prioridades'
},

{
	type:'hasMany',model:'Admin.model.Cliente',name:'clientes'
},
{
	type:'hasMany',model:'Admin.model.Departamento',name:'departamentos'
},
{
	type:'hasMany',model:'Admin.model.Direcionamento',name:'direcionamentos'
}]


});

