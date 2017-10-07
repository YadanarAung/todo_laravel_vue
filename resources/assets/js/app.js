
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.VueRouter=require('vue-router').default;
let AppLayout= require('./components/App.vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const todolist = Vue.component('todo-list', require('./components/todo-list.vue'));
const tododetail = Vue.component('todo-detail', require('./components/todo-detail.vue'));
const todoedit = Vue.component('todo-edit', require('./components/todo-edit.vue'));



const routes = [
  {
      name: 'list',
      path: '/',
      component: todolist
  }
  ,
  {
      name: 'edit',
      path: '/edit/:id',
      component: todoedit
  },
  {
      name: 'detail',
      path: '/detail/:id',
      component: tododetail
  }
];


const router = new VueRouter({ mode: 'hash', routes: routes});

// registering Modules
Vue.use(VueRouter);

new Vue(
	Vue.util.extend(
			{ router },
			 AppLayout
	)
).$mount('#app');
