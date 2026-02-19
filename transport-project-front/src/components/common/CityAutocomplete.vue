<template>
  <v-autocomplete
    :value="value"
    :items="cities"
    :loading="loading"
    :label="label"
    :placeholder="placeholder"
    item-text="name"
    item-value="city_id"
    @input="$emit('input', $event)"
    @update:search-input="searchCities"
    dense
    outlined
    hide-details
    clearable
  ></v-autocomplete>
</template>

<script>
import { cityService } from '@/services/cityService';

export default {
  name: 'CityAutocomplete',
  props: {
    value: [Number, String],
    label: {
      type: String,
      default: 'Город'
    },
    placeholder: {
      type: String,
      default: 'Выберите город'
    }
  },
  data() {
    return {
      cities: [],
      loading: false,
      searchTimeout: null
    };
  },
  mounted() {
    this.loadCities();
  },
  methods: {
    async loadCities() {
      this.loading = true;
      try {
        const data = await cityService.getAll();
        this.cities = data.data || data;
      } catch (error) {
        console.error('Ошибка загрузки городов:', error);
      } finally {
        this.loading = false;
      }
    },
    searchCities(search) {
      clearTimeout(this.searchTimeout);
      if (!search) {
        this.loadCities();
        return;
      }
      
      this.searchTimeout = setTimeout(async () => {
        this.loading = true;
        try {
          const data = await cityService.getAll();
          const allCities = data.data || data;
          this.cities = allCities.filter(city => 
            city.name.toLowerCase().includes(search.toLowerCase())
          );
        } catch (error) {
          console.error('Ошибка поиска городов:', error);
        } finally {
          this.loading = false;
        }
      }, 300);
    }
  }
};
</script>