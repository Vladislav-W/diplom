<template>
  <div class="blue-header">
    <v-container fluid>
      <v-row justify="space-between" no-gutters style="height: 60px">
        <!-- ЛЕВАЯ ЧАСТЬ -->
        <v-col cols="auto">
          <v-row no-gutters>
            <!-- ЭМБЛЕМА -->
            <v-col cols="auto">
              <v-img
                  :src="require('@/assets/logo_2.png')"
                  height="50"
                  width="50"
              />
            </v-col>

            <!-- РАЗДЕЛИТЕЛЬ -->
            <v-col cols="auto" class="mx-3">
              <div style="
                  width: 2px;
                  margin-top: 5px;
                  height: 50px;
                  background-color: #90caf9;"
              ></div>
            </v-col>

            <!-- ТЕКСТ В ДВЕ СТРОЧКИ -->
            <v-col cols="auto">
              <div style="line-height: 1.2">
                <div
                    class="text-h6"
                    style="color: whitesmoke;
                    letter-spacing: 0.5px"
                >
                  ПСЗ
                </div>
                <div
                    class="text-subtitle-1"
                    style="color: whitesmoke;
                    font-weight: 500"
                >
                  РОСАТОМ
                </div>
              </div>
            </v-col>
          </v-row>
        </v-col>

        <!-- ЦЕНТРАЛЬНЫЙ ЗАГОЛОВОК -->
        <v-col cols="auto" class="Tourist d-none d-sm-flex">
          <div
              class="text-h4 font-weight-bold"
              style="color: white;
              margin-top: 13px"
          >
            ЗАКАЗ ГРУЗОВЫХ ПЕРЕВОЗОК
          </div>
        </v-col>

        <!-- ПРАВАЯ ЧАСТЬ (пока пустая) -->
        <v-col cols="auto">
          <!-- Может содержать меню или кнопки -->
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script setup>
// Нет логики
</script>

<style scoped>
.blue-header {
  background: linear-gradient(15deg, #1976d2, #1976d2);
  width: 100%;
  padding: 0;
}

@media (max-width: 960px) {
  .blue-header .text-h4 {
    font-size: 1.75rem !important;
  }
}

@media (max-width: 768px) {
  .blue-header .text-h4 {
    font-size: 1.5rem !important;
  }
}

@media (max-width: 600px) {
  .blue-header .text-h4 {
    font-size: 1.25rem;
  }
}
</style>