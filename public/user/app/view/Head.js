  Ext.onReady(function(){
  // loadScript('desktop');
   setTimeout(function(){
      Ext.get('loading').remove();
      Ext.get('loading-mask').fadeOut({remove:true});
   }, 250);
});

var nomeUsuario = "Usuário: "+window.dataServerUsuario .desc_cadcli;
var idUsuario = window.dataServerUsuario .id_cadcli;
var endereco = window.dataServerUsuario.url;

Ext.define('User.view.Head',{
	extend:'Ext.toolbar.Toolbar',
	xtype:'topo',
	cls:'myTopo',
	autoHeigth:true,  
	
    items: [
           //'<font color="#FFF" size="2" font-family="Trebuchet Ms">SISTEMA DE GERENCIAMENTO DE CHAMADOS - PREFEITURA MUNICIPAL DE SANTA HELENA DE GOIÁS</font>',
           'SISGEC (SISTEMA DE GERENCIAMENTO DE CHAMADOS) - PREFEITURA MUNICIPAL DE SANTA HELENA DE GOIÁS',
			{xtype: 'tbspacer', width: 300},
		//	'<font color="#FFF" size="1" font-family="Trebuchet Ms">Técnico: Danilo Martins da Silva</font>',
			nomeUsuario,
			{xtype:'tbseparator'},
            {xtype:'button',text:"Ajuda",iconCls:"icone_ajuda",cls:'btnAjuda',action:'ajuda'},
            {xtype:'tbseparator'},
            {xtype:'button',text:"Sair",iconCls:"icone_logoff",action:'exit',cls:'btnLogoff',
            handler:function(){
            	Ext.Ajax.request({
					url:endereco+'user/index/logout',
					
					success:function(conn,response,options,eopts){						
						 var result = Ext.JSON.decode(conn.responseText, true);
						 if (!result){ // caso seja null
				                result = {};
				                result.success = false;
				                result.msg = conn.responseText;

				            }
				 
				            if (result.success) {				            
				            	location.href = endereco+'login'; 
				 
				            } else {
				                Ext.Msg.show({
				                    title:'Erro',
				                    msg: result.message,
				                    icon: Ext.Msg.ERROR,
				                    buttons: Ext.Msg.OK
				                });
				            }
					},
					failure:function(conn,response,options,eopts){
						 Ext.Msg.show({
				                title:'Erro - Contate Administrador do sistema!',
				                msg: conn.responseText,
				                icon: Ext.Msg.ERROR,
				                buttons: Ext.Msg.OK
				            });
					}
				});
            	
            }}, 
	     ]
});
