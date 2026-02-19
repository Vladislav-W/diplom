import api from './api';

export const cityService = {
  async getAll() {
    try {
      const response = await api.get('/cities');
      console.log('cityService.getAll response:', response);
      
      // Если response.data - строка, парсим её
      if (typeof response.data === 'string') {
        try {
          // Удаляем BOM-символ если есть
          const cleanData = response.data.replace(/^\uFEFF/, '');
          const parsed = JSON.parse(cleanData);
          return parsed;
        } catch (e) {
          console.error('Ошибка парсинга JSON:', e);
          return { data: [] };
        }
      }
      
      return response.data;
    } catch (error) {
      console.error('Ошибка при получении городов:', error);
      throw error;
    }
  },

  async getById(id) {
    try {
      const response = await api.get(`/cities/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении города ${id}:`, error);
      throw error;
    }
  },

  async create(data) {
    try {
      const response = await api.post('/cities', data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при создании города:', error);
      throw error;
    }
  },

  async update(id, data) {
    try {
      const response = await api.put(`/cities/${id}`, data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при обновлении города ${id}:`, error);
      throw error;
    }
  },

  async delete(id) {
    try {
      const response = await api.delete(`/cities/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении города ${id}:`, error);
      throw error;
    }
  }
};