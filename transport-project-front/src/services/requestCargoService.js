import api from './api';

export const requestCargoService = {
  async create(data) {
    try {
      const response = await api.post('/request-cargo', data);
      return response.data;
    } catch (error) {
      console.error('Ошибка при привязке груза к заявке:', error);
      throw error;
    }
  },

  async delete(requestId, cargoId) {
    try {
      const response = await api.delete(`/request-cargo/${requestId}/${cargoId}`);
      return response.data;
    } catch (error) {
      console.error('Ошибка при удалении груза из заявки:', error);
      throw error;
    }
  }
};