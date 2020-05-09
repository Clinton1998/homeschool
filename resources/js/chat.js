
require('./bootstrap');

window.Vue = require('vue');

Vue.component('chat-app', require('./components/chat/ChatApp.vue').default);
const chat = new Vue({
    el: '#chat',
    
});
