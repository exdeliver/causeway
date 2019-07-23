module.exports = [
    {
        path: '/',
        component: require('../routes/ExampleComponent').default,
        name: 'home'
    },
    {
        path: '/user',
        component: require('../routes/User').default,
        name: 'user'
    }
];