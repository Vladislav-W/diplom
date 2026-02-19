import api from './api';

export const driverService = {
  async getAll() {
    try {
      const response = await api.get('/drivers');
      return response.data;
    } catch (error) {
      console.error('Ошибка при получении водителей:', error);
      throw error;
    }
  },

  async getById(id) {
    try {
      const response = await api.get(`/drivers/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении водителя ${id}:`, error);
      throw error;
    }
  },

  async create(data) {
    try {
      const response = await api.post('/drivers', data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при создании водителя:', error);
      throw error;
    }
  },

  async update(id, data) {
    try {
      const response = await api.put(`/drivers/${id}`, data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при обновлении водителя ${id}:`, error);
      throw error;
    }
  },

  async delete(id) {
    try {
      const response = await api.delete(`/drivers/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении водителя ${id}:`, error);
      throw error;
    }
  },

  async getByTabNumber(tabNumber) {
    try {
      const response = await api.get('/drivers', { params: { tab_number: tabNumber } });
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении водителя по табельному номеру ${tabNumber}:`, error);
      throw error;
    }
  }
};