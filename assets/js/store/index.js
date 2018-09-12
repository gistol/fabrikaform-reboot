import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    menu: {
      isSet: false,
      items: []
    }
  },

  getters: {
    menuIsSet: state => {
      return state.menu.isSet;
    },
    menuItems: state => {
      return state.menu.items;
    }
  },

  // sync
  mutations: {
    setMenuItems(state, payload) {
      state.menu.items = payload;
      if (!state.menu.isSet) {
        state.menu.isSet = true;
      }
    }
  },

  // async
  actions: {}
});
