<template>
  <v-card flat class="pa-4">
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <!-- Заголовок синего цвета с линией под ним -->
          <div class="mb-6" style="display: inline-block;">
            <h3 class="text-h5 font-weight-bold" style="color: #1976d2">
              ПОЛУЧЕНИЕ МАТЕРИАЛЬНЫХ ЦЕННОСТЕЙ ПО ДОКУМЕНТУ
            </h3>
            <v-divider class="mt-2" style="border-color: #1976d2; border-width: 2px 0 0 0; width: 100%;"></v-divider>
          </div>
  
          <!-- Два контейнера рядом -->
          <v-row>
            <!-- ========== КОНТЕЙНЕР 1: ПУНКТ ПОГРУЗКИ ========== -->
            <v-col cols="12" md="6">
              <h4 class="text-h6 font-weight-bold mb-4" style="color: #1976d2">
                Пункт погрузки:
              </h4>
              
              <!-- Организация с кнопкой справа -->
              <v-row no-gutters class="mb-3">
                <v-col cols="12">
                  <v-row no-gutters>
                    <v-col cols="9">
                      <v-text-field
                        label="Организация"
                        placeholder="Введите организацию"
                        outlined
                        dense
                        required
                        hide-details
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
                      >
                        <v-icon>mdi-folder-search</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
              
              <!-- Город и Адрес слева, Примечание справа -->
              <v-row>
                <!-- Левая колонка с городом и адресом -->
                <v-col cols="7">
                  <v-row>
                    <v-col cols="12" class="pb-0">
                      <v-text-field
                        label="Город погрузки"
                        placeholder="Введите город"
                        outlined
                        dense
                        required
                        hide-details
                      >
                        <template v-slot:label>
                          Город погрузки <span style="color: red;">*</span>
                        </template>
                      </v-text-field>
                    </v-col>
                  </v-row>
                  <v-row class="mt-3">
                    <v-col cols="12">
                      <v-text-field
                        label="Адрес откуда"
                        placeholder="Введите адрес"
                        outlined
                        dense
                        required
                        hide-details
                      >
                        <template v-slot:label>
                          Адрес откуда <span style="color: red;">*</span>
                        </template>
                      </v-text-field>
                    </v-col>
                  </v-row>
                </v-col>
                
                <!-- Правая колонка с примечанием (на всю высоту) -->
                <v-col cols="5">
                  <v-textarea
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
            
            <!-- ========== КОНТЕЙНЕР 2: ПУНКТ РАЗГРУЗКИ ========== -->
            <v-col cols="12" md="6">
              <h4 class="text-h6 font-weight-bold mb-4" style="color: #1976d2">
                Пункт разгрузки:
              </h4>
              
              <!-- Организация с кнопкой справа -->
              <v-row no-gutters class="mb-3">
                <v-col cols="12">
                  <v-row no-gutters>
                    <v-col cols="9">
                      <v-text-field
                        label="Организация"
                        placeholder="Введите организацию"
                        outlined
                        dense
                        required
                        hide-details
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
                      >
                        <v-icon>mdi-folder-search</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
              
              <!-- Город и Адрес слева, Примечание справа -->
              <v-row>
                <!-- Левая колонка с городом и адресом -->
                <v-col cols="7">
                  <v-row>
                    <v-col cols="12" class="pb-0">
                      <v-text-field
                        label="Город разгрузки"
                        placeholder="Введите город"
                        outlined
                        dense
                        required
                        hide-details
                      >
                        <template v-slot:label>
                          Город разгрузки <span style="color: red;">*</span>
                        </template>
                      </v-text-field>
                    </v-col>
                  </v-row>
                  <v-row class="mt-3">
                    <v-col cols="12">
                      <v-text-field
                        label="Адрес куда"
                        placeholder="Введите адрес"
                        outlined
                        dense
                        required
                        hide-details
                      >
                        <template v-slot:label>
                          Адрес куда <span style="color: red;">*</span>
                        </template>
                      </v-text-field>
                    </v-col>
                  </v-row>
                </v-col>
                
                <!-- Правая колонка с примечанием (на всю высоту) -->
                <v-col cols="5">
                  <v-textarea
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

          <!-- ========== КОНТЕЙНЕР 3: ОТВЕТСТВЕННЫЙ ЗА ЗАЯВКУ ========== -->
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
                  <v-autocomplete
                    v-model="selectedDepartment"
                    :items="departments"
                    label="Подразделение"
                    placeholder="Введите подразделение"
                    variant="underlined"
                    density="compact"
                    hide-details
                    clearable
                    menu-props="auto"
                    @change="onDepartmentChange"
                  ></v-autocomplete>
                </v-col>
                
                <v-col cols="12" md="4" class="pa-0 pr-2">
                  <v-autocomplete
                    v-model="selectedEmployee"
                    :items="filteredEmployees"
                    label="Фамилия Имя Отчество"
                    placeholder="Введите ФИО"
                    variant="underlined"
                    density="compact"
                    hide-details
                    clearable
                    menu-props="auto"
                    :disabled="!selectedDepartment"
                    @change="onEmployeeChange"
                  ></v-autocomplete>
                </v-col>
                
                <v-col cols="12" md="4" class="pa-0 pr-2">
                  <v-text-field
                    v-model="position"
                    label="Должность"
                    placeholder="Введите должность"
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

          <!-- ========== КОНТЕЙНЕР 4: ДОВЕРЕННОСТЬ ========== -->
          <v-row class="mt-6">
            <v-col cols="12">
              <h4 class="text-h6 font-weight-bold mb-2" style="color: #1976d2">
                Доверенность:
              </h4>
              
              <v-checkbox
                v-model="needPowerOfAttorney"
                label="Требуется доверенность водителю"
                color="primary"
                hide-details
                class="mt-0"
              ></v-checkbox>
            </v-col>
          </v-row>

          <!-- ========== НАДПИСЬ ОБ ОБЯЗАТЕЛЬНЫХ ПОЛЯХ ========== -->
          <RequiredFieldsNote />
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
import { ref, computed, watch } from 'vue'
import RequiredFieldsNote from '@/components/common/RequiredFieldsNote.vue'

