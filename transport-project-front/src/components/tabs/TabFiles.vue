<template>
  <v-card flat class="pa-4">
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <div class="mb-4" style="display: inline-block;">
            <h3 class="text-h5 font-weight-bold" style="color: #1976d2">
              ПРИКРЕПЛЕННЫЕ ФАЙЛЫ
            </h3>
            <v-divider class="mt-2" style="border-color: #1976d2; border-width: 2px 0 0 0; width: 100%;"></v-divider>
          </div>
          
          <v-card flat class="mb-4">
            <v-file-input v-model="selectedFiles" label="Прикрепите файлы" variant="outlined" dense multiple
              prepend-icon="mdi-paperclip" class="mb-2" chips show-size counter :loading="uploading"
              :disabled="uploading" @change="handleFileUpload" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.txt,.zip,.rar"
            ></v-file-input>
            
            <v-progress-linear
              v-if="uploading"
              :value="uploadProgress" height="4" color="primary" class="mb-2">
            </v-progress-linear>
            
            <v-alert
              v-if="uploadError"
              type="error" dense dismissible class="mb-2" @input="uploadError = ''">
              {{ uploadError }}
            </v-alert>
          </v-card>

          <v-card flat class="mb-4">
            <v-card-title class="pa-0 mb-2 text-subtitle-2 font-weight-bold">
              Загруженные файлы ({{ files.length }})
            </v-card-title>
            
            <v-divider class="mb-3"></v-divider>
            
            <v-list v-if="files.length > 0" dense class="pa-0">
              <v-list-item
                v-for="file in files"
                :key="file.id" class="pa-2 mb-1" style="border: 1px solid #e0e0e0; border-radius: 4px;">
                <v-list-item-icon class="mr-3">
                  <v-icon :color="getFileIconColor(file.type)">
                    {{ getFileIcon(file.type) }}
                  </v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                  <v-list-item-title class="text-body-2 font-weight-medium">
                    {{ file.name }}
                  </v-list-item-title>
                  <v-list-item-subtitle class="text-caption">
                    {{ formatFileSize(file.size) }} • {{ formatDate(file.uploadedAt) }}
                  </v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-action class="d-flex flex-row">
                  <v-btn icon small color="primary" @click="downloadFile(file)" class="mr-1" :disabled="file.loading">
                    <v-icon small>mdi-download</v-icon>
                  </v-btn>
                  <v-btn icon small color="error" @click="confirmDeleteFile(file)" :loading="file.loading">
                    <v-icon small>mdi-delete</v-icon>
                  </v-btn>
                </v-list-item-action>
              </v-list-item>
            </v-list>

            <div v-else class="text-center pa-4 grey--text">
              <v-icon size="48" color="grey lighten-1">mdi-file-outline</v-icon>
              <p class="text-body-1 mt-2">Нет загруженных файлов</p>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-card-text>

    <v-dialog v-model="deleteDialog" max-width="400px">
      <v-card>
        <v-card-title class="error white--text">
          <span class="text-h6">Подтверждение удаления</span>
        </v-card-title>
        <v-card-text class="pt-4">
          <p class="text-body-1">
            Вы действительно хотите удалить файл <strong>"{{ fileToDelete?.name }}"</strong>?
          </p>
          <p class="text-caption grey--text">Это действие нельзя отменить.</p>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-1" text @click="deleteDialog = false">
            Отмена
          </v-btn>
          <v-btn color="error" @click="deleteFile" :loading="deleting">
            Удалить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>

<script>
import { ref, watch } from 'vue'
import { fileService } from '@/services/fileService'

