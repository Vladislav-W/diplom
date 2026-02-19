<template>
  <v-container fluid class="pa-4">
    <v-row class="mb-4">
      <v-col cols="12">
        <h1 class="text-h4 font-weight-bold" style="color: #1976d2">
          ВСЕ ЗАЯВКИ
        </h1>
        <v-divider class="mt-2" style="border-color: #1976d2; border-width: 2px;"></v-divider>
      </v-col>
    </v-row>

    <!-- Статистика по всем статусам -->
    <v-row class="mb-4">
      <v-col cols="12" sm="3">
        <v-card class="pa-3" color="primary" dark>
          <div class="text-h6">Всего</div>
          <div class="text-h4">{{ totalRequests }}</div>
        </v-card>
      </v-col>
      <v-col cols="12" sm="3">
        <v-card class="pa-3" color="grey" dark>
          <div class="text-h6">Черновики</div>
          <div class="text-h4">{{ draftCount }}</div>
        </v-card>
      </v-col>
      <v-col cols="12" sm="3">
        <v-card class="pa-3" color="warning" dark>
          <div class="text-h6">В работе</div>
          <div class="text-h4">{{ inProgressCount }}</div>
        </v-card>
      </v-col>
      <v-col cols="12" sm="3">
        <v-card class="pa-3" color="success" dark>
          <div class="text-h6">Завершено</div>
          <div class="text-h4">{{ completedCount }}</div>
        </v-card>
      </v-col>
    </v-row>

    <!-- Расширенные фильтры -->
    <v-card class="pa-4 mb-4">
      <v-row>
        <v-col cols="12" sm="3">
          <v-text-field
            v-model="search"
            label="Поиск"
            placeholder="Номер, груз, откуда, куда..."
            prepend-inner-icon="mdi-magnify"
            outlined
            dense
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="2">
          <v-select
            v-model="statusFilter"
            :items="allStatuses"
            label="Статус"
            outlined
            dense
          ></v-select>
        </v-col>
        <v-col cols="12" sm="2">
          <v-select
            v-model="dateFilter"
            :items="dateRanges"
            label="Период"
            outlined
            dense
          ></v-select>
        </v-col>
        <v-col cols="12" sm="3">
          <v-text-field
            v-model="clientFilter"
            label="Клиент"
            placeholder="Введите клиента"
            outlined
            dense
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="2" class="d-flex align-center">
          <v-btn color="primary" block @click="applyFilters">
            <v-icon left>mdi-filter</v-icon>
            Применить
          </v-btn>
        </v-col>
      </v-row>
    </v-card>

    <!-- Таблица заявок -->
    <v-data-table
      :headers="allHeaders"
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

      <!-- Действия -->
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
          color="warning"
          @click="editRequest(item)"
          class="mr-1"
        >
          <v-icon small>mdi-pencil</v-icon>
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
          <p class="text-h6 grey--text mt-2">Нет заявок</p>
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
  </v-container>
</template>

