import api from './api';

export const responsiblePersonService = {
    async getAll() {
        try {
            const response = await api.get('/responsible-people');
            console.log('responsiblePersonService.getAll response:', response);
            
            if (typeof response.data === 'string') {
                try {
                    const cleanData = response.data.replace(/^\uFEFF/, '').trim();
                    console.log('Clean data string:', cleanData.substring(0, 100));
                    const parsed = JSON.parse(cleanData);
                    return parsed;
                } catch (e) {
                    console.error('Ошибка парсинга JSON:', e);
                    return { data: [] };
                }
            }
            
            return response.data;
        } catch (error) {
            console.error('Ошибка при получении ответственных лиц:', error);
            throw error;
        }
    },

    async getById(id) {
        try {
            const response = await api.get(`/responsible-people/${id}`);
            return response.data;
        } catch (error) {
            console.error(`Ошибка при получении ответственного лица ${id}:`, error);
            throw error;
        }
    },

    async create(data) {
        try {
            const response = await api.post('/responsible-people', data);
            return response.data;
        } catch (error) {
            console.error('Ошибка при создании ответственного лица:', error);
            throw error;
        }
    },

    async update(id, data) {
        try {
            const response = await api.put(`/responsible-people/${id}`, data);
            return response.data;
        } catch (error) {
            console.error(`Ошибка при обновлении ответственного лица ${id}:`, error);
            throw error;
        }
    },

    async delete(id) {
        try {
            const response = await api.delete(`/responsible-people/${id}`);
            return response.data;
        } catch (error) {
            console.error(`Ошибка при удалении ответственного лица ${id}:`, error);
            throw error;
        }
    }
};