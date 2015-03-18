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

Ext.define('Admin.view.solicitacao.Barfrequencia', {
    extend:'Ext.chart.Chart',
    xtype:'barfrequencia',
    renderTo: Ext.getBody(),
    width: 500,
    height: 300,
    animate: true,
    store: 'Frequencias',
    axes: [{
        type: 'Numeric',
        position: 'bottom',
        fields: ['quantidade'],
        label: {
            renderer: Ext.util.Format.numberRenderer('0,0')
        },
        title: 'Quantidade',
        grid: true,
        minimum: 0
    }, {
        type: 'Category',
        position: 'left',
        fields: ['servico'],
        title: 'Servico'
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
            this.setTitle(storeItem.get('servico') + ': ' + storeItem.get('quantidade') + ' views');
          }
        },
        label: {
          display: 'insideEnd',
            field: 'quantidade',
            renderer: Ext.util.Format.numberRenderer('0'),
            orientation: 'horizontal',
            color: '#333',
            'text-anchor': 'middle'
        },
        xField: 'servico',
        yField: 'quantidade'
    }]
});