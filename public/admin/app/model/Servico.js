Ext.define('Admin.model.Servico',{

extend:'Ext.data.Model',

fields:[
{name:'id_cadser',type:'int'},
{name:'desc_cadser',type:'string'},
{name:'obs_cadser',type:'string'},
{name:'status_cadser',type:'int'},
{name:'cd_cadpri',type:'int'},
{name:'parent_cadser',type:'int'},{name:'cd_caddir',type:'int'},
{name:'tempo_cadser',type:'string'}],

associations:[
{type:'hasMany',model:'Admin.model.Prioridade',name:'prioridades'},
{type:'hasMany',model:'Categoria',name:'categorias'}

]



});


Ext.define('Categoria',{
extend:'Ext.data.Model',
fields:['id','descricao']


});