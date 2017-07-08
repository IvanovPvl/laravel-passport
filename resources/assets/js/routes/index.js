import Vue from 'vue';
import Router from 'vue-router';
import HomePage from '../components/page/HomePage.vue';
import PostDetailPage from '../components/page/PostDetailPage.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'HomePage',
      component: HomePage,
    },
    {
      path: '/post/:id',
      name: 'PostDetailPage',
      component: PostDetailPage,
    }
  ]
});