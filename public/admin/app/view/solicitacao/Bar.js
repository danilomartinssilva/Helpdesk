/*
 function refreshData(){
            store.load();
}*/
 /* var task = {
            run: refreshData,
            interval: 10000 //entre 1000 para segundos
         }

 */        
         //------------------------------------
 /*
 var runner = new Ext.util.TaskRunner();
 runner.start(task);
 */

Ext.define('Admin.view.solicitacao.Bar', {
    extend:'Ext.chart.Chart',
    xtype:'lissolbar',
    renderTo: Ext.getBody(),
    width: 500,
    height: 300,
    animate: true,
    store: 'Rankings',
    axes: [{
        type: 'Numeric',
        position: 'bottom',
        fields: ['chamados'],
        label: {
            renderer: Ext.util.Format.numberRenderer('0,0')
        },
        title: 'Quantidade',
        grid: true,
        minimum: 0
    }, {
        type: 'Category',
        position: 'left',
        fields: ['usuario'],
        title: 'Usuário'
    }],
    series: [{
        type: 'bar',
        axis: 'bottom',
        highlight: true,
        tips: {
          trackMouse: true,
          width: 140,
          height: 28,
          renderer: function(storeItem, item) {
            this.setTitle(storeItem.get('usuario') + ': ' + storeItem.get('chamados') + ' views');
          }
        },
        label: {
          display: 'insideEnd',
            field: 'chamados',
            renderer: Ext.util.Format.numberRenderer('0'),
            orientation: 'horizontal',
            color: '#333',
            'text-anchor': 'middle'
        },
        xField: 'usuario',
        yField: 'chamados'
    }]
});