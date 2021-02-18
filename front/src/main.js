import Vue from 'vue'
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import NProgress from 'nprogress';

import App from './App.vue';
import Home from './components/Home';
import Cart from './components/Cart';
import Cozinha from './components/Cozinha';

import '../node_modules/bootstrap/dist/css/bootstrap.min.css';
import '../node_modules/nprogress/nprogress.css';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

Vue.config.productionTip = false
const routes = [
  {
    name: 'Home',
    path: '/',
    component: Home
  },
  {
    name: 'Cozinha',
    path: '/cozinha',
    component: Cozinha
  },
  {
    name: 'Cart',
    path: '/cart',
    component: Cart
  },
];

const router = new VueRouter({ mode: 'history', routes: routes });

router.beforeResolve((to, from, next) => {
  if (to.name) {
      NProgress.start()
  }
  next()
});

router.afterEach(() => {
  NProgress.done()
});

new Vue({
  render: h => h(App),
  router
}).$mount('#app')