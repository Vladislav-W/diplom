<template>
  <v-container fluid class="pa-4">
    <v-row class="mb-4">
      <v-col cols="12">
        <h1 class="text-h4 font-weight-bold" style="color: #1976d2">
          ЗАВЕРШЕННЫЕ ЗАЯВКИ
        </h1>
        <v-divider class="mt-2" style="border-color: #1976d2; border-width: 2px;"></v-divider>
      </v-col>
    </v-row>

    <!-- Индикатор загрузки -->
    <div v-if="loading" class="text-center pa-4">
      <v-progress-circular indeterminate color="primary"></v-progress-circular>
      <p class="mt-2">Загрузка заявок...</p>
    </div>

    <!-- Ошибка загрузки -->
    <v-alert v-else-if="error" type="error" class="mb-4">
      {{ error }}
    </v-alert>

    <!-- Контент -->
    <template v-else>
      <!-- Фильтры -->
      <v-row class="mb-4">
        <v-col cols="12" sm="4">
          <v-text-field
            v-model="search"
            label="Поиск"
            placeholder="Номер заявки, груз..."
            prepend-inner-icon="mdi-magnify"
            outlined
            dense
            hide-details
            @input="applyFilters"
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="3">
          <v-select
            v-model="statusFilter"
            :items="statuses"
            label="Статус"
            outlined
            dense
            hide-details
            @change="applyFilters"
          ></v-select>
        </v-col>
        <v-col cols="12" sm="2" class="d-flex align-center">
          <v-btn color="primary" @click="applyFilters" :loading="loading">
            <v-icon left>mdi-filter</v-icon>
            Применить
          </v-btn>
        </v-col>
      </v-row>

      <!-- Краткая статистика -->
      <v-row class="mb-4">
        <v-col cols="12" sm="6">
          <v-card class="pa-3" color="success" dark>
            <v-row no-gutters align="center">
              <v-col cols="auto" class="mr-3">
                <v-icon large>mdi-check-circle</v-icon>
              </v-col>
              <v-col>
                <div class="text-h6">Согласовано</div>
                <div class="text-h5">{{ approvedCount }}</div>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6">
          <v-card class="pa-3" color="error" dark>
            <v-row no-gutters align="center">
              <v-col cols="auto" class="mr-3">
                <v-icon large>mdi-cancel</v-icon>
              </v-col>
              <v-col>
                <div class="text-h6">Отменено</div>
                <div class="text-h5">{{ cancelledCount }}</div>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>

      <!-- Таблица заявок -->
      <v-data-table
        :headers="headers"
        :items="filteredRequests"
        :items-per-page="itemsPerPage"
        :page="page"
        :loading="loading"
        class="elevation-1"
      >
        <!-- Статус с цветным индикатором -->
        <template slot="item.status" slot-scope="{ item }">
          <v-chip
            :color="getStatusColor(item.status)"
            small
            dark
          >
            {{ item.status }}
          </v-chip>
        </template>

        <!-- Кнопки действий -->
        <template slot="item.actions" slot-scope="{ item }">
          <v-btn
            icon
            small
            color="primary"
            @click="viewRequest(item)"
            class="mr-1"
          >
            <v-icon small>mdi-eye</v-icon>
          </v-btn>
          <v-btn
            icon
            small
            color="error"
            @click="deleteRequest(item)"
          >
            <v-icon small>mdi-delete</v-icon>
          </v-btn>
        </template>

        <!-- Сообщение при отсутствии данных -->
        <template slot="no-data">
          <div class="text-center pa-4">
            <v-icon size="48" color="grey lighten-1">mdi-clipboard-text-outline</v-icon>
            <p class="text-h6 grey--text mt-2">Нет завершенных заявок</p>
            <v-btn color="primary" @click="$router.push('/new-request')">
              <v-icon left>mdi-plus</v-icon>
              Создать новую заявку
            </v-btn>
          </div>
        </template>
      </v-data-table>

      <!-- Пагинация -->
      <v-row class="mt-4 justify-end">
        <v-col cols="auto">
          <v-pagination
            v-model="page"
            :length="pageCount"
            :total-visible="5"
            size="small"
          ></v-pagination>
        </v-col>
      </v-row>

      <!-- Кнопка формирования маршрута -->
      <v-row class="mt-6">
        <v-col cols="12" class="text-center">
          <v-btn
            color="success"
            x-large
            @click="generateRoute"
            :disabled="approvedCount === 0"
          >
            <v-icon left large>mdi-route</v-icon>
            СФОРМИРОВАТЬ МАРШРУТ
          </v-btn>
          <div v-if="approvedCount === 0" class="text-caption grey--text mt-2">
            Для формирования маршрута необходима хотя бы одна согласованная заявка
          </div>
        </v-col>
      </v-row>
    </template>
  </v-container>
