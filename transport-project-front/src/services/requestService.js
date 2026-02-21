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

export const requestService = {
  async create(data) {
    try {
      console.log('requestService.create отправка:', data)
      const response = await api.post('/requests', data)
      console.log('requestService.create ответ:', response)
      
      // Если response.data - строка (JSON), парсим её
      response.data = parseJsonIfNeeded(response.data);
      
      return response.data
    } catch (error) {
      console.error('requestService.create ошибка:', error)
      if (error.response) {
        console.error('Статус ошибки:', error.response.status)
        console.error('Данные ошибки:', error.response.data)
      }
      throw error
    }
  },

  async getAll(params = {}) {
    try {
      console.log('requestService.getAll запрос с параметрами:', params)
      const response = await api.get('/requests', { params });
      console.log('requestService.getAll ответ:', response)
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error('requestService.getAll ошибка:', error)
      if (error.response) {
        console.error('Статус ошибки:', error.response.status)
        console.error('Данные ошибки:', error.response.data)
      }
      throw error;
    }
  },

  async getById(id) {
    try {
      console.log(`requestService.getById запрос для ID: ${id}`)
      const response = await api.get(`/requests/${id}`);
      console.log(`requestService.getById ответ для ID ${id}:`, response)
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error(`requestService.getById ошибка для ID ${id}:`, error)
      if (error.response) {
        console.error('Статус ошибки:', error.response.status)
        console.error('Данные ошибки:', error.response.data)
      }
      throw error;
    }
  },

  async update(id, data) {
    try {
      console.log(`requestService.update запрос для ID ${id}:`, data)
      const response = await api.put(`/requests/${id}`, data);
      console.log(`requestService.update ответ для ID ${id}:`, response)
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error(`requestService.update ошибка для ID ${id}:`, error)
      if (error.response) {
        console.error('Статус ошибки:', error.response.status)
        console.error('Данные ошибки:', error.response.data)
      }
      throw error;
    }
  },

  async delete(id) {
    try {
      console.log(`requestService.delete запрос для ID: ${id}`)
      const response = await api.delete(`/requests/${id}`);
      console.log(`requestService.delete ответ для ID ${id}:`, response)
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error(`requestService.delete ошибка для ID ${id}:`, error)
      if (error.response) {
        console.error('Статус ошибки:', error.response.status)
        console.error('Данные ошибки:', error.response.data)
      }
      throw error;
    }
  },

  async updateStatus(id, status) {
    try {
      console.log(`requestService.updateStatus запрос для ID ${id}:`, { status })
      const response = await api.patch(`/requests/${id}/status`, { status });
      console.log(`requestService.updateStatus ответ для ID ${id}:`, response)
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error(`requestService.updateStatus ошибка для ID ${id}:`, error)
      if (error.response) {
        console.error('Статус ошибки:', error.response.status)
        console.error('Данные ошибки:', error.response.data)
      }
      throw error;
    }
  }
};