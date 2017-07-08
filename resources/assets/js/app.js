import router from './routes';

require('./bootstrap');

Vue.component('post', require('./components/Post.vue'));

const app = new Vue({
  router,
  el: '#app'
});
