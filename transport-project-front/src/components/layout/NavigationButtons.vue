<template>
  <v-container fluid class="px-4 pt-4 pb-0">
    <!-- РЯД КНОПОК СЛЕВА ПОД ШАПКОЙ С ИКОНКАМИ -->
    <v-row no-gutters class="mb-4">
      <!-- Кнопка Заявка -->
      <v-col cols="auto" class="mr-3">
        <v-btn
            depressed
            :color="activeButton === 'requests' ? 'primary' : 'grey lighten-2'"
            :class="{ 'active-button': activeButton === 'requests' }"
            large
            @click="navigateTo('requests')"
        >
          <v-icon left :color="activeButton === 'requests' ? 'white' : 'grey darken-1'">
            mdi-clipboard-edit-outline
          </v-icon>
          <span :class="{ 'white--text': activeButton === 'requests', 'grey--text text--darken-1': activeButton !== 'requests' }">
            ЗАЯВКИ
          </span>
        </v-btn>
      </v-col>

      <!-- Кнопка Новая заявка -->
      <v-col cols="auto" class="mr-3">
        <v-btn
            depressed
            :color="activeButton === 'new-request' ? 'primary' : 'grey lighten-2'"
            :class="{ 'active-button': activeButton === 'new-request' }"
            large
            @click="navigateTo('new-request')"
        >
          <v-icon left :color="activeButton === 'new-request' ? 'white' : 'grey darken-1'">
            mdi-truck
          </v-icon>
          <span :class="{ 'white--text': activeButton === 'new-request', 'grey--text text--darken-1': activeButton !== 'new-request' }">
            НОВАЯ ЗАЯВКА
          </span>
        </v-btn>
      </v-col>

      <!-- Кнопка Все заявки -->
      <v-col cols="auto">
        <v-btn
            depressed
            :color="activeButton === 'all-requests' ? 'primary' : 'grey lighten-2'"
            :class="{ 'active-button': activeButton === 'all-requests' }"
            large
            @click="navigateTo('all-requests')"
        >
          <v-icon left :color="activeButton === 'all-requests' ? 'white' : 'grey darken-1'">
            mdi-clipboard-list-outline
          </v-icon>
          <span :class="{ 'white--text': activeButton === 'all-requests', 'grey--text text--darken-1': activeButton !== 'all-requests' }">
            ВСЕ ЗАЯВКИ
          </span>
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'NavigationButtons',
  data() {
    return {
      activeButton: 'new-request' // По умолчанию активна кнопка "Новая заявка"
    }
  },
  watch: {
    // Следим за изменением маршрута
    '$route.path': {
      immediate: true,
      handler(path) {
        if (path.includes('/requests') && !path.includes('/all-requests')) {
          this.activeButton = 'requests'
        } else if (path.includes('/new-request')) {
          this.activeButton = 'new-request'
        } else if (path.includes('/all-requests')) {
          this.activeButton = 'all-requests'
        }
      }
    }
  },
  methods: {
    navigateTo(section) {
      try {
        let path = ''
        switch(section) {
          case 'requests':
            path = '/requests'
            break
          case 'new-request':
            path = '/new-request'
            break
          case 'all-requests':
            path = '/all-requests'
            break
          default:
            return
        }
        
        // Если уже на этой странице, не делаем ничего
        if (this.$route.path === path) {
          return
        }
        
        this.$router.push(path)
        // activeButton обновится автоматически через watch
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

.v-row {
  margin-bottom: 0 !important;
}

/* Стили для активной кнопки */
.active-button {
  box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2) !important;
  transform: translateY(-1px);
  transition: all 0.2s ease;
}

/* Адаптивность */
@media (max-width: 600px) {
  .v-btn {
    font-size: 12px !important;
    padding: 0 8px !important;
    min-width: 80px !important;
  }
}

@media (max-width: 400px) {
  .v-btn {
    font-size: 11px !important;
    padding: 0 4px !important;
    min-width: 70px !important;
  }
  
  .v-icon {
    font-size: 18px !important;
  }
}
</style>