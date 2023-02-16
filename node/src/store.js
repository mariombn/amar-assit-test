import { createStore } from 'vuex';

const store = createStore({
  state: {
    auth: {
      logged: false,
      name: null,
      token: null
    }
  },
  mutations: {
    login(state, payload) {
      state.auth.logged = true;
      state.auth.name = payload.name;
      state.auth.token = payload.token;
    },
    logoff(state) {
      state.auth.logged = false;
      state.auth.name = null;
      state.auth.token = null;
    }
  },
  actions: {
  },
  getters: {
  },
});

export default store;