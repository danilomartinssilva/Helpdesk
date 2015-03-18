Ext.define('User.Application', {
    name: 'User',

    extend: 'Ext.app.Application',

    views: [
       'Menu',
       'content.Content',
       'Head',
       'solicitacao.Cadastrar',
       'solicitacao.Listar',
       'acompanhamento.Listar',
       'acompanhamento.Cadastrar'
    ],

    controllers: [
        'Main',
        'Solicitacao',
        'Acompanhamento',
    ],

    stores: [
       'Solicitacaos',
       'Servicos',
       'Statuss',
       'Acompanhamentos',
    ]
});
