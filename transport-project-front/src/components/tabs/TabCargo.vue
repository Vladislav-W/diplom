<template>
  <v-card flat class="pa-4">
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <!-- Заголовок синего цвета -->
          <div class="mb-4" style="display: inline-block;">
            <h3 class="text-h5 font-weight-bold" style="color: #1976d2">
              ИНФОРМАЦИЯ О ГРУЗЕ
            </h3>
            <v-divider class="mt-2" style="border-color: #1976d2; border-width: 2px 0 0 0; width: 100%;"></v-divider>
          </div>
          
          <!-- ========== КОНТЕЙНЕР 1: ОСНОВНАЯ ИНФОРМАЦИЯ ========== -->
          <v-card flat class="mb-4">
            <!-- Заголовок для дат и наименования -->
            <v-row class="mb-1">
              <v-col cols="12">
                <span class="text-subtitle-2 font-weight-medium grey--text text--darken-1">
                  Основная информация <span style="color: red;">*</span>
                </span>
              </v-col>
            </v-row>
            
            <!-- Первая строка: дата получения, срок доставки и краткое наименование -->
            <v-row class="mb-2">
              <v-col cols="12" md="3" class="py-0">
                <v-menu
                  ref="receiptDateMenu"
                  v-model="menus.receiptDate"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="receiptDate"
                      label="Дата получения"
                      placeholder="ДД.ММ.ГГГГ"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      variant="underlined"
                      density="compact"
                      hide-details
                      class="mt-0"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="receiptDate"
                    no-title
                    @input="menus.receiptDate = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              
              <v-col cols="12" md="3" class="py-0">
                <v-menu
                  ref="deliveryDateMenu"
                  v-model="menus.deliveryDate"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="deliveryDate"
                      label="Срок доставки"
                      placeholder="ДД.ММ.ГГГГ"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      variant="underlined"
                      density="compact"
                      hide-details
                      class="mt-0"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="deliveryDate"
                    no-title
                    @input="menus.deliveryDate = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              
              <v-col cols="12" md="6" class="py-0">
                <v-text-field
                  v-model="cargoName"
                  placeholder="Введите наименование груза"
                  variant="underlined"
                  density="compact"
                  :maxlength="200"
                  hide-details
                  class="mt-0"
                  :error-messages="errors.cargoName"
                  @input="validateField('cargoName')"
                >
                  <template v-slot:label>
                    Краткое наименование груза <span style="color: red;">*</span>
                  </template>
                </v-text-field>
                <div style="text-align: right; font-size: 12px; color: rgba(0,0,0,0.6); margin-top: 0px; line-height: 1.2;">
                  {{ cargoName.length }}/200
                </div>
              </v-col>
            </v-row>
            
            <!-- Вторая строка: вид упаковки, масса, объем, количество -->
            <v-row class="mb-2">
              <v-col cols="12" md="3" class="py-0">
                <v-select
                  v-model="packagingType"
                  :items="packagingTypes"
                  placeholder="Выберите вид упаковки"
                  variant="underlined"
                  density="compact"
                  hide-details
                  class="mt-0"
                  :error-messages="errors.packagingType"
                  @change="validateField('packagingType')"
                >
                  <template v-slot:label>
                    Вид упаковки <span style="color: red;">*</span>
                  </template>
                </v-select>
              </v-col>
              
              <v-col cols="12" md="3" class="py-0">
                <v-text-field
                  v-model="cargoWeight"
                  placeholder="0.00"
                  variant="underlined"
                  density="compact"
                  hide-details
                  type="number"
                  step="0.01"
                  class="mt-0"
                  :error-messages="errors.cargoWeight"
                  @input="validateField('cargoWeight')"
                >
                  <template v-slot:label>
                    Масса груза, т <span style="color: red;">*</span>
                  </template>
                </v-text-field>
              </v-col>
              
              <v-col cols="12" md="3" class="py-0">
                <v-text-field
                  v-model="cargoVolume"
                  placeholder="0.00"
                  variant="underlined"
                  density="compact"
                  hide-details
                  type="number"
                  step="0.01"
                  class="mt-0"
                  :error-messages="errors.cargoVolume"
                  @input="validateField('cargoVolume')"
                >
                  <template v-slot:label>
                    Объем груза, м³ <span style="color: red;">*</span>
                  </template>
                </v-text-field>
              </v-col>
              
              <v-col cols="12" md="3" class="py-0">
                <v-text-field
                  v-model="cargoQuantity"
                  placeholder="0"
                  variant="underlined"
                  density="compact"
                  hide-details
                  type="number"
                  class="mt-0"
                  :error-messages="errors.cargoQuantity"
                  @input="validateField('cargoQuantity')"
                >
                  <template v-slot:label>
                    Количество <span style="color: red;">*</span>
                  </template>
                </v-text-field>
              </v-col>
            </v-row>
            
            <!-- Третья строка: доп. сведения и класс опасности -->
            <v-row align="start" class="mb-0">
              <v-col cols="12" md="8" class="py-0">
                <v-textarea
                  v-model="additionalInfo"
                  placeholder="Введите дополнительную информацию"
                  variant="underlined"
                  density="compact"
                  :maxlength="500"
                  rows="2"
                  auto-grow
                  hide-details
                  class="custom-textarea mt-0"
                >
                  <template v-slot:label>
                    Дополнительные сведения при перевозке
                  </template>
                </v-textarea>
                <div style="text-align: right; font-size: 12px; color: rgba(0,0,0,0.6); margin-top: 0px; line-height: 1.2;">
                  {{ additionalInfo.length }}/500
                </div>
              </v-col>
              
              <v-col cols="12" md="4" class="py-0">
                <v-select
                  v-model="hazardClass"
                  :items="hazardClasses"
                  placeholder="Выберите класс"
                  variant="underlined"
                  density="compact"
                  hide-details
                  class="custom-select mt-0"
                >
                  <template v-slot:label>
                    Класс опасности (при наличии)
                  </template>
                </v-select>
                <!-- Пустой div для выравнивания высоты -->
                <div style="height: 18px;"></div>
              </v-col>
            </v-row>
          </v-card>
          
          <!-- ========== КОНТЕЙНЕР 2: МАТЕРИАЛЬНЫЕ ЦЕННОСТИ ========== -->
          <v-card flat class="mb-4">
            <!-- Заголовок синего цвета -->
            <h4 class="text-h6 font-weight-bold mb-3" style="color: #1976d2">
              Перечень материальных ценностей, подлежащих получению:
            </h4>
            
            <!-- Кнопка добавления -->
            <v-row class="mb-2">
              <v-col cols="12">
                <v-btn
                  color="primary"
                  @click="openDialog"
                  class="pa-1"
                  size="small"
                >
                  <v-avatar color="success" size="18" class="mr-1">
                    <v-icon size="12" color="white">mdi-plus</v-icon>
                  </v-avatar>
                  Добавить
                </v-btn>
              </v-col>
            </v-row>
            
            <!-- Таблица материальных ценностей -->
            <v-data-table
              :headers="materialHeaders"
              :items="paginatedItems"
              hide-default-footer
              class="elevation-1 mb-2"
              no-data-text="Отсутствие данных"
              dense
            >
              <!-- Кнопка удаления в каждой строке по центру - ИСПРАВЛЕННЫЙ СИНТАКСИС ДЛЯ VUE 2 -->
              <template slot="item.actions" slot-scope="{ item }">
                <div class="text-center">
                  <v-icon
                    small
                    color="error"
                    @click="deleteMaterialItem(item)"
                    style="cursor: pointer;"
                  >
                    mdi-delete
                  </v-icon>
                </div>
              </template>
            </v-data-table>

            <!-- Пагинация и выбор количества строк -->
            <PaginationControls
              :page="page"
              :items-per-page="itemsPerPage"
              :total-items="materialItems.length"
              :page-count="pageCount"
              @update:items-per-page="onItemsPerPageChange"
              @page-change="onPageChange"
            />
          </v-card>

          <!-- ========== НАДПИСЬ ОБ ОБЯЗАТЕЛЬНЫХ ПОЛЯХ ========== -->
          <RequiredFieldsNote />
        </v-col>
      </v-row>
    </v-card-text>

    <!-- ДИАЛОГОВОЕ ОКНО ДЛЯ ДОБАВЛЕНИЯ МАТЕРИАЛЬНОЙ ЦЕННОСТИ -->
    <v-dialog v-model="dialogVisible" max-width="500px" persistent>
      <v-card>
        <v-card-title class="primary white--text">
          <span class="text-h6">Добавление материальной ценности</span>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="closeDialog">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>

        <v-card-text class="pt-4">
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="newItem.name"
                  label="Наименование материальной ценности *"
                  placeholder="Введите наименование"
                  variant="underlined"
                  density="compact"
                  hide-details
                  class="mb-3"
                  :error-messages="nameError"
                ></v-text-field>
              </v-col>
              
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="newItem.quantity"
                  label="Количество *"
                  placeholder="0"
                  type="number"
                  variant="underlined"
                  density="compact"
                  hide-details
                  class="mb-3"
                  :error-messages="quantityError"
                ></v-text-field>
              </v-col>
              
              <v-col cols="12" md="6">
                <v-select
                  v-model="newItem.unit"
                  :items="unitOptions"
                  label="Единица измерения *"
                  placeholder="Выберите единицу"
                  variant="underlined"
                  density="compact"
                  hide-details
                  class="mb-3"
                  :error-messages="unitError"
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-1" text @click="closeDialog">
            Отмена
          </v-btn>
          <v-btn color="primary" @click="saveNewItem" :loading="saving">
            Сохранить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>

