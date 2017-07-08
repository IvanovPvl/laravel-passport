import router from './routes';

require('./bootstrap');

Vue.component('post', require('./components/Post.vue'));
Vue.component('post-detail', require('./components/PostDetail.vue'));
Vue.component('comment', require('./components/Comment.vue'));

const app = new Vue({
  router,
  el: '#app'
});
