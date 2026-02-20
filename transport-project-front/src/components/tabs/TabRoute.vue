<template>
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
            <v-col cols="6">
              <h4 class="text-h6 font-weight-bold mb-4" style="color: #1976d2">
                Пункт погрузки:
              </h4>
              
              <!-- Организация с кнопкой справа -->
              <v-row no-gutters class="mb-3">
                <v-col cols="12">
                  <v-row no-gutters>
                    <v-col cols="9">
                      <v-text-field
                        v-model="localOrganizationFromName"
                        label="Организация *"
                        placeholder="Введите организацию"
                        outlined
                        dense
                        required
                        hide-details
                        :error-messages="errors.organization_from_name"
                        @input="$emit('update:organization-from-name', $event)"
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
                        @click="$emit('open-org-dialog', 'from')"
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
                        v-model="localDepartureCityId"
                        :items="cities"
                        item-text="name"
                        item-value="city_id"
                        label="Город погрузки *"
                        placeholder="Введите город"
                        outlined
                        dense
                        required
                        hide-details
                        :loading="loadingCities"
                        :error-messages="errors.departure_city_id"
                        @change="$emit('update:departure-city-id', $event)"
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
                        v-model="localAddressFrom"
                        label="Адрес откуда *"
                        placeholder="Введите адрес"
                        outlined
                        dense
                        required
                        hide-details
                        :error-messages="errors.address_from"
                        @input="$emit('update:address-from', $event)"
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
                    v-model="localNotesFrom"
                    label="Примечание"
                    placeholder="Введите примечание"
                    outlined
                    dense
                    rows="3"
                    hide-details
                    style="height: 100%;"
                    class="fill-height"
                    @input="$emit('update:notes-from', $event)"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-col>
            
            <!-- Пункт разгрузки -->
            <v-col cols="6">
              <h4 class="text-h6 font-weight-bold mb-4" style="color: #1976d2">
                Пункт разгрузки:
              </h4>
              
              <!-- Организация с кнопкой справа -->
              <v-row no-gutters class="mb-3">
                <v-col cols="12">
                  <v-row no-gutters>
                    <v-col cols="9">
                      <v-text-field
                        v-model="localOrganizationToName"
                        label="Организация *"
                        placeholder="Введите организацию"
                        outlined
                        dense
                        required
                        hide-details
                        :error-messages="errors.organization_to_name"
                        @input="$emit('update:organization-to-name', $event)"
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
                        @click="$emit('open-org-dialog', 'to')"
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
                        v-model="localArrivalCityId"
                        :items="cities"
                        item-text="name"
                        item-value="city_id"
                        label="Город разгрузки *"
                        placeholder="Введите город"
                        outlined
                        dense
                        required
                        hide-details
                        :loading="loadingCities"
                        :error-messages="errors.arrival_city_id"
                        @change="$emit('update:arrival-city-id', $event)"
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
                        v-model="localAddressTo"
                        label="Адрес куда *"
                        placeholder="Введите адрес"
                        outlined
                        dense
                        required
                        hide-details
                        :error-messages="errors.address_to"
                        @input="$emit('update:address-to', $event)"
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
                    v-model="localNotesTo"
                    label="Примечание"
                    placeholder="Введите примечание"
                    outlined
                    dense
                    rows="3"
                    hide-details
                    style="height: 100%;"
                    class="fill-height"
                    @input="$emit('update:notes-to', $event)"
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
              
              <!-- Заголовки в один ряд -->
              <v-row class="ma-0">
                <v-col cols="2" class="pa-0">
                  <span class="text-subtitle-2 font-weight-medium">Подразделение</span>
                </v-col>
                <v-col cols="4" class="pa-0">
                  <span class="text-subtitle-2 font-weight-medium">Фамилия Имя Отчество</span>
                </v-col>
                <v-col cols="4" class="pa-0">
                  <span class="text-subtitle-2 font-weight-medium">Должность</span>
                </v-col>
                <v-col cols="2" class="pa-0">
                  <span class="text-subtitle-2 font-weight-medium">Телефон - рабочий</span>
                </v-col>
              </v-row>
              
              <!-- Поля ввода в один ряд -->
              <v-row class="mt-1 ma-0">
                <v-col cols="2" class="pa-0 pr-2">
                  <v-select
                    :value="selectedDepartment"
                    :items="uniqueDepartments"
                    label="Подразделение"
                    placeholder="Выберите подразделение"
                    variant="underlined"
                    density="compact"
                    hide-details
                    clearable
                    @input="$emit('update:department', $event)"
                  ></v-select>
                </v-col>
                
                <v-col cols="4" class="pa-0 pr-2">
                  <v-select
                    :value="selectedResponsiblePerson"
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
                    @input="$emit('update:person', $event)"
                  ></v-select>
                </v-col>
                
                <v-col cols="4" class="pa-0 pr-2">
                  <v-text-field
                    :value="position"
                    label="Должность"
                    placeholder="Должность"
                    variant="underlined"
                    density="compact"
                    hide-details
                    readonly
                  ></v-text-field>
                </v-col>
                
                <v-col cols="2" class="pa-0">
                  <v-text-field
                    :value="workPhone"
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
                :value="attorneyForDriver"
                label="Требуется доверенность водителю"
                color="primary"
                hide-details
                class="mt-0"
                @change="$emit('update:attorney', $event)"
              ></v-checkbox>
            </v-col>
          </v-row>

          <RequiredFieldsNote />
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
import RequiredFieldsNote from '@/components/common/RequiredFieldsNote.vue'

