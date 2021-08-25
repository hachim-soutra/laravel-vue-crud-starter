export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/products', component: require('./components/product/Products.vue').default },
    { path: '/consumers', component: require('./components/consumer/Consumer.vue').default },
    { path: '/consumers/add', component: require('./components/consumer/ConsumerAdd.vue').default },

    { path: '/orders', component: require('./components/order/index.vue').default , name: "order.index" },
    { path: '/order/add', component: require('./components/order/new.vue').default , name: "order.add" },
    { path: '/orders/:id/show', component: require('./components/order/show.vue').default , name: "order.show" },

    { path: '/sources/build/:id', component: require('./components/source/build.vue').default , name: "source.build" },
    { path: '/sources', component: require('./components/source/list.vue').default , name: "source.index" },
    { path: '/sources/add', component: require('./components/source/new.vue').default , name: "source.add" },

    { path: '/shipping/delivery/:id', component: require('./components/shipping/DeliveryMen.vue').default , name: "shipping.delivery.Men" },
    { path: '/shippings/men', component: require('./components/shipping/Men.vue').default , name: "shipping.company" },
    { path: '/shippings/company', component: require('./components/shipping/Company.vue').default , name: "shipping.men" },
    { path: '/shipping/:type/add', component: require('./components/shipping/add.vue').default , name: "shipping.new" },
    { path: '/orders/:action/:id?', component: require('./components/order/new.vue').default, name: "order.name" },

    { path: '/product/tag', component: require('./components/product/Tag.vue').default },
    { path: '/product/category', component: require('./components/product/Category.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
