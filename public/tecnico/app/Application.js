Ext.define('Tecnico.Application', {
    name: 'Tecnico',

    extend: 'Ext.app.Application',

    views: [
     'Head',
     'Menu',
     'content.Content',
     'Main',
     'solicitacao.Listar',
     'solicitacao.Cadastrar',
     'acompanhamento.Cadastrar',
     'acompanhamento.Listar',
     'basedeconhecimento.Listar',
     'basedeconhecimento.Cadastrar',
     'basedeconhecimento.Ver'

   
    ],

    controllers: [
        'Main',
        'Solicitacao',
        'Acompanhamento',
        'Basedeconhecimento'

    ],

    stores: [
        //'MenuStore',
        'Solicitacaos',
        'Statuss',
        'Acompanhamentos',  
        'Basedeconhecimentos'   
       
    ]
});
