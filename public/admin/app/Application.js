Ext.define('Admin.Application', {
    name: 'Admin',

    extend: 'Ext.app.Application',

    views: [
        'Head',
        'Menu',
        'content.Content',
        'solicitacao.Listar',
        'solicitacao.Cadastrar',
        'departamento.Cadastrar',
        'departamento.Listar',
        'servico.Listar',
        'servico.Cadastrar',
        'direcionamento.Cadastrar',
        'direcionamento.Listar',
        'cliente.Cadastrar',
        'cliente.Listar',
        'acompanhamento.Listar',
        'acompanhamento.Cadastrar',
        'solicitacao.Ranking',
        'solicitacao.Bar',
        'solicitacao.Frequencia',
        'solicitacao.Barfrequencia',
        'solicitacao.TempoExecucao',
        'administracao.Log',
        'basedeconhecimento.Cadastrar',
        'basedeconhecimento.Listar',
        'basedeconhecimento.Ver'
     




    ],

    controllers: [
        'Main',
        'Solicitacao',
        'Departamento',
        'Servico',
        'Direcionamento',
        'Cliente',
        'Acompanhamento',
        'Basedeconhecimento',
        'Administracao'
     


    ],

    stores: [

       'Solicitacaos',
       'Statuss',
       'Departamentos',
       'Direcionamentos',
       'Prioridades',
       'Servicos',
       'Clientes',
       'Perfils',
       'Acompanhamentos',
       'Rankings',
       'Frequencias',
       'TempoExecucaos',
       'Logs',
       'Basedeconhecimentos'
       
    ]
});
