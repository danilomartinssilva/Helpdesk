Ext.define('Login.model.Cliente',{
	extend:'Ext.data.Model',
	fields:[
	{'name':'id_cadcli',type:"int"},
	{'name':'desc_cadcli',type:'string'},
	{'name':'cpf_cadcli',type:'string'},
	{'name':'email_cadcli',type:'string'},
	{'name':'telefone_cadcli',type:'string'},
	{'name':'ramal_cadcli',type:'string'},
	{'name':'celular_cadcli',type:'string'},
	{'name':'funcao_cadcli',type:'string'},
	{'name':'status_cadcli',type:'int'},
	{'name':'cd_caddep',type:'int'},
	{'name':'cd_cadper',type:'int'},
	{'name':'senha_cadcli',type:'string'},
	{name:'cd_caddir' , type:'int'}],
	

	
});
