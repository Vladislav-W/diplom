<template>
  <v-row class="mt-0 justify-end" style="align-items: baseline;">
    <v-col cols="auto" class="d-flex align-baseline py-0" style="gap: 16px; margin-top: 2px;">
      <div class="d-flex align-baseline" style="gap: 4px;">
        <span class="pagination-text">Строк на странице:</span>
        <div style="width: 50px;">
          <v-select
            :value="itemsPerPage"
            :items="[5, 10, 15, 20, 50, 100]"
            variant="underlined"
            density="compact"
            hide-details
            @input="onItemsPerPageChange($event)"
            class="pagination-select"
          ></v-select>
        </div>
      </div>
      
      <span class="pagination-text">
        {{ rangeText }}
      </span>
      
      <div class="d-flex align-center" style="gap: 2px;">
        <v-btn
          icon
          x-small
          @click="onPageChange(page - 1)"
          :disabled="page === 1"
          class="pagination-arrow"
        >
          <v-icon small>mdi-chevron-left</v-icon>
        </v-btn>
        
        <span class="pagination-text" style="min-width: 24px; text-align: center;">{{ page }}</span>
        
        <v-btn
          icon
          x-small
          @click="onPageChange(page + 1)"
          :disabled="page === pageCount || pageCount === 0"
          class="pagination-arrow"
        >
          <v-icon small>mdi-chevron-right</v-icon>
        </v-btn>
      </div>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'PaginationControls',
  props: {
    page: {
      type: Number,
      required: true
    },
    itemsPerPage: {
      type: Number,
      required: true
    },
    totalItems: {
      type: Number,
      required: true
    },
    pageCount: {
      type: Number,
      required: true
    }
  },
  computed: {
    rangeText() {
      if (this.totalItems === 0) {
        return '0 - 0 из 0'
      }
      const start = (this.page - 1) * this.itemsPerPage + 1
      const end = Math.min(this.page * this.itemsPerPage, this.totalItems)
      return `${start} - ${end} из ${this.totalItems}`
    }
  },
  methods: {
    onItemsPerPageChange(event) {
      this.$emit('update:itemsPerPage', event)
      this.$emit('page-change', 1)
    },
    onPageChange(newPage) {
      this.$emit('page-change', newPage)
    }
  }
}
</script>

<style scoped>
.pagination-text {
  font-size: 12px !important;
  line-height: 18px !important;
  color: rgba(0, 0, 0, 0.6) !important;
  white-space: nowrap;
  margin: 0 !important;
}

.pagination-select {
  font-size: 12px !important;
  margin: 0 !important;
  padding: 0 !important;
  min-height: 18px !important;
}

.pagination-select .v-input__control {
  min-height: 18px !important;
  margin: 0 !important;
  padding: 0 !important;
}

.pagination-select .v-field__input {
  min-height: 18px !important;
  padding: 0 !important;
  margin: 0 !important;
  line-height: 18px !important;
}

.pagination-select .v-select__selection {
  font-size: 12px !important;
  line-height: 18px !important;
  padding: 0 !important;
  margin: 0 !important;
}

.pagination-select .v-field {
  padding: 0 !important;
  margin: 0 !important;
  min-height: 18px !important;
}

.pagination-select .v-field__outline {
  display: none !important;
}

.pagination-arrow {
  box-shadow: none !important;
  background: transparent !important;
  min-width: 24px !important;
  width: 24px !important;
  height: 24px !important;
  margin: 0 !important;
  padding: 0 !important;
}

.pagination-arrow:hover {
  background: rgba(0, 0, 0, 0.05) !important;
}

.pagination-arrow.v-btn--disabled {
  opacity: 0.3;
  pointer-events: none;
}

.v-btn--icon .v-icon {
  font-size: 18px !important;
}
</style>