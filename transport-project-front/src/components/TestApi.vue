<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <h2 class="text-h5 mb-4">Тест связи с API</h2>
        
        <v-btn 
          color="primary" 
          @click="testConnection"
          :loading="loading"
          class="mb-4"
        >
          Проверить связь
        </v-btn>

        <v-alert
          v-if="message"
          :type="alertType"
          dismissible
        >
          {{ message }}
        </v-alert>

        <v-card v-if="cities.length > 0" class="mt-4">
          <v-card-title>Города из базы данных:</v-card-title>
          <v-list>
            <v-list-item v-for="city in cities" :key="city.id">
              <v-list-item-content>
                <v-list-item-title>{{ city.name }}</v-list-item-title>
                <v-list-item-subtitle>ID: {{ city.id }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { cityService } from '@/services/cityService';

export default {
  data() {
    return {
      loading: false,
      message: '',
      alertType: 'info',
      cities: []
    };
  },
  methods: {
    async testConnection() {
      this.loading = true;
      this.message = '';
      this.cities = [];
      
      try {
        // Пробуем получить список городов
        const data = await cityService.getAll();
        
        // Проверяем формат ответа (может быть разным в зависимости от Resource)
        if (data.data) {
          // Если используется RequestResource::collection()
          this.cities = data.data;
        } else if (Array.isArray(data)) {
          // Если просто массив
          this.cities = data;
        } else {
          this.cities = [data];
        }
        
        this.message = 'Связь с API работает!';
        this.alertType = 'success';
      } catch (error) {
        this.message = 'Ошибка связи с API: ' + (error.message || 'Неизвестная ошибка');
        this.alertType = 'error';
        console.error('Детали ошибки:', error);
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>