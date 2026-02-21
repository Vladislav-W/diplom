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

export const fileService = {
  async upload(requestId, file) {
    try {
      const formData = new FormData();
      formData.append('request_id', requestId);
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
      
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при загрузке файла ${file.name}:`, error);
      throw error;
    }
  },

  async getFiles(requestId) {
    try {
      const response = await api.get(`/requests/${requestId}/files`);
      response.data = parseJsonIfNeeded(response.data);
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
      response.data = parseJsonIfNeeded(response.data);
      return response.data;
    } catch (error) {
      console.error(`Ошибка при удалении файла ${fileId}:`, error);
      throw error;
    }
  }
};