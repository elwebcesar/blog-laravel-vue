import { createStore } from 'vuex';
import axios from 'axios';

export default createStore({
  state: {
    token: null,
  },
  mutations: {
    SET_TOKEN(state, token) {
      state.token = token;
    },
    CLEAR_TOKEN(state) {
      state.token = null;
    },
  },
  actions: {
    async login({ commit }, { email, password }) {
      try {
        const response = await axios.post('/api/v1/auth/login', {
          email,
          password,
        });
        console.log('Respuesta del servidor:', response.data); // Depuración
        const resultado = response.data.resultado;
        if (resultado && resultado.data && resultado.data.token) {
          const token = resultado.data.token;
          commit('SET_TOKEN', token);
          localStorage.setItem('token', token);
          return token;
        } else {
          throw new Error('Estructura de respuesta inválida: Token no encontrado');
        }
      } catch (error) {
        let errorMessage = 'Error al iniciar sesión';
        if (error.response) {
          errorMessage = error.response.data.message || error.response.data.resultado?.message || 'Error en la solicitud';
          console.error('Respuesta de error del servidor:', error.response.data); // Depuración
        } else if (error.request) {
          errorMessage = 'No se pudo conectar con el servidor';
        } else {
          errorMessage = error.message;
        }
        console.error('Error al iniciar sesión:', errorMessage);
        throw new Error(errorMessage);
      }
    },
    logout({ commit }, { router }) {
      commit('CLEAR_TOKEN');
      localStorage.removeItem('token');
      router.push('/'); // Redirect to root
    },
  },
  getters: {
    isAuthenticated: state => !!state.token,
    token: state => state.token,
  },
});
