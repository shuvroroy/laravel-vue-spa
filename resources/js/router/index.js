import Vue from 'vue';
import VueRouter from 'vue-router';
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
  { path: '/password/reset', name: 'password.request', component: PasswordReset },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/dashboard', name: 'dashboard', component: Dashboard },
];

export default new VueRouter({
  mode: 'history',
  routes: routes,
});