export default {
  name: 'TabRoute',
  components: {
    RequiredFieldsNote
  },
  props: {
    departments: {
      type: Array,
      required: true
    },
    employees: {
      type: Array,
      required: true
    },
    initialDepartment: {
      type: String,
      default: null
    },
    initialEmployee: {
      type: String,
      default: null
    }
  },
  emits: ['update:selectedDepartment', 'update:selectedEmployee'],
  setup(props, { emit }) {
    // Локальные состояния с начальными значениями
    const needPowerOfAttorney = ref(false)
    const selectedDepartment = ref(props.initialDepartment)
    const selectedEmployee = ref(props.initialEmployee)
    const position = ref('')
    const workPhone = ref('')

    // Фильтруем сотрудников по выбранному подразделению
    const filteredEmployees = computed(() => {
      if (!selectedDepartment.value) return []
      return props.employees.filter(e => e.department === selectedDepartment.value)
    })

    // Следим за выбором сотрудника
    watch(selectedEmployee, (newValue) => {
      if (newValue) {
        const employee = props.employees.find(e => e.value === newValue)
        if (employee) {
          position.value = employee.position
          workPhone.value = employee.phone
        }
      } else {
        position.value = ''
        workPhone.value = ''
      }
    })

    // Следим за изменениями и отправляем родителю
    watch(selectedDepartment, (newValue) => {
      emit('update:selectedDepartment', newValue)
    })

    watch(selectedEmployee, (newValue) => {
      emit('update:selectedEmployee', newValue)
    })

    // Обработчики изменений
    const onDepartmentChange = () => {
      selectedEmployee.value = null
      position.value = ''
      workPhone.value = ''
    }

    const onEmployeeChange = () => {
      // Дополнительная логика при выборе сотрудника
    }

    return {
      needPowerOfAttorney,
      selectedDepartment,
      selectedEmployee,
      position,
      workPhone,
      filteredEmployees,
      onDepartmentChange,
      onEmployeeChange
    }
  }
}
</script>