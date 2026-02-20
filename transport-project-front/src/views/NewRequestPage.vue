<template>
  <div>
    <!-- Заголовок и кнопки действий -->
    <v-container fluid class="px-4 pt-0 pb-0">
      <v-row class="mb-4">
        <v-col cols="6" class="d-flex align-center">
          <!-- заголовок -->
          <div class="text-h5 font-weight-bold" style="color: #1976d2">
            Заявка от {{ currentDate }} - оформление
          </div>
        </v-col>
        <!-- кнопки действий-->
        <v-col cols="6" class="text-right">
          <v-btn depressed large class="mr-2" color="grey lighten-1" dark @click="sendForApproval" :loading="sending">
            <v-icon left>mdi-send</v-icon>
            ОТПРАВИТЬ НА СОГЛАСОВАНИЕ
          </v-btn>
          <v-btn depressed large color="grey lighten-1" dark @click="saveRequest" :loading="saving">
            <v-icon left>mdi-content-save</v-icon>
            СОХРАНИТЬ
          </v-btn>
        </v-col>
      </v-row>
    </v-container>

    <!-- Вкладки -->
    <div class="tabs-blue-background">
      <v-container fluid class="py-0">
        <v-row no-gutters>
          <v-col cols="12">
            <v-tabs v-model="activeTab" background-color="transparent" slider-color="white" class="tabs-container">
              <v-tab class="text-uppercase mr-6 tab-item">МАРШРУТ</v-tab>
              <v-tab class="text-uppercase mr-6 tab-item">ДАННЫЕ О ГРУЗЕ</v-tab>
              <v-tab class="text-uppercase tab-item">ФАЙЛЫ
                <v-icon left small>mdi-paperclip</v-icon>
              </v-tab>
            </v-tabs>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <!-- Контент вкладок -->
    <v-container fluid class="tabs-content" :style="contentStyle">
      <v-tabs-items v-model="activeTab">
        <!-- ВКЛАДКА 1 - МАРШРУТ -->
        <v-tab-item>
          <TabRoute
            :cities="cities"
            :responsible-people="responsiblePeople"
            :loading-cities="loading.cities"
            
            :organization-from-name="organizationFromName"
            :organization-to-name="organizationToName"
            :departure-city-id="routeData.departure_city_id"
            :address-from="routeData.address_from"
            :notes-from="routeData.notes_from"
            :arrival-city-id="routeData.arrival_city_id"
            :address-to="routeData.address_to"
            :notes-to="routeData.notes_to"
            
            :selected-department="selectedDepartment"
            :selected-responsible-person="selectedResponsiblePerson"
            :position="position"
            :work-phone="workPhone"
            :attorney-for-driver="attorneyForDriver"
            
            :errors="errors"
            
            @update:organization-from-name="organizationFromName = $event"
            @update:organization-to-name="organizationToName = $event"
            @update:departure-city-id="routeData.departure_city_id = $event"
            @update:address-from="routeData.address_from = $event"
            @update:notes-from="routeData.notes_from = $event"
            @update:arrival-city-id="routeData.arrival_city_id = $event"
            @update:address-to="routeData.address_to = $event"
            @update:notes-to="routeData.notes_to = $event"
            
            @update:department="onDepartmentChange"
            @update:person="onResponsiblePersonChange"
            @update:attorney="attorneyForDriver = $event"
            
            @open-org-dialog="openOrganizationsDialog"
          />
        </v-tab-item>

        <!-- ВКЛАДКА 2 - ДАННЫЕ О ГРУЗЕ -->
        <v-tab-item>
          <TabCargo ref="tabCargoRef" :initial-data="cargoData" @update:cargoData="updateCargoData"/>
        </v-tab-item>

        <!-- ВКЛАДКА 3 - ФАЙЛЫ -->
        <v-tab-item>
          <TabFiles ref="tabFilesRef" :initial-files="files" @update:files="updateFiles"/>
        </v-tab-item>
      </v-tabs-items>
    </v-container>

    <!-- Диалоговое окно для выбора организации -->
    <v-dialog v-model="organizationsDialog.show" max-width="600px">
      <v-card>
        <v-card-title class="primary white--text">
          <span class="text-h6">Выбор организации</span>
          <v-btn icon dark @click="organizationsDialog.show = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>

        <v-card-text class="pt-4">
          <v-text-field v-model="organizationsDialog.search" label="Поиск" placeholder="Введите название организации"
            prepend-inner-icon="mdi-magnify" outlined dense hide-details class="mb-3"></v-text-field>

          <v-data-table loading-text="Загрузка организаций..." no-data-text="Нет организаций" dense
            :headers="orgHeaders"
            :items="filteredOrganizations"
            :loading="loading.organizations"
            :items-per-page="5"
            @click:row="selectOrganization">
            <template slot="item.select" slot-scope="{ item }">
              <v-btn small color="primary" @click="selectOrganization(item)">Выбрать</v-btn>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- ===== ВРЕМЕННЫЕ ОТЛАДОЧНЫЕ КНОПКИ ===== -->
    <v-container fluid class="pa-4" style="background: #f0f0f0; border-top: 2px solid #ff5722;">
      <v-row>
        <v-col cols="12">
          <h4 style="color: #ff5722;"> ОТЛАДОЧНЫЕ КНОПКИ </h4>
        </v-col>
        <v-col cols="2">
          <v-btn color="warning" @click="debugValues" block class="mb-2" small>
            Показать значения
          </v-btn>
        </v-col>
        <v-col cols="2">
          <v-btn color="info" @click="testCitySelection" block class="mb-2" small>
            Тест выбора города
          </v-btn>
        </v-col>
        <v-col cols="2">
          <v-btn color="success" @click="fillTestData" block class="mb-2" small>
            Заполнить тестовые данные
          </v-btn>
        </v-col>
        <v-col cols="3">
          <v-btn color="purple" dark @click="createTestData" block class="mb-2" small>
            Создать тестовые данные в БД
          </v-btn>
        </v-col>
        <v-col cols="3">
          <v-btn color="deep-purple" dark @click="createTestRequest" block class="mb-2" small>
            Создать тестовую заявку
          </v-btn>
        </v-col>
      </v-row>
      <v-row v-if="debugInfo">
        <v-col cols="12">
          <pre style="background: white; padding: 10px; border-radius: 4px; max-height: 300px; overflow: auto;">{{ debugInfo }}</pre>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import TabRoute from '@/components/tabs/TabRoute.vue'
