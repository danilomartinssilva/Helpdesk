Ext.define('Login.model.Departamento',{
	extend:'Ext.data.Model',
	fields:[
	{'name':'id_caddep',type:"int"},
	{'name':'desc_caddep',type:'string'},
	{'name':'responsavel_caddep',type:'string'},
	{'name':'telefone_caddep',type:'string'},
	{'name':'parent_caddep',type:'int'},
	{'name':'status_caddep',type:'int'}],
	hasMany:{
		model:'Responsavel',
		name:'responsaveis'
	}
});
Ext.define('Responsavel',{
	extend:'Ext.data.Model',
	fields:['id','descricao'],


});

