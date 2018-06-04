// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
require('./bootstrap');

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './pages/App'
import router from './router'
import { Pagination } from 'bootstrap-vue/es/components';

Vue.use(BootstrapVue)
Vue.use(Pagination);

Vue.router = router
Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
    tokenExpired : function () { return false; }
});

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    template: '<App/>',
    components: {
        App
    }
})
