import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    isLoading: true,
    menu: {
      isSet: false,
      items: []
    }
  },

  getters: {
    isLoading: state => {
      return state.isLoading;
    },

    menuIsSet: state => {
      return state.menu.isSet;
    },

    menuItems: state => {
      return state.menu.items;
    }
  },

  // sync
  mutations: {
    setLoadingState(state, payload) {
      state.isLoading = payload;
    },

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
