import axios from 'axios';

const API_URL = process.env.VUE_APP_API_URL || 'http://127.0.0.1:8000/api/v1';

const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Добавляем перехватчик для логирования запросов
api.interceptors.request.use(
  (config) => {
    console.log('Запрос:', config.method.toUpperCase(), config.url);
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Добавляем перехватчик для ответов
api.interceptors.response.use(
  (response) => {
    console.log('Ответ:', response.status, response.config.url);
    return response;
  },
  (error) => {
    console.error('Ошибка API:', error.response?.status, error.response?.data);
    return Promise.reject(error);
  }
);

export default api;