</template>

<script>
import { requestService } from '@/services/requestService';

export default {
  name: 'RequestsPage',
  data() {
    return {
      search: '',
      statusFilter: 'Все',
      loading: false,
      error: null,
      page: 1,
      itemsPerPage: 10,
      statuses: ['Все', 'Согласована', 'Отменена'],
      headers: [
        { text: 'Номер', value: 'number', align: 'start', width: '100' },
        { text: 'Дата', value: 'created_at', align: 'start', width: '120' },
        { text: 'Груз', value: 'cargo', align: 'start' },
        { text: 'Откуда', value: 'from', align: 'start' },
        { text: 'Куда', value: 'to', align: 'start' },
        { text: 'Статус', value: 'status', align: 'center', width: '130' },
        { text: 'Действия', value: 'actions', align: 'center', sortable: false, width: '100' }
      ],
      requests: [] // Здесь будут данные из API
    };
  },
  computed: {
    // Фильтрация на фронтенде (можно перенести на бэкенд позже)
    filteredRequests() {
      let result = this.requests;

      if (this.search) {
        const searchLower = this.search.toLowerCase();
        result = result.filter(r => 
          (r.number?.toLowerCase() || '').includes(searchLower) ||
          (r.cargo?.toLowerCase() || '').includes(searchLower) ||
          (r.from?.toLowerCase() || '').includes(searchLower) ||
          (r.to?.toLowerCase() || '').includes(searchLower)
        );
      }

      if (this.statusFilter !== 'Все') {
        result = result.filter(r => r.status === this.statusFilter);
      }

      return result;
    },
    pageCount() {
      return Math.ceil(this.filteredRequests.length / this.itemsPerPage);
    },
    approvedCount() {
      return this.requests.filter(r => r.status === 'Согласована').length;
    },
    cancelledCount() {
      return this.requests.filter(r => r.status === 'Отменена').length;
    }
  },
  methods: {
    async loadRequests() {
      this.loading = true;
      this.error = null;
      
      try {
        // Параметры запроса
        const params = {
          status: 'Согласована,Отменена',
          per_page: 100 // Загружаем больше для фильтрации на фронтенде
        };
        
        const response = await requestService.getAll(params);
        
        // Преобразуем данные из API в формат для таблицы
        const data = response.data || response;
        this.requests = Array.isArray(data) ? data.map(this.transformRequest) : [];
        
      } catch (error) {
        this.error = 'Не удалось загрузить заявки. Пожалуйста, попробуйте позже.';
        console.error('Ошибка загрузки заявок:', error);
      } finally {
        this.loading = false;
      }
    },
    
    // Преобразование данных из API в формат таблицы
    transformRequest(item) {
      return {
        id: item.id || item.request_id,
        number: item.number || item.request_number,
        created_at: item.created_at ? new Date(item.created_at).toLocaleDateString('ru-RU') : '-',
        cargo: item.cargo?.[0]?.name || '-',
        from: item.from?.city?.name || item.from?.address || '-',
        to: item.to?.city?.name || item.to?.address || '-',
        status: item.status || '-'
      };
    },
    
    getStatusColor(status) {
      const colors = {
        'Согласована': 'success',
        'Отменена': 'error'
      };
      return colors[status] || 'grey';
    },
    
    applyFilters() {
      this.page = 1;
      // Можно добавить запрос к API с фильтрами
    },
    
    viewRequest(item) {
      this.$router.push(`/requests/request/${item.id}`);
    },
    
    async deleteRequest(item) {
      if (confirm(`Удалить заявку ${item.number}?`)) {
        try {
          await requestService.delete(item.id);
          // Удаляем из локального массива
          const index = this.requests.findIndex(r => r.id === item.id);
          if (index !== -1) {
            this.requests.splice(index, 1);
          }
        } catch (error) {
          alert('Не удалось удалить заявку');
        }
      }
    },
    
    generateRoute() {
      this.$router.push('/route-form');
    }
  },
  mounted() {
    this.loadRequests();
  }
};
</script>

<style scoped>
.v-data-table {
  border-radius: 8px;
}

.v-chip {
  font-weight: 500;
}
</style>