import TabCargo from '@/components/tabs/TabCargo.vue'
import TabFiles from '@/components/tabs/TabFiles.vue'
import { organizationService } from '@/services/organizationService'
import { cityService } from '@/services/cityService'
import { responsiblePersonService } from '@/services/responsiblePersonService'
import { requestService } from '@/services/requestService'
import { cargoService } from '@/services/cargoService'
import { fileService } from '@/services/fileService'

export default {
  name: 'NewRequestPage',
  components: {
    TabRoute,
    TabCargo,
    TabFiles,
  },
  
  data() {
    return {
      // основные флаги состояния
      activeTab: 0,
      saving: false,
      sending: false,
      currentDate: this.getCurrentDate(),
      // флаги загрузки данных
      loading: {
        cities: false,
        organizations: false,
        responsiblePeople: false
      },
      // данные из БД
      cities: [],
      organizations: [],
      responsiblePeople: [],
      // данные вводимые пользователем
      organizationFromName: '',
      organizationToName: '',
      // данные маршрута (в TabRoute)
      routeData: {
        departure_city_id: null,
        address_from: '',
        notes_from: '',
        arrival_city_id: null,
        address_to: '',
        notes_to: ''
      },
      // данные груза (в TabCargo)
      cargoData: {
        receiptDate: '',
        deliveryDate: '',
        cargoName: '',
        packagingType: null,
        cargoWeight: '',
        cargoVolume: '',
        cargoQuantity: '',
        additionalInfo: '',
        hazardClass: null,
        materialItems: []
      },
      // файлы
      files: [],
      // данные ответственного лица
      selectedDepartment: null,
      selectedResponsiblePerson: null,
      position: '',
      workPhone: '',
      attorneyForDriver: false,
      // ошибки валидации
      errors: {
        organization_from_name: '',
        organization_to_name: '',
        departure_city_id: '',
        address_from: '',
        arrival_city_id: '',
        address_to: ''
      },
      // диалоговое окно для выбора организаций
      organizationsDialog: {
        show: false,
        type: 'from',
        search: ''
      },
      // заголовки таблицы организаций
      orgHeaders: [
        { text: 'Название', value: 'name', align: 'start' },
        { text: 'Действие', value: 'select', align: 'center', sortable: false }
      ],
      // отладка
      debugInfo: null
    }
  },

  computed: {
    contentStyle() {
      return {
        height: 'calc(100vh - 220px)',
        overflowY: 'auto',              // вертикальная прокрутка
        padding: '0 24px'
      }
    },
    // фильтруем организации по поисковому запросу
    filteredOrganizations() {
      if (!this.organizationsDialog.search) {
        return this.organizations
      }
      const searchLower = this.organizationsDialog.search.toLowerCase()
      return this.organizations.filter(org => 
        org.name.toLowerCase().includes(searchLower)
      )
    }
  },

  methods: {
    getCurrentDate() {
      const date = new Date()
      const day = String(date.getDate()).padStart(2, '0')
      const month = String(date.getMonth() + 1).padStart(2, '0')
      const year = date.getFullYear()
      return `${day}.${month}.${year}`
    },
    // загрузка данных из API
    async loadCities() {
      this.loading.cities = true      // включаем индикатор загрузки
      try {
        const response = await cityService.getAll()
        if (response && response.data) {
          this.cities = response.data
        }
        else if (Array.isArray(response)) {
          this.cities = response
        }
        else {
          this.cities = []
        }
      }
      catch (error) {
        console.error('Ошибка загрузки городов:', error)
        this.cities = []
      }
      finally {
        this.loading.cities = false       // выключаем индикатор загрузки
      }
    },

    async loadOrganizations() {
      this.loading.organizations = true
      try {
        const response = await organizationService.getAll()
        if (response && response.data) {
          this.organizations = response.data
        }
        else if (Array.isArray(response)) {
          this.organizations = response
        }
        else {
          this.organizations = []
        }
      }
      catch (error) {
        console.error('Ошибка загрузки организаций:', error)
        this.organizations = []
      }
      finally {
        this.loading.organizations = false
      }
    },

    async loadResponsiblePeople() {
      this.loading.responsiblePeople = true
      try {
        const response = await responsiblePersonService.getAll()
        if (response && response.data) {
          this.responsiblePeople = response.data
        }
        else if (Array.isArray(response)) {
          this.responsiblePeople = response
        }
        else {
          this.responsiblePeople = []
        }
      }
      catch (error) {
        console.error('Ошибка загрузки ответственных лиц:', error)
        this.responsiblePeople = []
      }
      finally {
        this.loading.responsiblePeople = false
      }
    },
    // валидация полей
    validateField(field) {
      switch(field) {
        case 'organization_from_name':
          this.errors.organization_from_name = this.organizationFromName ? '' : 'Поле обязательно'
          break
        case 'organization_to_name':
          this.errors.organization_to_name = this.organizationToName ? '' : 'Поле обязательно'
          break
        case 'departure_city_id':
          this.errors.departure_city_id = this.routeData.departure_city_id ? '' : 'Поле обязательно'
          break
        case 'address_from':
          this.errors.address_from = this.routeData.address_from ? '' : 'Поле обязательно'
          break
        case 'arrival_city_id':
          this.errors.arrival_city_id = this.routeData.arrival_city_id ? '' : 'Поле обязательно'
          break
        case 'address_to':
          this.errors.address_to = this.routeData.address_to ? '' : 'Поле обязательно'
          break
      }
    },

    validateForm() {
      const requiredFields = [
        'organization_from_name',
        'organization_to_name',
        'departure_city_id',
        'address_from',
        'arrival_city_id',
        'address_to'
      ]
      requiredFields.forEach(field => this.validateField(field))
      return requiredFields.every(field => !this.errors[field])
    },

    updateCargoData(data) {
      this.cargoData = data
    },

    updateFiles(newFiles) {
      this.files = newFiles
    },

    onDepartmentChange(value) {
      this.selectedDepartment = value
      this.selectedResponsiblePerson = null
      this.position = ''
      this.workPhone = ''
    },

    onResponsiblePersonChange(value) {
      this.selectedResponsiblePerson = value
      if (value) {
        const person = this.responsiblePeople.find(
          p => p.responsible_person_id === value
        )
        if (person) {
          this.position = person.post || ''
          this.workPhone = person.phone_number || ''
        }
      } else {
        this.position = ''
        this.workPhone = ''
      }
    },

    openOrganizationsDialog(type) {
      this.organizationsDialog.type = type
      this.organizationsDialog.search = ''
      this.organizationsDialog.show = true
    },

    selectOrganization(organization) {
      if (this.organizationsDialog.type === 'from') {
        this.organizationFromName = organization.name
        this.validateField('organization_from_name')
      } else {
        this.organizationToName = organization.name
        this.validateField('organization_to_name')
      }
      this.organizationsDialog.show = false
    },

    async uploadFiles(requestId) {
      for (const file of this.files) {
        try {
          let fileToUpload = file
          if (file instanceof File) {
            fileToUpload = file
          } else if (file.raw) {
            fileToUpload = file.raw
          } else {
            continue
          }
          await fileService.upload(requestId, fileToUpload)
        } catch (fileError) {
          console.error('Ошибка при загрузке файла:', fileError)
        }
      }
    },

    // ===== ОТЛАДОЧНЫЕ МЕТОДЫ =====
    debugValues() {
      const info = {
        cities: this.cities.map(c => ({ id: c.city_id, name: c.name })),
        organizations: this.organizations.map(o => ({ id: o.organization_id, name: o.name })),
        responsiblePeople: this.responsiblePeople.map(p => ({ 
          id: p.responsible_person_id, 
          name: p.full_name,
          department: p.department 
        })),
        organizationFromName: this.organizationFromName,
        organizationToName: this.organizationToName,
        routeData: {
          departure_city_id: this.routeData.departure_city_id,
          address_from: this.routeData.address_from,
          notes_from: this.routeData.notes_from,
          arrival_city_id: this.routeData.arrival_city_id,
          address_to: this.routeData.address_to,
          notes_to: this.routeData.notes_to
        },
        selectedDepartment: this.selectedDepartment,
        selectedResponsiblePerson: this.selectedResponsiblePerson,
        position: this.position,
        workPhone: this.workPhone,
        attorneyForDriver: this.attorneyForDriver,
        files: this.files.map(f => ({ name: f.name, size: f.size }))
      }
      console.log('🔍 Текущие значения:', info)
      this.debugInfo = JSON.stringify(info, null, 2)
    },

    testCitySelection() {
      if (this.cities.length >= 2) {
        this.routeData.departure_city_id = this.cities[0].city_id
        this.routeData.arrival_city_id = this.cities[1].city_id
        this.debugValues()
      } else {
        alert('Недостаточно городов в списке')
      }
    },

    fillTestData() {
      if (this.cities.length >= 2 && this.organizations.length >= 2) {
        this.organizationFromName = this.organizations[0]?.name || 'Тестовая организация 1'
        this.routeData.departure_city_id = this.cities[0]?.city_id
        this.routeData.address_from = 'Тестовый адрес 1'
        this.routeData.notes_from = 'Тестовое примечание 1'
        this.organizationToName = this.organizations[1]?.name || 'Тестовая организация 2'
        this.routeData.arrival_city_id = this.cities[1]?.city_id
        this.routeData.address_to = 'Тестовый адрес 2'
        this.routeData.notes_to = 'Тестовое примечание 2'
        
        if (this.responsiblePeople.length > 0) {
          this.selectedDepartment = this.responsiblePeople[0].department
          this.$nextTick(() => {
            this.selectedResponsiblePerson = this.responsiblePeople[0].responsible_person_id
          })
        }
        
        this.attorneyForDriver = true
        
        this.debugValues()
      } else {
        alert('Недостаточно данных для теста')
      }
    },

    async createTestData() {
      console.log('🟢 Начинаем создание тестовых данных...')
      
      try {
        const cityData = {
          name: 'Тестовый город ' + new Date().toLocaleTimeString()
        }
        await cityService.create(cityData)

        const orgData = {
          name: 'Тестовая организация ' + new Date().toLocaleTimeString()
        }
        await organizationService.create(orgData)

        const cargoData = {
          cargo_name: 'Тестовый груз ' + new Date().toLocaleTimeString(),
          date_of_taking_cargo: new Date().toISOString().split('T')[0],
          type_of_packaging: 'Коробка',
          weight_of_cargo: 100.50,
          cargo_volume: 2.5,
          quantity: 10,
          cargo_unit: 'шт',
          delivery_time: new Date().toISOString()
        }
        await cargoService.create(cargoData)

        await this.loadCities()
        await this.loadOrganizations()
        await this.loadResponsiblePeople()
        
        alert('✅ Тестовые данные успешно созданы!')
        this.debugValues()
        
      } catch (error) {
        console.error('❌ Ошибка при создании тестовых данных:', error)
        alert('❌ Ошибка при создании тестовых данных')
      }
    },

    async createTestRequest() {
      console.log('🟢 Начинаем создание тестовой заявки...')
      
      try {
        const firstCity = this.cities[0]
        const firstPerson = this.responsiblePeople[0]
        
        if (!firstCity || !firstPerson) {
          throw new Error('Сначала создайте тестовые данные в БД (фиолетовая кнопка)')
        }
        
        const requestData = {
          request_number: `TEST-${new Date().getFullYear()}-${String(Math.floor(Math.random() * 1000)).padStart(3, '0')}`,
          status: 'На согласовании',
          organization_from_name: this.organizationFromName || 'Тестовая организация',
          departure_city_id: firstCity.city_id,
          address_from: this.routeData.address_from || 'Тестовый адрес погрузки',
          notes_from: this.routeData.notes_from || 'Тестовое примечание погрузки',
          organization_to_name: this.organizationToName || 'Тестовая организация',
          arrival_city_id: firstCity.city_id,
          address_to: this.routeData.address_to || 'Тестовый адрес разгрузки',
          notes_to: this.routeData.notes_to || 'Тестовое примечание разгрузки',
          departure_datetime: new Date().toISOString(),
          arrival_datetime: new Date().toISOString(),
          responsible_person_id: firstPerson.responsible_person_id,
          attorney_for_driver: true
        }
        
        const response = await requestService.create(requestData)
        console.log('✅ Тестовая заявка создана, ответ:', response)
        
        alert('✅ Тестовая заявка успешно создана!')
        this.debugValues()
        
      } catch (error) {
        console.error('❌ Ошибка при создании тестовой заявки:', error)
        alert('❌ Ошибка при создании тестовой заявки')
      }
    },

    async saveRequest() {
      if (!this.validateForm()) {
        this.activeTab = 0
        alert('Пожалуйста, заполните все обязательные поля')
        return
      }
      
      this.saving = true
      console.log('📤 Начинаем сохранение заявки...')
      
      try {
        const departureCityId = parseInt(this.routeData.departure_city_id)
        const arrivalCityId = parseInt(this.routeData.arrival_city_id)
        
        if (isNaN(departureCityId) || isNaN(arrivalCityId)) {
          throw new Error('Выберите город из списка')
        }
        
        const requestData = {
          request_number: `З-${new Date().getFullYear()}-${String(Math.floor(Math.random() * 1000)).padStart(3, '0')}`,
          status: 'Черновик',
          organization_from_name: this.organizationFromName,
          departure_city_id: departureCityId,
          address_from: this.routeData.address_from,
          notes_from: this.routeData.notes_from || '',
          organization_to_name: this.organizationToName,
          arrival_city_id: arrivalCityId,
          address_to: this.routeData.address_to,
          notes_to: this.routeData.notes_to || '',
          departure_datetime: new Date().toISOString(),
          arrival_datetime: new Date().toISOString(),
          responsible_person_id: this.selectedResponsiblePerson ? parseInt(this.selectedResponsiblePerson) : null,
          attorney_for_driver: this.attorneyForDriver ? true : false
        }
        
        console.log('📤 Отправка заявки:', requestData)
        const requestResponse = await requestService.create(requestData)
        console.log('✅ Заявка создана, ответ:', requestResponse)
        
        let requestId = null
        if (requestResponse.data && requestResponse.data.request_id) {
          requestId = requestResponse.data.request_id
        } else if (requestResponse.request_id) {
          requestId = requestResponse.request_id
        }
        
        if (!requestId) {
          throw new Error('Не удалось получить ID созданной заявки')
        }
        
        if (this.files && this.files.length > 0) {
          console.log('📎 Загружаем файлы...')
          await this.uploadFiles(requestId)
        }
        
        alert('Заявка успешно сохранена!')
        this.$router.push('/requests')
        
      } catch (error) {
        console.error('❌ Ошибка сохранения заявки:', error)
        alert(error.message || 'Ошибка при сохранении заявки')
      } finally {
        this.saving = false
      }
    },

    async sendForApproval() {
      if (!this.validateForm()) {
        this.activeTab = 0
        alert('Пожалуйста, заполните все обязательные поля')
        return
      }
      
      this.sending = true
      console.log('📤 Отправка на согласование...')
      
      try {
        const departureCityId = parseInt(this.routeData.departure_city_id)
        const arrivalCityId = parseInt(this.routeData.arrival_city_id)
        
        if (isNaN(departureCityId) || isNaN(arrivalCityId)) {
          throw new Error('Выберите город из списка')
        }
        
        const requestData = {
          request_number: `З-${new Date().getFullYear()}-${String(Math.floor(Math.random() * 1000)).padStart(3, '0')}`,
          status: 'На согласовании',
          organization_from_name: this.organizationFromName,
          departure_city_id: departureCityId,
          address_from: this.routeData.address_from,
          notes_from: this.routeData.notes_from || '',
          organization_to_name: this.organizationToName,
          arrival_city_id: arrivalCityId,
          address_to: this.routeData.address_to,
          notes_to: this.routeData.notes_to || '',
          departure_datetime: new Date().toISOString(),
          arrival_datetime: new Date().toISOString(),
          responsible_person_id: this.selectedResponsiblePerson ? parseInt(this.selectedResponsiblePerson) : null,
          attorney_for_driver: this.attorneyForDriver ? true : false
        }
        
        console.log('📤 Отправка на согласование:', requestData)
        const requestResponse = await requestService.create(requestData)
        console.log('✅ Заявка отправлена на согласование, ответ:', requestResponse)
        
        let requestId = null
        if (requestResponse.data && requestResponse.data.request_id) {
          requestId = requestResponse.data.request_id
        } else if (requestResponse.request_id) {
          requestId = requestResponse.request_id
        }
        
        if (!requestId) {
          throw new Error('Не удалось получить ID созданной заявки')
        }
        
        if (this.files && this.files.length > 0) {
          await this.uploadFiles(requestId)
        }
        
        alert('Заявка отправлена на согласование!')
        this.$router.push('/requests')
        
      } catch (error) {
        console.error('❌ Ошибка отправки на согласование:', error)
        alert(error.message || 'Ошибка при отправке на согласование')
      } finally {
        this.sending = false
      }
    }
  },
  mounted() {
    this.loadCities()
    this.loadOrganizations()
    this.loadResponsiblePeople()
    
    setTimeout(() => {
      console.log('⏰ Через 2 секунды cities:', this.cities)
      console.log('⏰ Через 2 секунды organizations:', this.organizations)
      console.log('⏰ Через 2 секунды responsiblePeople:', this.responsiblePeople)
    }, 2000)
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