<template>
  <div>
    <!-- ========== ОБЛАСТЬ 2: КНОПКИ И ЗАГОЛОВОК ========== -->
    <v-container fluid class="px-4 pt-0 pb-0">
      <v-row class="mb-4">
        <!-- Заголовок слева с номером заявки -->
        <v-col cols="12" sm="6" class="d-flex align-center">
          <div>
            <div class="text-h5 font-weight-bold" style="color: #1976d2">
              РЕДАКТИРОВАНИЕ ЗАЯВКИ №{{ requestId }}
            </div>
            <div class="text-subtitle-2 grey--text mt-1">
              Создана: {{ formatDate(requestData.createdAt) }} • 
              Статус: <v-chip
                :color="getStatusColor(requestData.status)"
                small
                dark
                class="ml-1"
              >
                {{ requestData.status }}
              </v-chip>
            </div>
          </div>
        </v-col>

        <!-- Кнопки справа -->
        <v-col cols="12" sm="6" class="text-sm-right">
          <v-btn
            depressed
            large
            class="mr-2 mb-2 mb-sm-0"
            color="success"
            dark
            @click="saveRequest"
            :loading="saving"
          >
            <v-icon left>mdi-content-save</v-icon>
            СОХРАНИТЬ
          </v-btn>
          <v-btn
            depressed
            large
            class="mr-2 mb-2 mb-sm-0"
            color="warning"
            dark
            @click="sendForApproval"
            :loading="sending"
          >
            <v-icon left>mdi-send</v-icon>
            ОТПРАВИТЬ
          </v-btn>
          <v-btn
            depressed
            large
            color="grey lighten-1"
            dark
            @click="$router.push('/requests')"
          >
            <v-icon left>mdi-close</v-icon>
            ОТМЕНА
          </v-btn>
        </v-col>
      </v-row>
    </v-container>

    <!-- ========== ОБЛАСТЬ 3: ВКЛАДКИ ========== -->
    <!-- Синий фон для вкладок на всю ширину -->
    <div class="tabs-blue-background">
      <v-container fluid class="py-0">
        <v-row no-gutters>
          <v-col cols="12">
            <!-- ВКЛАДКИ -->
            <v-tabs
                v-model="activeTab"
                background-color="transparent"
                slider-color="white"
                class="tabs-container"
            >
              <v-tab class="text-uppercase mr-6 tab-item">МАРШРУТ</v-tab>
              <v-tab class="text-uppercase mr-6 tab-item">ДАННЫЕ О ГРУЗЕ</v-tab>
              <v-tab class="text-uppercase tab-item">
                <v-icon left small>mdi-paperclip</v-icon>
                ФАЙЛЫ
              </v-tab>
            </v-tabs>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <!-- Контент вкладок -->
    <v-container fluid class="tabs-content" :style="contentStyle">
      <v-tabs-items v-model="activeTab">
        <v-tab-item>
          <TabRoute 
            :departments="departments"
            :employees="employees"
            :initial-department="requestData.department"
            :initial-employee="requestData.employee"
            @update:selectedDepartment="handleDepartmentChange"
            @update:selectedEmployee="handleEmployeeChange"
          />
        </v-tab-item>
        <v-tab-item>
          <TabCargo 
            :initial-data="requestData.cargoData"
            @update:cargoData="handleCargoDataChange"
          />
        </v-tab-item>
        <v-tab-item>
          <TabFiles 
            :initial-files="requestData.files"
            @update:files="handleFilesChange"
          />
        </v-tab-item>
      </v-tabs-items>
    </v-container>
  </div>
</template>

<script>
// Для Vue 2 используем стандартный синтаксис с data, computed, methods
import TabRoute from '@/components/tabs/TabRoute.vue'
import TabCargo from '@/components/tabs/TabCargo.vue'
import TabFiles from '@/components/tabs/TabFiles.vue'

