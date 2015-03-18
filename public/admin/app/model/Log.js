Ext.define('Admin.model.Log',{
	extend:'Ext.data.Model',
	fields:[{
		name:'id_cadlog',type:'int'	},
		{name:'date',type:'string'},
		{name:'action',type:'string'},
		{name:'usuario',type:'usuario'},
		{name:'target',type:'target'}
		]



})