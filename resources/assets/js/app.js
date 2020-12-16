
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
Vue.config.devtools = true
require('./bootstrap');


window.$ = window.jQuery = require('jquery'); 

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('categoria', require('./components/Categoria.vue'));
Vue.component('ubicacion', require('./components/Ubicacion.vue'));
Vue.component('responsable', require('./components/Responsable.vue'));
Vue.component('articulo', require('./components/Articulo.vue'));
Vue.component('depreciacion', require('./components/Depreciacion.vue'));
Vue.component('rol', require('./components/Rol.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('respaldo', require('./components/Respaldo.vue'));
Vue.component('reportesgenerales', require('./components/reportesGenerales.vue'));
Vue.component('auditoria', require('./components/Auditoria.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('ayuda', require('./components/Ayuda.vue'));

const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }        
});
