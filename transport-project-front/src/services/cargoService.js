import api from './api';

// Функция для парсинга JSON-строки с удалением BOM
const parseJsonIfNeeded = (data) => {
  if (typeof data === 'string') {
    try {
      return JSON.parse(data.replace(/^\uFEFF/, ''));
    } catch (e) {
      console.error('Ошибка парсинга JSON:', e);
      return data;
    }
  }
  return data;
};

export const cargoService = {
  async getAll() {
    try {
      const response = await api.get('/cargo');
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при получении грузов:', error);
      throw error;
    }
  },

  async getById(id) {
    try {
      const response = await api.get(`/cargo/${id}`);
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении груза ${id}:`, error);
      throw error;
    }
  },

  async create(data) {
    try {
      const response = await api.post('/cargo', data);
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при создании груза:', error);
      throw error;
    }
  },

  async update(id, data) {
    try {
      const response = await api.put(`/cargo/${id}`, data);
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при обновлении груза ${id}:`, error);
      throw error;
    }
  },

  async delete(id) {
    try {
      const response = await api.delete(`/cargo/${id}`);
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении груза ${id}:`, error);
      throw error;
    }
  }
};