<script>
export default {
  name: 'AllRequestsPage',
  data() {
    return {
      search: '',
      statusFilter: 'Все',
      dateFilter: 'Все',
      clientFilter: '',
      loading: false,
      page: 1,
      itemsPerPage: 10,
      allStatuses: ['Все', 'Черновик', 'На согласовании', 'Согласована', 'В работе', 'Выполнена', 'Отменена'],
      dateRanges: ['Все', 'Сегодня', 'Неделя', 'Месяц', 'Квартал', 'Год'],
      allHeaders: [
        { text: 'Номер', value: 'id', align: 'start', width: '100' },
        { text: 'Дата', value: 'date', align: 'start', width: '100' },
        { text: 'Клиент', value: 'client', align: 'start', width: '150' },
        { text: 'Груз', value: 'cargo', align: 'start' },
        { text: 'Откуда', value: 'from', align: 'start' },
        { text: 'Куда', value: 'to', align: 'start' },
        { text: 'Статус', value: 'status', align: 'center', width: '120' },
        { text: 'Действия', value: 'actions', align: 'center', sortable: false, width: '120' }
      ],
      requests: [
        { id: 'З-2026-001', date: '15.02.2026', client: 'ООО "Ромашка"', cargo: 'Станки ЧПУ', from: 'Москва', to: 'Санкт-Петербург', status: 'На согласовании' },
        { id: 'З-2026-002', date: '14.02.2026', client: 'АО "Технопром"', cargo: 'Запчасти', from: 'Екатеринбург', to: 'Казань', status: 'Черновик' },
        { id: 'З-2026-003', date: '13.02.2026', client: 'ИП Петров', cargo: 'Мебель', from: 'Новосибирск', to: 'Красноярск', status: 'Согласована' },
        { id: 'З-2026-004', date: '12.02.2026', client: 'ООО "СтройИнвест"', cargo: 'Электроника', from: 'Самара', to: 'Уфа', status: 'В работе' },
        { id: 'З-2026-005', date: '11.02.2026', client: 'ЗАО "Логистика"', cargo: 'Строительные материалы', from: 'Ростов-на-Дону', to: 'Волгоград', status: 'Выполнена' },
        { id: 'З-2026-006', date: '10.02.2026', client: 'ООО "Альфа"', cargo: 'Продукты питания', from: 'Краснодар', to: 'Сочи', status: 'Отменена' },
        { id: 'З-2026-007', date: '09.02.2026', client: 'АО "Бета"', cargo: 'Оборудование', from: 'Пермь', to: 'Ижевск', status: 'Согласована' },
        { id: 'З-2026-008', date: '08.02.2026', client: 'ООО "Гамма"', cargo: 'Химия', from: 'Казань', to: 'Нижний Новгород', status: 'Черновик' }
      ]
    }
  },
  computed: {
    filteredRequests() {
      let result = this.requests

      if (this.search) {
        const searchLower = this.search.toLowerCase()
        result = result.filter(r => 
          r.id.toLowerCase().includes(searchLower) ||
          r.cargo.toLowerCase().includes(searchLower) ||
          r.from.toLowerCase().includes(searchLower) ||
          r.to.toLowerCase().includes(searchLower) ||
          r.client.toLowerCase().includes(searchLower)
        )
      }

      if (this.clientFilter) {
        const clientLower = this.clientFilter.toLowerCase()
        result = result.filter(r => r.client.toLowerCase().includes(clientLower))
      }

      if (this.statusFilter !== 'Все') {
        result = result.filter(r => r.status === this.statusFilter)
      }

      return result
    },
    pageCount() {
      return Math.ceil(this.filteredRequests.length / this.itemsPerPage)
    },
    totalRequests() {
      return this.requests.length
    },
    draftCount() {
      return this.requests.filter(r => r.status === 'Черновик').length
    },
    inProgressCount() {
      return this.requests.filter(r => 
        r.status === 'В работе' || r.status === 'На согласовании'
      ).length
    },
    completedCount() {
      return this.requests.filter(r => 
        r.status === 'Согласована' || r.status === 'Выполнена' || r.status === 'Отменена'
      ).length
    }
  },
  methods: {
    getStatusColor(status) {
      const colors = {
        'Черновик': 'grey',
        'На согласовании': 'warning',
        'Согласована': 'success',
        'В работе': 'primary',
        'Выполнена': 'green darken-1',
        'Отменена': 'error'
      }
      return colors[status] || 'grey'
    },
    applyFilters() {
      this.page = 1
    },
    viewRequest(item) {
      this.$router.push(`/requests/request/${item.id}`)
    },
    editRequest(item) {
      this.$router.push(`/requests/request/${item.id}`)
    },
    deleteRequest(item) {
      if (confirm(`Удалить заявку ${item.id}?`)) {
        const index = this.requests.findIndex(r => r.id === item.id)
        if (index !== -1) {
          this.requests.splice(index, 1)
        }
      }
    }
  }
}
</script>