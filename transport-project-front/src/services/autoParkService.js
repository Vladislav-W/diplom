import api from './api';

export const autoParkService = {
  async getAll() {
    const response = await api.get('/auto-park');
    return response.data;
  },

  async getById(id) {
    const response = await api.get(`/auto-park/${id}`);
    return response.data;
  },

  async create(data) {
    const response = await api.post('/auto-park', data);
    return response.data;
  },

  async update(id, data) {
    const response = await api.put(`/auto-park/${id}`, data);
    return response.data;
  },

  async delete(id) {
    const response = await api.delete(`/auto-park/${id}`);
    return response.data;
  },

  async getByDriver(tabNumber) {
    const response = await api.get('/auto-park', { params: { driver_tab: tabNumber } });
    return response.data;
  }
};