import api from './api';

export const driverService = {
  async getAll() {
    const response = await api.get('/drivers');
    return response.data;
  },

  async getById(id) {
    const response = await api.get(`/drivers/${id}`);
    return response.data;
  },

  async create(data) {
    const response = await api.post('/drivers', data);
    return response.data;
  },

  async update(id, data) {
    const response = await api.put(`/drivers/${id}`, data);
    return response.data;
  },

  async delete(id) {
    const response = await api.delete(`/drivers/${id}`);
    return response.data;
  },

  async getByTabNumber(tabNumber) {
    const response = await api.get('/drivers', { params: { tab_number: tabNumber } });
    return response.data;
  }
};