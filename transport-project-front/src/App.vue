<template>
  <v-app>
    <AppHeader />
    <NavigationButtons />
    <router-view />
  </v-app>
</template>

<script>
import AppHeader from '@/components/layout/AppHeader.vue';
import NavigationButtons from '@/components/layout/NavigationButtons.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
    NavigationButtons
  }
};
</script>