export default {
  name: 'TabRoute',
  components: {
    RequiredFieldsNote
  },
  props: {
    // Города и организации для выпадающих списков
    cities: {
      type: Array,
      required: true
    },
    responsiblePeople: {
      type: Array,
      required: true
    },
    
    // Состояния загрузки
    loadingCities: {
      type: Boolean,
      default: false
    },
    
    // Данные форм
    organizationFromName: {
      type: String,
      default: ''
    },
    organizationToName: {
      type: String,
      default: ''
    },
    departureCityId: {
      type: [Number, String],
      default: null
    },
    addressFrom: {
      type: String,
      default: ''
    },
    notesFrom: {
      type: String,
      default: ''
    },
    arrivalCityId: {
      type: [Number, String],
      default: null
    },
    addressTo: {
      type: String,
      default: ''
    },
    notesTo: {
      type: String,
      default: ''
    },
    selectedDepartment: {
      type: String,
      default: null
    },
    selectedResponsiblePerson: {
      type: [Number, String],
      default: null
    },
    position: {
      type: String,
      default: ''
    },
    workPhone: {
      type: String,
      default: ''
    },
    attorneyForDriver: {
      type: Boolean,
      default: false
    },
    
    // Ошибки валидации
    errors: {
      type: Object,
      default: () => ({
        organization_from_name: '',
        organization_to_name: '',
        departure_city_id: '',
        address_from: '',
        arrival_city_id: '',
        address_to: ''
      })
    }
  },
  computed: {
    // Локальные вычисляемые свойства для двусторонней привязки
    localOrganizationFromName: {
      get() { return this.organizationFromName },
      set(value) { this.$emit('update:organization-from-name', value) }
    },
    localOrganizationToName: {
      get() { return this.organizationToName },
      set(value) { this.$emit('update:organization-to-name', value) }
    },
    localDepartureCityId: {
      get() { return this.departureCityId },
      set(value) { this.$emit('update:departure-city-id', value) }
    },
    localAddressFrom: {
      get() { return this.addressFrom },
      set(value) { this.$emit('update:address-from', value) }
    },
    localNotesFrom: {
      get() { return this.notesFrom },
      set(value) { this.$emit('update:notes-from', value) }
    },
    localArrivalCityId: {
      get() { return this.arrivalCityId },
      set(value) { this.$emit('update:arrival-city-id', value) }
    },
    localAddressTo: {
      get() { return this.addressTo },
      set(value) { this.$emit('update:address-to', value) }
    },
    localNotesTo: {
      get() { return this.notesTo },
      set(value) { this.$emit('update:notes-to', value) }
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
    }
  }
}
</script>