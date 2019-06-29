import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store/modules/auth.js';
import middlewarePipeline from '../middleware/kernel/middlewarePipeline';
import Welcome from '../views/Welcome';
import Dashboard from '../views/Dashboard';
import Login from '../views/auth/Login';
import Register from '../views/auth/Register';
import PasswordEmail from '../views/auth/password/PasswordEmail';
import PasswordReset from '../views/auth/password/PasswordReset';

Vue.use(VueRouter);

const routes = [
  { path: '/', name: 'welcome', component: Welcome },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/dashboard', name: 'dashboard', component: Dashboard },
];

const router = new VueRouter({
  mode: 'history',
  routes: routes,
});

router.beforeEach((to, from, next) => {
  let middleware = to.matched
    .map(matched => {
      return matched.components.default.middleware;
    })
    .filter(middleware => {
      return middleware != undefined;
    })
    .flat();

  if (!middleware.length) {
    return next();
  }

  const context = {
    to,
    from,
    next,
    router,
    store,
  };

  return middleware[0]({ ...context, next: middlewarePipeline(context, middleware, 1) });
});

export default router;
