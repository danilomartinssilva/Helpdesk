Ext.define('User.model.Solicitacao',{
extend:'Ext.data.Model',
//requires:['User.model.Servico'],

fields:[
{name:'id_cadsol',type:'int'},{name:'desc_cadsol',type:'string'},
{name:'cd_cadcli',type:'int'},{name:'cd_cadser',type:'int'},{name:'data_cadsol',type:'string'},{name:'cd_cadsta',type:'int'}],


associations:[
{
    type:'hasMany',model:'Status',name:'statuss'
},

{
    type:'hasMany',model:'User.model.Servico',name:'servicos'
},
{
    type:'hasMany',model:'Prioridade',name:'prioridades'
},

{
    type:'hasMany',model:'Cliente',name:'clientes'
},
{
    type:'hasMany',model:'Departamento',name:'departamentos'
}]


});

Ext.define('Status',{
extend:'Ext.data.Model',
fields:['id_cadsta','desc_cadsta']

});
Ext.define('Prioridade',{
extend:'Ext.data.Model',
fields:['id_cadpri','desc_cadpri']

});
Ext.define('Cliente',{
    extend:'Ext.data.Model',
    fields:['id_cadcli','desc_cadcli']
});
Ext.define('Departamento',{
extend:'Ext.data.Model',
fields:['id_caddep','desc_caddep']

});