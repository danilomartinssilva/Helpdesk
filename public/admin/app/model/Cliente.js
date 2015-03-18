Ext.define('Admin.model.Cliente',{
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
	

	associations: [
	{
        type: 'hasMany',
        model: 'Admin.model.Departamento',
        name:'departamentos'
        //primaryKey: 'id_caddep',
        //foreignKey: 'cd_caddep',
       // autoLoad: true,
       // associationKey: 'departamentos' // read child data from nested.child_groups
    },
    {
        type: 'hasMany',
        model: 'Admin.model.Perfil',
        name:'perfils'
        //primaryKey: 'id_caddep',
        //foreignKey: 'cd_caddep',
       // autoLoad: true,
       // associationKey: 'departamentos' // read child data from nested.child_groups
    },

      {
        type: 'hasMany',
        model: 'Admin.model.Direcionamento',
        name:'direcionamentos'
        //primaryKey: 'id_caddep',
        //foreignKey: 'cd_caddep',
       // autoLoad: true,
       // associationKey: 'departamentos' // read child data from nested.child_groups
    },



    ]



/*
	hasMany:{
		model:'SistemaHelpDesk.model.Departamento',
		name:'departamentos',
	},
		
	*/
});
