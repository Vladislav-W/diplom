import api from './api';

export const autoParkService = {
  async getAll() {
    try {
      const response = await api.get('/auto-park');
      return response.data;
    } catch (error) {
      console.error('Ошибка при получении автопарка:', error);
      throw error;
    }
  },

  async getById(id) {
    try {
      const response = await api.get(`/auto-park/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении автомобиля ${id}:`, error);
      throw error;
    }
  },

  async create(data) {
    try {
      const response = await api.post('/auto-park', data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при создании автомобиля:', error);
      throw error;
    }
  },

  async update(id, data) {
    try {
      const response = await api.put(`/auto-park/${id}`, data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при обновлении автомобиля ${id}:`, error);
      throw error;
    }
  },

  async delete(id) {
    try {
      const response = await api.delete(`/auto-park/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении автомобиля ${id}:`, error);
      throw error;
    }
  },

  async getByDriver(tabNumber) {
    try {
      const response = await api.get('/auto-park', { params: { driver_tab: tabNumber } });
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении автомобиля водителя ${tabNumber}:`, error);
      throw error;
    }
  }
};