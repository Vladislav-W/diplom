import api from './api';

export const requestService = {
  async create(data) {
    try {
      console.log('📤 requestService.create отправка:', data)
      const response = await api.post('/requests', data)
      console.log('📥 requestService.create ответ:', response)
      return response.data
    } catch (error) {
      console.error('❌ requestService.create ошибка:', error)
      if (error.response) {
        console.error('❌ Статус ошибки:', error.response.status)
        console.error('❌ Данные ошибки:', error.response.data)
      }
      throw error
    }
  },
  
  async getAll(params = {}) {
    try {
      const response = await api.get('/requests', { params });
      return response.data;
    } catch (error) {
      console.error('Ошибка при получении заявок:', error);
      throw error;
    }
  },

  async getById(id) {
    try {
      const response = await api.get(`/requests/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении заявки ${id}:`, error);
      throw error;
    }
  },

  async update(id, data) {
    try {
      const response = await api.put(`/requests/${id}`, data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при обновлении заявки ${id}:`, error);
      throw error;
    }
  },

  async delete(id) {
    try {
      const response = await api.delete(`/requests/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении заявки ${id}:`, error);
      throw error;
    }
  },

  async updateStatus(id, status) {
    try {
      const response = await api.patch(`/requests/${id}/status`, { status });
      return response.data;
    } catch (error) {
      console.error(`Ошибка при обновлении статуса заявки ${id}:`, error);
      throw error;
    }
  }
};