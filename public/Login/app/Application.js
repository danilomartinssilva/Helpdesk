Ext.define('Login.Application', {
    name: 'Login',

    extend: 'Ext.app.Application',

    views: [
        'login.Login',
        'login.Cadastrar'
    ],

    controllers: [
        'Login'
    ],

    stores: [
        'Clientes',
        'Departamentos'
    ]
});