export default {
  name: 'EditRequestPage',
  components: {
    TabRoute,
    TabCargo,
    TabFiles
  },
  data() {
    return {
      activeTab: 0,
      saving: false,
      sending: false,
      departments: [
        { title: 'Отдел логистики', value: 'logistics' },
        { title: 'Транспортный отдел', value: 'transport' },
        { title: 'Складское хозяйство', value: 'warehouse' },
        { title: 'Отдел закупок', value: 'procurement' },
        { title: 'Производственный отдел', value: 'production' },
        { title: 'Администрация', value: 'administration' }
      ],
      employees: [
        { title: 'Иванов Иван Иванович', value: 'ivanov', department: 'logistics', position: 'Начальник отдела', phone: '+7 (123) 456-78-90' },
        { title: 'Петров Петр Петрович', value: 'petrov', department: 'transport', position: 'Логист', phone: '+7 (123) 456-78-91' },
        { title: 'Сидоров Сидор Сидорович', value: 'sidorov', department: 'warehouse', position: 'Заведующий складом', phone: '+7 (123) 456-78-92' },
        { title: 'Кузнецов Алексей Михайлович', value: 'kuznetsov', department: 'procurement', position: 'Менеджер по закупкам', phone: '+7 (123) 456-78-93' },
        { title: 'Смирнова Елена Владимировна', value: 'smirnova', department: 'production', position: 'Инженер', phone: '+7 (123) 456-78-94' },
        { title: 'Козлов Дмитрий Сергеевич', value: 'kozlov', department: 'administration', position: 'Зам. директора', phone: '+7 (123) 456-78-95' }
      ],
      requestData: {
        id: '',
        createdAt: '',
        status: 'Черновик',
        department: null,
        employee: null,
        cargoData: {
          receiptDate: '',
          deliveryDate: '',
          cargoName: '',
          packagingType: null,
          cargoWeight: '',
          cargoSize: '',
          cargoQuantity: '',
          additionalInfo: '',
          hazardClass: null,
          materialItems: []
        },
        files: []
      }
    }
  },
  computed: {
    requestId() {
      return this.$route.params.id
    },
    contentStyle() {
      return {
        height: 'calc(100vh - 220px)',
        overflowY: 'auto',
        padding: '0 24px'
      }
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
    formatDate(date) {
      if (!date) return ''
      return new Date(date).toLocaleString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    },
    loadRequestData() {
      console.log('Загрузка данных для заявки:', this.requestId)
      
      // Имитация загрузки с сервера
      setTimeout(() => {
        // Тестовые данные
        const mockData = {
          id: this.requestId,
          createdAt: '2026-02-16T10:30:00',
          status: 'Черновик',
          department: 'logistics',
          employee: 'ivanov',
          cargoData: {
            receiptDate: '2026-02-20',
            deliveryDate: '2026-02-25',
            cargoName: 'Станки ЧПУ',
            packagingType: 'Ящик деревянный',
            cargoWeight: '1500',
            cargoSize: '2000',
            cargoQuantity: '3',
            additionalInfo: 'Хрупкий груз, требует осторожного обращения',
            hazardClass: null,
            materialItems: [
              { id: 1, name: 'Станок токарный', quantity: 2, unit: 'шт' },
              { id: 2, name: 'Станок фрезерный', quantity: 1, unit: 'шт' }
            ]
          },
          files: [
            { 
              id: 1, 
              name: 'Спецификация.pdf', 
              size: 1024 * 1024 * 2.5, 
              type: 'application/pdf', 
              uploadedAt: '2026-02-16T10:35:00' 
            },
            { 
              id: 2, 
              name: 'Чертежи.dwg', 
              size: 1024 * 1024 * 5.2, 
              type: 'application/zip', 
              uploadedAt: '2026-02-16T10:36:00' 
            }
          ]
        }
        
        // Заполняем данные
        this.requestData.id = mockData.id
        this.requestData.createdAt = mockData.createdAt
        this.requestData.status = mockData.status
        this.requestData.department = mockData.department
        this.requestData.employee = mockData.employee
        this.requestData.cargoData = { ...mockData.cargoData }
        this.requestData.files = [...mockData.files]
        
        console.log('Данные загружены:', this.requestData)
      }, 500)
    },
    handleDepartmentChange(value) {
      console.log('Department changed:', value)
      this.requestData.department = value
    },
    handleEmployeeChange(value) {
      console.log('Employee changed:', value)
      this.requestData.employee = value
    },
    handleCargoDataChange(data) {
      console.log('Cargo data changed:', data)
      this.requestData.cargoData = data
    },
    handleFilesChange(files) {
      console.log('Files changed:', files)
      this.requestData.files = files
    },
    async saveRequest() {
      this.saving = true
      
      // Имитация сохранения
      await new Promise(resolve => setTimeout(resolve, 1000))
      
      console.log('Сохранение заявки:', this.requestData)
      alert('Заявка сохранена!')
      
      this.saving = false
    },
    async sendForApproval() {
      this.sending = true
      
      // Имитация отправки
      await new Promise(resolve => setTimeout(resolve, 1000))
      
      this.requestData.status = 'На согласовании'
      console.log('Отправка на согласование:', this.requestData)
      alert('Заявка отправлена на согласование!')
      
      this.sending = false
    }
  },
  mounted() {
    console.log('EditRequestPage mounted')
    this.loadRequestData()
  }
}
</script>

<style scoped>
.tabs-blue-background {
  background-color: #1976d2;
  width: 100%;
  padding: 0;
}

.tabs-container {
  background-color: transparent !important;
  box-shadow: none !important;
}

.tab-item {
  color: rgba(255, 255, 255, 0.7) !important;
  font-weight: 500;
  letter-spacing: 0.5px;
  min-width: auto !important;
  transition: color 0.3s ease;
  text-transform: uppercase;
}

.v-tab--active.tab-item {
  color: white !important;
  font-weight: 600;
}

.v-tabs-bar {
  caret-color: transparent !important;
}

.tabs-content {
  transition: height 0.1s ease;
}

@media (max-width: 600px) {
  .tab-item {
    font-size: 12px !important;
  }
  
  .text-h5 {
    font-size: 1.1rem !important;
  }
}
</style>