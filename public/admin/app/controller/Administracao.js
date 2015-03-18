Ext.define('Admin.controller.Administracao', {
    extend: 'Ext.app.Controller',
    stores:['Logs'],
    model:['Log'],
    views:['administracao.Log'],
    refs:[{
    	ref:'lislog',
    	selector:'lislog'
    },{
    	ref:'cadlog',
    	selector:'cadlog'
    }],
    init:function(){

    	this.control({

    		'lislog':{
    			render:this.CarregarGrid
    		}

    	})
    },
    CarregarGrid:function(grid,eopts){
    	grid.getStore().load();
    }

});
