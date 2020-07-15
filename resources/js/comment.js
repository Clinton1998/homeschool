require('./bootstrap');
window.Vue = require('vue');
Vue.component('comment-app',require('./components/comment/CommentApp.vue').default);
const comentario = new Vue({
    el:'#vue-comentario',
});
