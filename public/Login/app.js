var endereco = window.dataServerUsuario.endereco;

/*
    This file is generated and updated by Sencha Cmd. You can edit this file as
    needed for your application, but these edits will have to be merged by
    Sencha Cmd when upgrading.
*/
Ext.require('Ext.form.Panel');
Ext.require('Ext.container.Viewport');
Ext.require('Ext.data.Store');
Ext.require('Ext.form.FieldSet');
Ext.require('Ext.form.FieldContainer');
Ext.require('Ext.form.field.ComboBox');
Ext.require('Login.ux.TextMaskPlugin');
Ext.require('Login.ux.InputTextMask');

Ext.application({
    name: 'Login',

    extend: 'Login.Application',
    
   launch: function(){
		Ext.create('Ext.container.Viewport',{
			layout:'fit',
			items:{
				xtype:'formLogin'
			}			
		});		
	}
});
