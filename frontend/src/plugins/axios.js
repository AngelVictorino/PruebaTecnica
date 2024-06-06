import axios from 'axios';

// Establece la URL base para las solicitudes
axios.defaults.baseURL = 'http://localhost/PruebaTecnica/public';  // Cambia esto a la URL de tu API

// Configura un interceptor de solicitudes para agregar el token a todas las solicitudes
axios.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

export default axios;
