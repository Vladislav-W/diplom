import api from './api';

export const organizationService = {
  async getAll() {
    try {
      const response = await api.get('/organizations');
      console.log('organizationService.getAll response:', response);
      
      if (typeof response.data === 'string') {
        try {
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
      console.error('Ошибка при получении организаций:', error);
      throw error;
    }
  },

  async getById(id) {
    try {
      const response = await api.get(`/organizations/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении организации ${id}:`, error);
      throw error;
    }
  },

  async create(data) {
    try {
      const response = await api.post('/organizations', data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при создании организации:', error);
      throw error;
    }
  },

  async update(id, data) {
    try {
      const response = await api.put(`/organizations/${id}`, data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при обновлении организации ${id}:`, error);
      throw error;
    }
  },

  async delete(id) {
    try {
      const response = await api.delete(`/organizations/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении организации ${id}:`, error);
      throw error;
    }
  }
};