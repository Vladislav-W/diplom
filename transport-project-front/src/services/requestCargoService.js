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

export const requestCargoService = {
  async create(data) {
    try {
      const response = await api.post('/request-cargo', data);
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при привязке груза к заявке:', error);
      throw error;
    }
  },

  async delete(requestId, cargoId) {
    try {
      const response = await api.delete(`/request-cargo/${requestId}/${cargoId}`);
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при удалении груза из заявки:', error);
      throw error;
    }
  }
};