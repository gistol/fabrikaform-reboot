import Vue from 'vue';
import Router from 'vue-router';

import Intro from '../components/Intro';
import Menu from '../components/Menu';
import Media from '../components/Media';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Intro',
      component: Intro
    },
    {
      path: '/menu',
      name: 'Menu',
      component: Menu
    },
    {
      path: '/media/:id',
      name: 'Media',
      component: Media
    }
  ]
});
