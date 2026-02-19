import api from './api';

export const distanceService = {
  async getAll() {
    try {
      const response = await api.get('/distances');
      return response.data;
    } catch (error) {
      console.error('Ошибка при получении расстояний:', error);
      throw error;
    }
  },

  async getById(id) {
    try {
      const response = await api.get(`/distances/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении расстояния ${id}:`, error);
      throw error;
    }
  },

  async create(data) {
    try {
      const response = await api.post('/distances', data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при создании расстояния:', error);
      throw error;
    }
  },

  async update(id, data) {
    try {
      const response = await api.put(`/distances/${id}`, data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при обновлении расстояния ${id}:`, error);
      throw error;
    }
  },

  async delete(id) {
    try {
      const response = await api.delete(`/distances/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении расстояния ${id}:`, error);
      throw error;
    }
  },

  async getDistanceBetweenCities(fromCityId, toCityId) {
    try {
      const response = await api.get('/distances', { 
        params: { from: fromCityId, to: toCityId } 
      });
      return response.data;
    } catch (error) {
      console.error('Ошибка при получении расстояния между городами:', error);
      throw error;
    }
  }
};