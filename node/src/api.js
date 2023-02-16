import axios from 'axios';
import store from './store';

const apiClient = axios.create({
  baseURL: 'http://127.0.0.1/api'
});

apiClient.interceptors.request.use(config => {
  const token = store.state.auth.token;
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default apiClient;