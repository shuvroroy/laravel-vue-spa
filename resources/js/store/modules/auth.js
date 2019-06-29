import Cookies from 'js-cookie';

const state = {
  authUser: null,
  token: Cookies.get('token'),
};

const getters = {
  user(state) {
    return state.authUser;
  },
};

const actions = {
  register({ dispatch }, { payload }) {
    return axios.post('/api/v1/register', payload).then(response => {
      dispatch('setToken', {
        token: response.data.meta.token,
        remember: false,
      }).then(() => {
        dispatch('fetchUser');
      });
    });
  },
  login({ dispatch }, { payload }) {
    return axios.post('/api/v1/login', payload).then(response => {
      dispatch('setToken', {
        token: response.data.meta.token,
        remember: payload.remember,
      }).then(() => {
        dispatch('fetchUser');
      });
    });
  },
  logout({ commit }) {
    return axios.post('/api/v1/logout').then(response => {
      commit('logout');
    });
  },
  setToken({ commit, dispatch }, { token, remember }) {
    commit('setToken', { token, remember });
  },
  fetchUser({ commit }) {
    return axios
      .get('/api/v1/user')
      .then(response => {
        commit('setUser', response.data);
      })
      .catch(error => {
        commit('removeToken');
      });
  },
};

const mutations = {
  setToken(state, { token, remember }) {
    Cookies.set('token', token, { expires: remember ? 365 : null });
  },
  removeToken(state) {
    Cookies.remove('token');
  },
  setUser(state, user) {
    state.authUser = user;
  },
  logout(state) {
    state.user = null;
    state.token = null;

    Cookies.remove('token');
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
