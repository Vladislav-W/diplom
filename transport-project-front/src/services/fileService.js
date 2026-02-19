import api from './api';

export const fileService = {
  async upload(requestId, file) {
    const formData = new FormData();
    formData.append('file', file);
    
    const response = await api.post(`/requests/${requestId}/files`, formData, {
      headers: { 
        'Content-Type': 'multipart/form-data'
      },
      onUploadProgress: (progressEvent) => {
        const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
        console.log(`Прогресс загрузки ${file.name}: ${percentCompleted}%`);
      }
    });
    return response.data;
  },

  async getFiles(requestId) {
    const response = await api.get(`/requests/${requestId}/files`);
    return response.data;
  },

  async download(fileId) {
    const response = await api.get(`/files/${fileId}/download`, {
      responseType: 'blob'
    });
    return response.data;
  },

  async delete(fileId) {
    const response = await api.delete(`/files/${fileId}`);
    return response.data;
  }
};