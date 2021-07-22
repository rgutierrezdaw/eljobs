require('./bootstrap');
   

window.Vue = require('vue').default;

Vue.component('form-component', require('./components/form.vue').default);

const app = new Vue({
    el: '#app',  
});
