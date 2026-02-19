import api from './api';

export const fileService = {
  async upload(requestId, file) {
    try {
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
    } catch (error) {
      console.error(`Ошибка при загрузке файла ${file.name}:`, error);
      throw error;
    }
  },

  async getFiles(requestId) {
    try {
      const response = await api.get(`/requests/${requestId}/files`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при получении файлов заявки ${requestId}:`, error);
      throw error;
    }
  },

  async download(fileId) {
    try {
      const response = await api.get(`/files/${fileId}/download`, {
        responseType: 'blob'
      });
      return response.data;
    } catch (error) {
      console.error(`Ошибка при скачивании файла ${fileId}:`, error);
      throw error;
    }
  },

  async delete(fileId) {
    try {
      const response = await api.delete(`/files/${fileId}`);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении файла ${fileId}:`, error);
      throw error;
    }
  }
};