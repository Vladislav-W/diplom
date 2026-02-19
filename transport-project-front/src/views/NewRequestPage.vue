<template>
  <div>
    <!-- Заголовок и кнопки действий -->
    <v-container fluid class="px-4 pt-0 pb-0">
      <v-row class="mb-4">
        <v-col sm="6" class="d-flex align-center">
          <div class="text-h5 font-weight-bold" style="color: #1976d2">
            Заявка от {{ currentDate }} - оформление
          </div>
        </v-col>

        <v-col cols="12" sm="6" class="text-sm-right">
          <v-btn
            depressed
            large
            class="mr-2 mb-2 mb-sm-0"
            color="grey lighten-1"
            dark
            @click="sendForApproval"
            :loading="sending"
          >
            <v-icon left>mdi-send</v-icon>
            ОТПРАВИТЬ НА СОГЛАСОВАНИЕ
          </v-btn>

          <v-btn
            depressed
            large
            color="grey lighten-1"
            dark
            @click="saveRequest"
            :loading="saving"
          >
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
        <!-- ВКЛАДКА 1: МАРШРУТ -->
        <v-tab-item>
          <v-card flat class="pa-4">
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <div class="mb-6" style="display: inline-block;">
                    <h3 class="text-h5 font-weight-bold" style="color: #1976d2">
                      ПОЛУЧЕНИЕ МАТЕРИАЛЬНЫХ ЦЕННОСТЕЙ ПО ДОКУМЕНТУ
                    </h3>
                    <v-divider class="mt-2" style="border-color: #1976d2; border-width: 2px 0 0 0; width: 100%;"></v-divider>
                  </div>
          
                  <v-row>
                    <!-- Пункт погрузки -->
                    <v-col cols="12" md="6">
                      <h4 class="text-h6 font-weight-bold mb-4" style="color: #1976d2">
                        Пункт погрузки:
                      </h4>
                      
                      <!-- Организация с кнопкой справа - ТЕПЕРЬ ТЕКСТОВОЕ ПОЛЕ -->
                      <v-row no-gutters class="mb-3">
                        <v-col cols="12">
                          <v-row no-gutters>
                            <v-col cols="9">
                              <v-text-field
                                v-model="organizationFromName"
                                label="Организация *"
                                placeholder="Введите организацию"
                                outlined
                                dense
                                required
                                hide-details
                                :error-messages="errors.organization_from_name"
                                @input="validateField('organization_from_name')"
                              >
                                <template v-slot:label>
                                  Организация <span style="color: red;">*</span>
                                </template>
                              </v-text-field>
                            </v-col>
                            <v-col cols="3" class="pl-2">
                              <v-btn
                                elevation="2"
                                height="40"
                                block
                                color="primary"
                                outlined
                                @click="openOrganizationsDialog('from')"
                              >
                                <v-icon>mdi-folder-search</v-icon>
                              </v-btn>
                            </v-col>
                          </v-row>
                        </v-col>
                      </v-row>
                      
                      <!-- Город и Адрес слева, Примечание справа -->
                      <v-row>
                        <v-col cols="7">
                          <v-row>
                            <v-col cols="12" class="pb-0">
                              <v-autocomplete
                                v-model="routeData.departure_city_id"
                                :items="cities"
                                item-text="name"
                                item-value="city_id"
                                label="Город погрузки *"
                                placeholder="Введите город"
                                outlined
                                dense
                                required
                                hide-details
                                :loading="loading.cities"
                                :error-messages="errors.departure_city_id"
                                @change="validateField('departure_city_id')"
                              >
                                <template v-slot:label>
                                  Город погрузки <span style="color: red;">*</span>
                                </template>
                              </v-autocomplete>
                            </v-col>
                          </v-row>
                          <v-row class="mt-3">
                            <v-col cols="12">
                              <v-text-field
                                v-model="routeData.address_from"
                                label="Адрес откуда *"
                                placeholder="Введите адрес"
                                outlined
                                dense
                                required
                                hide-details
                                :error-messages="errors.address_from"
                                @input="validateField('address_from')"
                              >
                                <template v-slot:label>
                                  Адрес откуда <span style="color: red;">*</span>
                                </template>
                              </v-text-field>
                            </v-col>
                          </v-row>
                        </v-col>
                        
                        <v-col cols="5">
                          <v-textarea
                            v-model="routeData.notes_from"
                            label="Примечание"
                            placeholder="Введите примечание"
                            outlined
                            dense
                            rows="3"
                            hide-details
                            style="height: 100%;"
                            class="fill-height"
                          ></v-textarea>
                        </v-col>
                      </v-row>
                    </v-col>
                    
                    <!-- Пункт разгрузки -->
                    <v-col cols="12" md="6">
                      <h4 class="text-h6 font-weight-bold mb-4" style="color: #1976d2">
                        Пункт разгрузки:
                      </h4>
                      
                      <!-- Организация с кнопкой справа - ТЕПЕРЬ ТЕКСТОВОЕ ПОЛЕ -->
                      <v-row no-gutters class="mb-3">
                        <v-col cols="12">
                          <v-row no-gutters>
                            <v-col cols="9">
                              <v-text-field
                                v-model="organizationToName"
                                label="Организация *"
                                placeholder="Введите организацию"
                                outlined
                                dense
                                required
                                hide-details
                                :error-messages="errors.organization_to_name"
                                @input="validateField('organization_to_name')"
                              >
                                <template v-slot:label>
                                  Организация <span style="color: red;">*</span>
                                </template>
                              </v-text-field>
                            </v-col>
                            <v-col cols="3" class="pl-2">
                              <v-btn
                                elevation="2"
                                height="40"
                                block
                                color="primary"
                                outlined
                                @click="openOrganizationsDialog('to')"
                              >
                                <v-icon>mdi-folder-search</v-icon>
                              </v-btn>
                            </v-col>
                          </v-row>
                        </v-col>
                      </v-row>
                      
                      <!-- Город и Адрес слева, Примечание справа -->
                      <v-row>
                        <v-col cols="7">
                          <v-row>
                            <v-col cols="12" class="pb-0">
                              <v-autocomplete
                                v-model="routeData.arrival_city_id"
                                :items="cities"
                                item-text="name"
                                item-value="city_id"
                                label="Город разгрузки *"
                                placeholder="Введите город"
                                outlined
                                dense
                                required
                                hide-details
                                :loading="loading.cities"
                                :error-messages="errors.arrival_city_id"
                                @change="validateField('arrival_city_id')"
                              >
                                <template v-slot:label>
                                  Город разгрузки <span style="color: red;">*</span>
                                </template>
                              </v-autocomplete>
                            </v-col>
                          </v-row>
                          <v-row class="mt-3">
                            <v-col cols="12">
                              <v-text-field
                                v-model="routeData.address_to"
                                label="Адрес куда *"
                                placeholder="Введите адрес"
                                outlined
                                dense
                                required
                                hide-details
                                :error-messages="errors.address_to"
                                @input="validateField('address_to')"
                              >
                                <template v-slot:label>
                                  Адрес куда <span style="color: red;">*</span>
                                </template>
                              </v-text-field>
                            </v-col>
                          </v-row>
                        </v-col>
                        
                        <v-col cols="5">
                          <v-textarea
                            v-model="routeData.notes_to"
                            label="Примечание"
                            placeholder="Введите примечание"
                            outlined
                            dense
                            rows="3"
                            hide-details
                            style="height: 100%;"
                            class="fill-height"
                          ></v-textarea>
                        </v-col>
                      </v-row>
                    </v-col>
                  </v-row>

                  <!-- Ответственный за заявку -->
                  <v-row class="mt-6">
                    <v-col cols="12">
                      <h4 class="text-h6 font-weight-bold mb-4" style="color: #1976d2">
                        Ответственный за заявку:
                      </h4>
                      
                      <!-- Заголовки в один ряд (без отступов) -->
                      <v-row class="ma-0">
                        <v-col cols="12" md="2" class="pa-0">
                          <span class="text-subtitle-2 font-weight-medium">Подразделение</span>
                        </v-col>
                        <v-col cols="12" md="4" class="pa-0">
                          <span class="text-subtitle-2 font-weight-medium">Фамилия Имя Отчество</span>
                        </v-col>
                        <v-col cols="12" md="4" class="pa-0">
                          <span class="text-subtitle-2 font-weight-medium">Должность</span>
                        </v-col>
                        <v-col cols="12" md="2" class="pa-0">
                          <span class="text-subtitle-2 font-weight-medium">Телефон - рабочий</span>
                        </v-col>
                      </v-row>
                      
                      <!-- Поля ввода в один ряд (underlined) -->
                      <v-row class="mt-1 ma-0">
                        <v-col cols="12" md="2" class="pa-0 pr-2">
                          <v-select
                            v-model="selectedDepartment"
                            :items="uniqueDepartments"
                            label="Подразделение"
                            placeholder="Выберите подразделение"
                            variant="underlined"
                            density="compact"
                            hide-details
                            clearable
                            @change="onDepartmentChange"
                          ></v-select>
                        </v-col>
                        
                        <v-col cols="12" md="4" class="pa-0 pr-2">
                          <v-select
                            v-model="selectedResponsiblePerson"
                            :items="filteredResponsiblePeople"
                            item-text="full_name"
                            item-value="responsible_person_id"
                            label="Фамилия Имя Отчество"
                            placeholder="Выберите ответственное лицо"
                            variant="underlined"
                            density="compact"
                            hide-details
                            clearable
                            :disabled="!selectedDepartment"
                            @change="onResponsiblePersonChange"
                          ></v-select>
                        </v-col>
                        
                        <v-col cols="12" md="4" class="pa-0 pr-2">
                          <v-text-field
                            v-model="position"
                            label="Должность"
                            placeholder="Должность"
                            variant="underlined"
                            density="compact"
                            hide-details
                            readonly
                          ></v-text-field>
                        </v-col>
                        
                        <v-col cols="12" md="2" class="pa-0">
                          <v-text-field
                            v-model="workPhone"
                            label="Телефон - рабочий"
                            placeholder="+7 (___) ___-__-__"
                            variant="underlined"
                            density="compact"
                            type="tel"
                            hide-details
                            readonly
                          ></v-text-field>
                        </v-col>
                      </v-row>
                    </v-col>
                  </v-row>

                  <!-- Доверенность -->
                  <v-row class="mt-6">
                    <v-col cols="12">
                      <h4 class="text-h6 font-weight-bold mb-2" style="color: #1976d2">
                        Доверенность:
                      </h4>
                      
                      <v-checkbox
                        v-model="attorneyForDriver"
                        label="Требуется доверенность водителю"
                        color="primary"
                        hide-details
                        class="mt-0"
                      ></v-checkbox>
                    </v-col>
                  </v-row>

                  <RequiredFieldsNote />
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-tab-item>

        <!-- ВКЛАДКА 2: ДАННЫЕ О ГРУЗЕ -->
        <v-tab-item>
          <TabCargo 
            ref="tabCargoRef"
            :initial-data="cargoData"
            @update:cargoData="updateCargoData"
          />
        </v-tab-item>

        <!-- ВКЛАДКА 3: ФАЙЛЫ -->
        <v-tab-item>
          <TabFiles 
            ref="tabFilesRef"
            :initial-files="files"
            @update:files="updateFiles"
          />
        </v-tab-item>
      </v-tabs-items>
    </v-container>

    <!-- ДИАЛОГОВОЕ ОКНО ДЛЯ ВЫБОРА ОРГАНИЗАЦИИ (без изменений) -->
    <v-dialog v-model="organizationsDialog.show" max-width="600px">
      <v-card>
        <v-card-title class="primary white--text">
          <span class="text-h6">Выбор организации</span>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="organizationsDialog.show = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>

        <v-card-text class="pt-4">
          <v-text-field
            v-model="organizationsDialog.search"
            label="Поиск"
            placeholder="Введите название организации"
            prepend-inner-icon="mdi-magnify"
            outlined
            dense
            hide-details
            class="mb-3"
          ></v-text-field>

          <v-data-table
            :headers="orgHeaders"
            :items="filteredOrganizations"
            :loading="loading.organizations"
            loading-text="Загрузка организаций..."
            no-data-text="Нет организаций"
            dense
            :items-per-page="5"
            @click:row="selectOrganization"
          >
            <template slot="item.select" slot-scope="{ item }">
              <v-btn
                small
                color="primary"
                @click="selectOrganization(item)"
              >
                Выбрать
              </v-btn>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- ===== ВРЕМЕННЫЕ ОТЛАДОЧНЫЕ КНОПКИ ===== -->
    <v-container fluid class="pa-4" style="background: #f0f0f0; border-top: 2px solid #ff5722;">
      <v-row>
        <v-col cols="12">
          <h4 style="color: #ff5722;">🔧 ОТЛАДОЧНЫЕ КНОПКИ (временные)</h4>
        </v-col>
        <v-col cols="12" sm="2">
          <v-btn color="warning" @click="debugValues" block class="mb-2" small>
            Показать значения
          </v-btn>
        </v-col>
        <v-col cols="12" sm="2">
          <v-btn color="info" @click="testCitySelection" block class="mb-2" small>
            Тест выбора города
          </v-btn>
        </v-col>
        <v-col cols="12" sm="2">
          <v-btn color="success" @click="fillTestData" block class="mb-2" small>
            Заполнить тестовые данные
          </v-btn>
        </v-col>
        <v-col cols="12" sm="3">
          <v-btn color="purple" dark @click="createTestData" block class="mb-2" small>
            Создать тестовые данные в БД
          </v-btn>
        </v-col>
        <v-col cols="12" sm="3">
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
import TabCargo from '@/components/tabs/TabCargo.vue'
import TabFiles from '@/components/tabs/TabFiles.vue'
import RequiredFieldsNote from '@/components/common/RequiredFieldsNote.vue'
import { organizationService } from '@/services/organizationService'
import { cityService } from '@/services/cityService'
import { responsiblePersonService } from '@/services/responsiblePersonService'
import { requestService } from '@/services/requestService'
import { fileService } from '@/services/fileService'
import { cargoService } from '@/services/cargoService'

