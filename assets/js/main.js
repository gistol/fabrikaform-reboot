import Vue from 'vue';
import store from './store';
import router from './router';
import App from './App';

new Vue({
  el: '#app',
  store,
  router,
  template: '<App/>',
  components: { App }
});
