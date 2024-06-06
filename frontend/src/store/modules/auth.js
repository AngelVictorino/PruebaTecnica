// src/store/modules/auth.js
import axios from 'axios';

const state = {
  isAuthenticated: false,
  user: null,
};

const mutations = {
  SET_AUTHENTICATED(state, isAuthenticated) {
    state.isAuthenticated = isAuthenticated;
  },
  SET_USER(state, user) {
    state.user = user;
  },
};

const actions = {
  async login({ commit }, { username, password }) {
    try {
      const response = await axios.post('http://localhost/PruebaTecnica/public/login', { username, password });
      const user = response.data.user; // Suponiendo que la respuesta de la API contiene el usuario
      commit('SET_AUTHENTICATED', true);
      commit('SET_USER', user);
    } catch (error) {
      console.error('Error de autenticación:', error);
      throw error; // Puedes manejar el error de otra forma si lo prefieres
    }
  },
  logout({ commit }) {
    // Aquí podrías hacer una petición a la API para cerrar sesión
    // Por ejemplo, limpiar el token del localStorage
    commit('SET_AUTHENTICATED', false);
    commit('SET_USER', null);
  },
};

const getters = {
  isAuthenticated: state => state.isAuthenticated,
  user: state => state.user,
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
