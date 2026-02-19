import api from './api';

export const distanceService = {
  async getAll() {
    const response = await api.get('/distances');
    return response.data;
  },

  async getById(id) {
    const response = await api.get(`/distances/${id}`);
    return response.data;
  },

  async create(data) {
    const response = await api.post('/distances', data);
    return response.data;
  },

  async update(id, data) {
    const response = await api.put(`/distances/${id}`, data);
    return response.data;
  },

  async delete(id) {
    const response = await api.delete(`/distances/${id}`);
    return response.data;
  },

  async getDistanceBetweenCities(fromCityId, toCityId) {
    const response = await api.get('/distances', { 
      params: { from: fromCityId, to: toCityId } 
    });
    return response.data;
  }
};