export default {
  name: 'TabFiles',
  props: {
    initialFiles: {
      type: Array,
      default: () => []
    }
  },

  emits: ['update:files'],
  setup(props, { emit }) {
    const selectedFiles = ref([])
    const uploading = ref(false)
    const uploadProgress = ref(0)
    const uploadError = ref('')
    const files = ref([...props.initialFiles])
    const deleteDialog = ref(false)
    const deleting = ref(false)
    const fileToDelete = ref(null)

    watch(files, (newFiles) => {
      emit('update:files', newFiles)
    }, { deep: true })

    const MAX_FILE_SIZE = 10 * 1024 * 1024

    const ALLOWED_TYPES = [
      'application/pdf',
      'image/jpeg',
      'image/png',
      'image/gif',
      'application/msword',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      'application/vnd.ms-excel',
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'text/plain',
      'application/zip',
      'application/x-rar-compressed'
    ]

    const getFileIcon = (type) => {
      if (type.includes('pdf')) return 'mdi-file-pdf'
      if (type.includes('image')) return 'mdi-file-image'
      if (type.includes('word') || type.includes('document')) return 'mdi-file-word'
      if (type.includes('excel') || type.includes('sheet')) return 'mdi-file-excel'
      if (type.includes('zip') || type.includes('rar')) return 'mdi-file-zip'
      if (type.includes('text')) return 'mdi-file-document'
      return 'mdi-file'
    }

    const getFileIconColor = (type) => {
      if (type.includes('pdf')) return 'red'
      if (type.includes('image')) return 'green'
      if (type.includes('word')) return 'blue'
      if (type.includes('excel')) return 'green darken-2'
      if (type.includes('zip') || type.includes('rar')) return 'orange'
      if (type.includes('text')) return 'grey'
      return 'primary'
    }

    const formatFileSize = (bytes) => {
      if (bytes === 0) return '0 Б'
      const k = 1024
      const sizes = ['Б', 'КБ', 'МБ', 'ГБ']
      const i = Math.floor(Math.log(bytes) / Math.log(k))
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
    }

    const formatDate = (date) => {
      return new Date(date).toLocaleString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    }

    const validateFile = (file) => {
      if (file.size > MAX_FILE_SIZE) {
        return `Файл "${file.name}" слишком большой (максимум 10 МБ)`
      }
      if (!ALLOWED_TYPES.includes(file.type) && !file.type.startsWith('image/')) {
        return `Недопустимый тип файла "${file.name}"`
      }
      return null
    }

    const handleFileUpload = async () => {
      if (!selectedFiles.value || selectedFiles.value.length === 0) return

      uploadError.value = ''
      
      const errors = []
      const validFiles = []

      for (const file of selectedFiles.value) {
        const error = validateFile(file)
        if (error) {
          errors.push(error)
        } else {
          validFiles.push(file)
        }
      }

      if (errors.length > 0) {
        uploadError.value = errors.join('\n')
        selectedFiles.value = []
        return
      }

      for (const file of validFiles) {
        const newFile = {
          id: 'temp_' + Date.now() + '_' + Math.random(),
          name: file.name,
          size: file.size,
          type: file.type,
          uploadedAt: new Date().toISOString(),
          raw: file,
          loading: false
        }
        files.value.push(newFile)
      }
      
      selectedFiles.value = []
      uploadProgress.value = 0
    }

    const confirmDeleteFile = (file) => {
      fileToDelete.value = file
      deleteDialog.value = true
    }

    const deleteFile = async () => {
      if (!fileToDelete.value) return

      deleting.value = true
      
      try {
        if (!fileToDelete.value.id.toString().startsWith('temp_')) {
          await fileService.delete(fileToDelete.value.id)
        }
        
        const index = files.value.findIndex(f => f.id === fileToDelete.value.id)
        if (index !== -1) {
          files.value.splice(index, 1)
        }
      } catch (error) {
        console.error('Ошибка при удалении файла:', error)
        alert('Не удалось удалить файл')
      } finally {
        deleting.value = false
        deleteDialog.value = false
        fileToDelete.value = null
      }
    }

    const downloadFile = async (file) => {
      file.loading = true   
      try {
        if (file.id.toString().startsWith('temp_') && file.raw) {
          const url = URL.createObjectURL(file.raw)
          const link = document.createElement('a')
          link.href = url
          link.download = file.name
          link.click()
          URL.revokeObjectURL(url)
        } else {
          const blob = await fileService.download(file.id)
          const url = URL.createObjectURL(blob)
          const link = document.createElement('a')
          link.href = url
          link.download = file.name
          link.click()
          URL.revokeObjectURL(url)
        }
      } catch (error) {
        console.error('Ошибка при скачивании файла:', error)
        alert('Не удалось скачать файл')
      } finally {
        file.loading = false
      }
    }

    return {
      selectedFiles,
      uploading,
      uploadProgress,
      uploadError,
      files,
      deleteDialog,
      deleting,
      fileToDelete,
      getFileIcon,
      getFileIconColor,
      formatFileSize,
      formatDate,
      handleFileUpload,
      confirmDeleteFile,
      deleteFile,
      downloadFile
    }
  }
}
</script>