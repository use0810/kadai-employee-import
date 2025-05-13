<template>
  <div class="upload-container">
    <label
      ref="dropRef"
      class="drop-zone"
      @click="fileInput.click()"
    >
      <p class="drop-message"> CSVファイルをドラッグ＆ドロップ<br>またはクリックして選択</p>
      <p v-if="file">選択中: {{ file.name }}</p>
      <p v-if="uploading" class="text-blue">アップロード中...</p>
      <p v-if="success" class="text-green">{{ success }}</p>
      <p v-if="error" class="text-red">{{ error }}</p>
      <input
        ref="fileInput"
        type="file"
        accept=".csv"
        class="hidden-input"
        @change="handleFileChange"
      />
    </label>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useDropZone } from '@vueuse/core'
import axios from 'axios'

const dropRef = ref<HTMLElement | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)
const file = ref<File | null>(null)
const uploading = ref(false)
const success = ref<string | null>(null)
const error = ref<string | null>(null)

const uploadFile = async (file: File) => {
  const formData = new FormData()
  formData.append('file', file)

  uploading.value = true
  success.value = null
  error.value = null

  try {
    const response = await axios.post(
      `${import.meta.env.VITE_API_BASE_URL}/api/import-employees`,
      formData,
      {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Accept': 'application/json',
        },
      }
    )

    console.log('アップロード成功:', response.data)
    success.value = 'アップロードが完了しました！'
  } catch (err) {
    console.error('アップロード失敗:', err)
    error.value = 'アップロードに失敗しました。'
  } finally {
    uploading.value = false
    setTimeout(() => {
      success.value = null
      error.value = null
    }, 3000)
  }
}

const handleFileChange = (event: Event) => {
  const input = event.target as HTMLInputElement
  const selectedFile = input.files?.[0]
  if (selectedFile && selectedFile.type === 'text/csv') {
    file.value = selectedFile
    uploadFile(selectedFile)
  } else {
    error.value = 'CSVファイルのみアップロード可能です。'
  }
}

useDropZone(dropRef, {
  onDrop(files) {
    const droppedFile = files[0]
    if (droppedFile && droppedFile.type === 'text/csv') {
      file.value = droppedFile
      uploadFile(droppedFile)
    } else {
      error.value = 'CSVファイルのみアップロード可能です。'
      file.value = null
    }
  },
})
</script>

<style scoped>
.upload-container {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}
.drop-zone {
  border: 2px dashed #ccc;
  border-radius: 12px;
  padding: 2rem;
  text-align: center;
  width: 100%;
  max-width: 400px;
  cursor: pointer;
  transition: border-color 0.3s, background-color 0.3s;
}
.drop-zone:hover {
  border-color: #3182ce;
  background-color: #f0f8ff;
}
.hidden-input {
  display: none;
}
.drop-message {
  font-size: 1rem;
  color: #555;
  margin-bottom: 1rem;
}
.text-red {
  color: #e53e3e;
}
.text-green {
  color: #38a169;
}
.text-blue {
  color: #3182ce;
}
</style>
