<template>
  <div>
    <v-file-input
      :value="value"
      :label="label"
      :placeholder="placeholder"
      :loading="uploading"
      :disabled="uploading"
      @change="handleFileChange"
      outlined
      dense
      chips
      show-size
      counter
      multiple
    ></v-file-input>

    <v-progress-linear
      v-if="uploading"
      :value="uploadProgress"
      height="4"
      color="primary"
      class="mt-2"
    ></v-progress-linear>

    <v-alert
      v-if="error"
      type="error"
      dense
      dismissible
      class="mt-2"
      @input="error = ''"
    >
      {{ error }}
    </v-alert>
  </div>
</template>

<script>
export default {
  name: 'FileUpload',
  props: {
    value: Array,
    label: {
      type: String,
      default: 'Прикрепить файлы'
    },
    placeholder: {
      type: String,
      default: 'Выберите файлы'
    }
  },
  data() {
    return {
      uploading: false,
      uploadProgress: 0,
      error: ''
    };
  },
  methods: {
    handleFileChange(files) {
      if (!files || files.length === 0) {
        this.$emit('input', []);
        return;
      }
      
      this.$emit('input', files);
      this.$emit('files-selected', files);
    },
    
    startUpload() {
      this.uploading = true;
      this.uploadProgress = 0;
      this.error = '';
    },
    
    updateProgress(progress) {
      this.uploadProgress = progress;
    },
    
    finishUpload() {
      this.uploading = false;
      this.uploadProgress = 0;
    },
    
    setError(message) {
      this.error = message;
      this.uploading = false;
    }
  }
};
</script>