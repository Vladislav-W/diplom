<template>
  <v-main>
    <v-container fluid class="px-4 pt-4 pb-0">
      <!-- РЯД КНОПОК СЛЕВА ПОД ШАПКОЙ С ИКОНКАМИ -->
      <v-row no-gutters class="mb-4">
        <!-- Кнопка Заявка -->
        <v-col cols="auto" class="mr-3">
          <v-btn
              depressed
              color="primary"
              large
              @click="navigateTo('requests')"
          >
            <v-icon left>mdi-clipboard-edit-outline</v-icon>
            ЗАЯВКИ
          </v-btn>
        </v-col>

        <!-- Кнопка Новая заявка (теперь ведет на текущую страницу) -->
        <v-col cols="auto" class="mr-3">
          <v-btn
              depressed
              color="primary"
              large
              @click="navigateTo('new-request')"
          >
            <v-icon left>mdi-truck</v-icon>
            НОВАЯ ЗАЯВКА
          </v-btn>
        </v-col>

        <!-- Кнопка Все заявки -->
        <v-col cols="auto">
          <v-btn
              depressed
              color="primary"
              large
              @click="navigateTo('all-requests')"
          >
            <v-icon left>mdi-clipboard-list-outline</v-icon>
            ВСЕ ЗАЯВКИ
          </v-btn>
        </v-col>
      </v-row>

      <!-- ЗАГОЛОВОК И КНОПКИ ДЕЙСТВИЙ -->
      <v-row class="mb-0">
        <!-- Заголовок слева -->
        <v-col cols="12" sm="6" class="d-flex align-center">
          <div class="text-h5 font-weight-bold" style="color: #1976d2">
            Заявка от {{ currentDate }} - оформление
          </div>
        </v-col>

        <!-- Кнопки справа -->
        <v-col cols="12" sm="6" class="text-sm-right">
          <v-btn
              depressed
              large
              class="mr-2 mb-2 mb-sm-0"
              color="grey lighten-1"
              dark
          >
            <v-icon left>mdi-send</v-icon>
            ОТПРАВИТЬ НА СОГЛАСОВАНИЕ
          </v-btn>

          <v-btn
              depressed
              large
              color="grey lighten-1"
              dark
          >
            <v-icon left>mdi-content-save</v-icon>
            СОХРАНИТЬ
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
export default {
  name: 'ActionButtons',
  props: {
    currentDate: {
      type: String,
      required: true
    }
  },
  methods: {
    navigateTo(section) {
      try {
        switch(section) {
          case 'requests':
            this.$router.push('/requests')
            break
          case 'new-request':
            this.$router.push('/new-request')
            break
          case 'all-requests':
            this.$router.push('/all-requests')
            break
          default:
            console.log(`Переходим в раздел: ${section}`)
        }
      } catch (error) {
        if (error.name !== 'NavigationDuplicated') {
          console.error(error)
        }
      }
    }
  }
}
</script>

<style scoped>
.v-container {
  padding-bottom: 0 !important;
}

.v-main {
  min-height: auto !important;
}

.v-row {
  margin-bottom: 0 !important;
}

@media (max-width: 600px) {
  .text-h5 {
    font-size: 1.2rem !important;
  }
}
</style>