export default {
  name: 'NewRequestPage',
  components: {
    TabCargo,
    TabFiles,
    RequiredFieldsNote
  },
  data() {
    return {
      activeTab: 0,
      saving: false,
      sending: false,
      currentDate: this.getCurrentDate(),
      
      loading: {
        cities: false,
        organizations: false,
        responsiblePeople: false
      },
      
      cities: [],
      organizations: [],
      responsiblePeople: [],
      
      // Новые поля для названий организаций
      organizationFromName: '',
      organizationToName: '',
      
      routeData: {
        // organization_from_id и organization_to_id больше не используются
        departure_city_id: null,
        address_from: '',
        notes_from: '',
        arrival_city_id: null,
        address_to: '',
        notes_to: ''
      },
      
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
      
      files: [],
      
      selectedDepartment: null,
      selectedResponsiblePerson: null,
      position: '',
      workPhone: '',
      attorneyForDriver: false,
      
      errors: {
        organization_from_name: '',
        organization_to_name: '',
        departure_city_id: '',
        address_from: '',
        arrival_city_id: '',
        address_to: ''
      },
      
      organizationsDialog: {
        show: false,
        type: 'from',
        search: ''
      },
      
      orgHeaders: [
        { text: 'Название', value: 'name', align: 'start' },
        { text: 'Действие', value: 'select', align: 'center', sortable: false }
      ],
      
      // Для отладки
      debugInfo: null
    }
  },
  computed: {
    contentStyle() {
      return {
        height: 'calc(100vh - 220px)',
        overflowY: 'auto',
        padding: '0 24px'
      }
    },
    
    uniqueDepartments() {
      if (!this.responsiblePeople || !Array.isArray(this.responsiblePeople) || this.responsiblePeople.length === 0) {
        return []
      }
      const departments = this.responsiblePeople
        .map(person => person.department)
        .filter((value, index, self) => value && self.indexOf(value) === index)
        .sort()
      return departments
    },
    
    filteredResponsiblePeople() {
      if (!this.selectedDepartment || !Array.isArray(this.responsiblePeople)) {
        return []
      }
      return this.responsiblePeople.filter(
        person => person.department === this.selectedDepartment
      )
    },
    
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
    
    async loadCities() {
      this.loading.cities = true
      try {
        const response = await cityService.getAll()
        console.log('📦 cities response:', response)
        
        // Проверяем структуру ответа
        if (response && response.data) {
          // Если ответ в формате { data: [...] }
          this.cities = response.data
        } else if (Array.isArray(response)) {
          // Если ответ просто массив
          this.cities = response
        } else {
          this.cities = []
        }
        
        console.log('✅ Города загружены:', this.cities)
      } catch (error) {
        console.error('❌ Ошибка загрузки городов:', error)
        this.cities = []
      } finally {
        this.loading.cities = false
      }
    },

    async loadOrganizations() {
      this.loading.organizations = true
      try {
        const response = await organizationService.getAll()
        console.log('📦 organizations response:', response)
        
        if (response && response.data) {
          this.organizations = response.data
        } else if (Array.isArray(response)) {
          this.organizations = response
        } else {
          this.organizations = []
        }
        
        console.log('✅ Организации загружены:', this.organizations)
      } catch (error) {
        console.error('❌ Ошибка загрузки организаций:', error)
        this.organizations = []
      } finally {
        this.loading.organizations = false
      }
    },

    async loadResponsiblePeople() {
      this.loading.responsiblePeople = true
      try {
        const response = await responsiblePersonService.getAll()
        console.log('📦 responsiblePeople response:', response)
        
        if (response && response.data) {
          this.responsiblePeople = response.data
        } else if (Array.isArray(response)) {
          this.responsiblePeople = response
        } else {
          this.responsiblePeople = []
        }
        
        console.log('✅ Ответственные лица загружены:', this.responsiblePeople)
      } catch (error) {
        console.error('❌ Ошибка загрузки ответственных лиц:', error)
        this.responsiblePeople = []
      } finally {
        this.loading.responsiblePeople = false
      }
    },
    
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

    onDepartmentChange() {
      this.selectedResponsiblePerson = null
      this.position = ''
      this.workPhone = ''
    },

    onResponsiblePersonChange() {
      if (this.selectedResponsiblePerson) {
        const person = this.responsiblePeople.find(
          p => p.responsible_person_id === this.selectedResponsiblePerson
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
        console.log('✅ Установлены тестовые ID городов:', {
          departure: this.cities[0].city_id,
          arrival: this.cities[1].city_id
        })
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
        
        console.log('✅ Заполнены тестовые данные')
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
        console.log('📤 Создаем город:', cityData)
        const cityResponse = await cityService.create(cityData)
        console.log('✅ Город создан:', cityResponse)

        const orgData = {
          name: 'Тестовая организация ' + new Date().toLocaleTimeString()
        }
        console.log('📤 Создаем организацию:', orgData)
        const orgResponse = await organizationService.create(orgData)
        console.log('✅ Организация создана:', orgResponse)

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
        console.log('📤 Создаем груз:', cargoData)
        const cargoResponse = await cargoService.create(cargoData)
        console.log('✅ Груз создан:', cargoResponse)

        await this.loadCities()
        await this.loadOrganizations()
        await this.loadResponsiblePeople()
        
        alert('✅ Тестовые данные успешно созданы!')
        this.debugValues()
        
      } catch (error) {
        console.error('❌ Ошибка при создании тестовых данных:', error)
        
        let errorMessage = 'Ошибка при создании тестовых данных'
        if (error.response) {
          console.error('❌ Статус:', error.response.status)
          console.error('❌ Данные ошибки:', error.response.data)
          errorMessage = `Ошибка ${error.response.status}: ${JSON.stringify(error.response.data)}`
        } else if (error.request) {
          errorMessage = 'Сервер не отвечает. Проверьте подключение.'
        } else {
          errorMessage = error.message
        }
        
        alert('❌ ' + errorMessage)
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
        
        console.log('📤 Отправка тестовой заявки:', requestData)
        
        const response = await requestService.create(requestData)
        console.log('✅ Тестовая заявка создана, ответ:', response)
        
        alert('✅ Тестовая заявка успешно создана!')
        this.debugValues()
        
      } catch (error) {
        console.error('❌ Ошибка при создании тестовой заявки:', error)
        
        let errorMessage = 'Ошибка при создании тестовой заявки'
        if (error.response) {
          console.error('❌ Статус:', error.response.status)
          console.error('❌ Данные ошибки:', error.response.data)
          errorMessage = `Ошибка ${error.response.status}: ${JSON.stringify(error.response.data)}`
        } else if (error.request) {
          errorMessage = 'Сервер не отвечает. Проверьте подключение.'
        } else {
          errorMessage = error.message
        }
        
        alert('❌ ' + errorMessage)
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