<script>
import { ref, computed, watch } from 'vue'
import PaginationControls from '@/components/common/PaginationControls.vue'
import RequiredFieldsNote from '@/components/common/RequiredFieldsNote.vue'

export default {
  name: 'TabCargo',
  components: {
    PaginationControls,
    RequiredFieldsNote
  },
  props: {
    initialData: {
      type: Object,
      default: () => ({
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
      })
    }
  },
  emits: ['update:cargoData'],
  setup(props, { emit }) {
    // Меню для дат
    const menus = ref({
      receiptDate: false,
      deliveryDate: false
    })

    // Поля формы с начальными значениями из props
    const receiptDate = ref(props.initialData.receiptDate || '')
    const deliveryDate = ref(props.initialData.deliveryDate || '')
    const cargoName = ref(props.initialData.cargoName || '')
    const packagingType = ref(props.initialData.packagingType || null)
    const cargoWeight = ref(props.initialData.cargoWeight || '')
    const cargoVolume = ref(props.initialData.cargoVolume || '')
    const cargoQuantity = ref(props.initialData.cargoQuantity || '')
    const additionalInfo = ref(props.initialData.additionalInfo || '')
    const hazardClass = ref(props.initialData.hazardClass || null)

    // Ошибки валидации
    const errors = ref({
      cargoName: '',
      packagingType: '',
      cargoWeight: '',
      cargoVolume: '',
      cargoQuantity: ''
    })

    // Данные для выпадающих списков
    const packagingTypes = ref([
      'Без упаковки',
      'Коробка картонная',
      'Паллета',
      'Контейнер',
      'Бочка',
      'Мешок',
      'Ящик деревянный',
      'Специальная упаковка'
    ])

    const hazardClasses = ref([
      '1 - Взрывчатые материалы',
      '2 - Газы',
      '3 - Легковоспламеняющиеся жидкости',
      '4 - Легковоспламеняющиеся твердые вещества',
      '5 - Окисляющие вещества',
      '6 - Токсичные вещества',
      '7 - Радиоактивные материалы',
      '8 - Едкие вещества',
      '9 - Прочие опасные вещества'
    ])

    // ========== ДАННЫЕ ДЛЯ ТАБЛИЦЫ МАТЕРИАЛЬНЫХ ЦЕННОСТЕЙ ==========
    // Заголовки таблицы
    const materialHeaders = ref([
      { 
        text: 'Наименование материальных ценностей', 
        value: 'name', 
        align: 'start', 
        sortable: true,
        width: '60%',
        class: 'grey--text text--darken-2'
      },
      { 
        text: 'Количество', 
        value: 'quantity', 
        align: 'center', 
        sortable: true,
        width: '20%',
        class: 'grey--text text--darken-2'
      },
      { 
        text: 'Единица измерения', 
        value: 'unit', 
        align: 'center', 
        sortable: true,
        width: '15%',
        class: 'grey--text text--darken-2'
      },
      { 
        text: 'Действия', 
        value: 'actions', 
        align: 'center', 
        sortable: false,
        width: '5%',
        class: 'grey--text text--darken-2'
      }
    ])

    // Данные таблицы с начальными значениями
    const materialItems = ref(props.initialData.materialItems || [])

    // Пагинация
    const page = ref(1)
    const itemsPerPage = ref(10)

    // Количество страниц
    const pageCount = computed(() => {
      return Math.ceil(materialItems.value.length / itemsPerPage.value)
    })

    // Пагинированные элементы
    const paginatedItems = computed(() => {
      const start = (page.value - 1) * itemsPerPage.value
      const end = start + itemsPerPage.value
      return materialItems.value.slice(start, end)
    })

    // ========== ДИАЛОГОВОЕ ОКНО ==========
    const dialogVisible = ref(false)
    const saving = ref(false)
    
    // Новый элемент для добавления
    const newItem = ref({
      name: '',
      quantity: '',
      unit: null
    })
    
    // Ошибки валидации
    const nameError = ref('')
    const quantityError = ref('')
    const unitError = ref('')
    
    // Варианты единиц измерения
    const unitOptions = ref(['шт', 'кг', 'л', 'м', 'компл', 'упак'])

    // Валидация полей
    const validateField = (field) => {
      switch(field) {
        case 'cargoName':
          errors.value.cargoName = cargoName.value ? '' : 'Поле обязательно для заполнения'
          break
        case 'packagingType':
          errors.value.packagingType = packagingType.value ? '' : 'Поле обязательно для заполнения'
          break
        case 'cargoWeight':
          errors.value.cargoWeight = cargoWeight.value ? '' : 'Поле обязательно для заполнения'
          break
        case 'cargoVolume':
          errors.value.cargoVolume = cargoVolume.value ? '' : 'Поле обязательно для заполнения'
          break
        case 'cargoQuantity':
          errors.value.cargoQuantity = cargoQuantity.value ? '' : 'Поле обязательно для заполнения'
          break
      }
    }

    // Проверка всех полей
    const validateAll = () => {
      validateField('cargoName')
      validateField('packagingType')
      validateField('cargoWeight')
      validateField('cargoVolume')
      validateField('cargoQuantity')
      
      return !errors.value.cargoName && 
             !errors.value.packagingType && 
             !errors.value.cargoWeight && 
             !errors.value.cargoVolume && 
             !errors.value.cargoQuantity
    }

    // Получить данные груза
    const getCargoData = () => {
      return {
        receiptDate: receiptDate.value,
        deliveryDate: deliveryDate.value,
        cargoName: cargoName.value,
        packagingType: packagingType.value,
        cargoWeight: cargoWeight.value,
        cargoVolume: cargoVolume.value,
        cargoQuantity: cargoQuantity.value,
        additionalInfo: additionalInfo.value,
        hazardClass: hazardClass.value,
        materialItems: materialItems.value
      }
    }

    // Следим за изменениями и отправляем родителю
    watch([receiptDate, deliveryDate, cargoName, packagingType, cargoWeight, 
           cargoVolume, cargoQuantity, additionalInfo, hazardClass, materialItems], 
          () => {
      emit('update:cargoData', getCargoData())
    }, { deep: true })

    // Метод для открытия диалога
    const openDialog = () => {
      newItem.value = {
        name: '',
        quantity: '',
        unit: null
      }
      nameError.value = ''
      quantityError.value = ''
      unitError.value = ''
      dialogVisible.value = true
    }

    // Метод для закрытия диалога
    const closeDialog = () => {
      dialogVisible.value = false
    }

    // Метод для сохранения нового элемента
    const saveNewItem = () => {
      // Валидация
      let isValid = true
      
      if (!newItem.value.name) {
        nameError.value = 'Поле обязательно для заполнения'
        isValid = false
      } else {
        nameError.value = ''
      }
      
      if (!newItem.value.quantity) {
        quantityError.value = 'Поле обязательно для заполнения'
        isValid = false
      } else if (isNaN(newItem.value.quantity) || Number(newItem.value.quantity) <= 0) {
        quantityError.value = 'Введите положительное число'
        isValid = false
      } else {
        quantityError.value = ''
      }
      
      if (!newItem.value.unit) {
        unitError.value = 'Поле обязательно для заполнения'
        isValid = false
      } else {
        unitError.value = ''
      }
      
      if (!isValid) return

      saving.value = true
      
      // Добавляем новый элемент в таблицу
      const item = {
        id: Date.now(),
        name: newItem.value.name,
        quantity: Number(newItem.value.quantity),
        unit: newItem.value.unit
      }
      
      materialItems.value.push(item)
      page.value = pageCount.value
      
      saving.value = false
      dialogVisible.value = false
    }

    // Метод для удаления элемента из таблицы
    const deleteMaterialItem = (item) => {
      if (confirm(`Удалить "${item.name}" из списка?`)) {
        const index = materialItems.value.findIndex(i => i.id === item.id)
        if (index !== -1) {
          materialItems.value.splice(index, 1)
        }
      }
    }

    // Обработчики пагинации
    const onItemsPerPageChange = (newValue) => {
      itemsPerPage.value = newValue
      page.value = 1
    }

    const onPageChange = (newPage) => {
      page.value = newPage
    }

    return {
      menus,
      receiptDate,
      deliveryDate,
      cargoName,
      packagingType,
      cargoWeight,
      cargoVolume,
      cargoQuantity,
      additionalInfo,
      hazardClass,
      packagingTypes,
      hazardClasses,
      materialHeaders,
      materialItems,
      page,
      itemsPerPage,
      pageCount,
      paginatedItems,
      errors,
      dialogVisible,
      saving,
      newItem,
      nameError,
      quantityError,
      unitError,
      unitOptions,
      validateField,
      validateAll,
      getCargoData,
      deleteMaterialItem,
      onItemsPerPageChange,
      onPageChange,
      openDialog,
      closeDialog,
      saveNewItem
    }
  }
}
</script>

<style scoped>
.custom-textarea {
  margin-bottom: 0 !important;
}

.custom-select {
  margin-top: 0 !important;
}

.v-textarea.custom-textarea .v-input__control {
  min-height: 76px !important;
}
</style>