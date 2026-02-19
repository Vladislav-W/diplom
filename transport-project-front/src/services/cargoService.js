import api from './api';

export const cargoService = {
  async getAll() {
    try {
      const response = await api.get('/cargo');
      return response.data;
    } catch (error) {
      console.error('Ошибка при получении грузов:', error);
      throw error;
    }
  },

  async getById(id) {
    try {
      const response = await api.get(`/cargo/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении груза ${id}:`, error);
      throw error;
    }
  },

  async create(data) {
    try {
      const response = await api.post('/cargo', data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при создании груза:', error);
      throw error;
    }
  },

  async update(id, data) {
    try {
      const response = await api.put(`/cargo/${id}`, data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при обновлении груза ${id}:`, error);
      throw error;
    }
  },

  async delete(id) {
    try {
      const response = await api.delete(`/cargo/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении груза ${id}:`, error);
      throw error;
    }
  }
};