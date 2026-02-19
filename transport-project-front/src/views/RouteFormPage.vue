<template>
  <v-container fluid class="pa-4">
    <v-row class="mb-4">
      <v-col cols="12">
        <h1 class="text-h4 font-weight-bold" style="color: #1976d2">
          ФОРМИРОВАНИЕ МАРШРУТА
        </h1>
        <v-divider class="mt-2" style="border-color: #1976d2; border-width: 2px;"></v-divider>
      </v-col>
    </v-row>

    <!-- Кнопка возврата -->
    <v-row class="mb-4">
      <v-col cols="12">
        <v-btn color="primary" @click="$router.push('/requests')">
          <v-icon left>mdi-arrow-left</v-icon>
          Назад к заявкам
        </v-btn>
      </v-col>
    </v-row>

    <!-- Заглушка -->
    <v-card class="pa-8 text-center">
      <v-icon size="64" color="primary" class="mb-4">mdi-route</v-icon>
      <h2 class="text-h4 mb-3">Готово к дальнейшей разработке</h2>
      <p class="text-subtitle-1 grey--text">Функционал формирования маршрута находится в разработке</p>
      <v-btn 
        color="primary" 
        outlined 
        class="mt-4"
        @click="$router.push('/requests')"
      >
        Вернуться к списку заявок
      </v-btn>
    </v-card>
  </v-container>
</template>

<script>
export default {
  name: 'RouteFormPage'
}
</script>