<template>
  <ArticleForm
    @save="onSave"
  />
  <div class="control-section">
    <ejs-richtexteditor 
      v-model="form.description" 
      :insertImageSettings="pengaturanGambar"
      placeholder="Tulis konten artikel kamu di sini..."
    >
    </ejs-richtexteditor>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'
import ArticleForm from '~/components/Admin/ArticleForm.vue'
import { useApi } from '~/composables/useApi'
import type { ArticleApi } from '~/types/admin'

const form = ref({
  title: '',
  description: '',
  status: 'draft'
})

const pengaturanGambar = ref({
  saveUrl: 'http://localhost:8000/api/v1/articles/upload-image',
  path: '',
  allowedExtentions: ['.jpeg', '.jpg', '.png', '.gif'],
  maxFileSize: 2097152
})

const router = useRouter()
const { apiFetch, getErrorMessage } = useApi()

const onSave = async (payload: any) => {
  try {
    await apiFetch<ArticleApi>('/articles', {
      method: 'POST',
      body: payload,
    })
    ElMessage.success('Article created successfully.')
    router.push('/admin/articles')
  } catch (error) {
    ElMessage.error(getErrorMessage(error, 'Failed to create article.'))
  }
}
</script>
