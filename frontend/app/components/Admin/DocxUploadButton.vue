<script setup lang="ts">
const props = defineProps<{
  uploadUrl: string
  xsrfToken: string
}>()

const emit = defineEmits<{
  converted: [html: string]
}>()

const fileInput = ref<HTMLInputElement | null>(null)
const loading = ref(false)
const error = ref<string | null>(null)

function triggerFileSelect() {
  fileInput.value?.click()
}


async function handleFileChange(e: Event) {
  const target = e.target as HTMLInputElement
  const file = target.files?.[0]
  if (!file) return

  if (!file.name.toLowerCase().endsWith('.docx')) {
    error.value = 'File harus berformat .docx'
    target.value = ''
    return
  }

  loading.value = true
  error.value = null

  try {
    const formData = new FormData()
    formData.append('file', file)

    const data = await $fetch<{ success: boolean; html?: string; message?: string }>(
      props.uploadUrl,
      {
        method: 'POST',
        headers: {
          'X-XSRF-TOKEN': props.xsrfToken || '',
        },
        credentials: 'include',
        body: formData,
      }
    )

    if (!data.success || !data.html) {
      throw new Error(data.message || 'Gagal mengconvert file')
    }

    emit('converted', data.html)
  } catch (err: any) {
    error.value = err?.data?.message || err.message || 'Terjadi kesalahan saat upload'
  } finally {
    loading.value = false
    if (fileInput.value) fileInput.value.value = ''
  }
}
</script>

<template>
  <div class="mb-2">
    <button
      type="button"
      :disabled="loading"
      class="px-3 py-1.5 text-sm border rounded-md bg-white hover:bg-gray-50 disabled:opacity-50"
      @click="triggerFileSelect"
    >
      {{ loading ? 'Memproses...' : 'Upload dari Word (.docx)' }}
    </button>
    <input
      ref="fileInput"
      type="file"
      accept=".docx"
      class="hidden"
      @change="handleFileChange"
    />
    <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
  </div>
</template>