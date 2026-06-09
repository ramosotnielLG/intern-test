<template>
  <div class="min-h-[80vh] bg-gradient-to-l from-[#859398] to-[#283048] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto w-full max-w-md">
      <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200/80">
        
        <div class="text-center mb-8">
          <p class="text-xs font-bold uppercase tracking-[0.3em] text-gray-700">Admin Access</p>
          <h1 class="mt-2 text-3xl font-bold text-gray-700">Sign In</h1>
          <div class="w-12 h-1 bg-[#0E0E39] mx-auto mt-3 rounded-full"></div>
        </div>

        <el-form ref="formRef" :model="form" :rules="rules" label-position="top" class="space-y-4">
          
          <el-form-item label="Email" prop="email">
            <el-input @keydown.enter="submitForm" v-model="form.email" placeholder="admin@lamsolusi.com" />
          </el-form-item>
          
          <el-form-item label="Password" prop="password">
            <el-input @keydown.enter="submitForm" v-model="form.password" type="password" show-password placeholder="Masukkan password" />
          </el-form-item>

          <div class="flex items-center justify-between text-sm pt-2 pb-4">
            <el-checkbox v-model="form.remember" class="!text-gray-500">Remember me</el-checkbox>
            <span class="text-gray-400 text-xs flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
              </svg>
              Secure access
            </span>
          </div>

          <el-button 
            type="primary" 
            class="w-full !bg-[#13134F] hover:!bg-[#0E0E39] !border-none !rounded-full !py-5 !font-bold !text-white transition duration-200 shadow-md cursor-pointer tracking-wide" 
            :loading="isSubmitting" 
            @click="submitForm"
          >
            MASUK
          </el-button>
        </el-form>
        
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ElMessage, ElNotification } from 'element-plus'
import type { FormInstance, FormRules } from 'element-plus'
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useApi } from '~/composables/useApi'

definePageMeta({
  layout: 'public',
})

type LoginForm = {
  email: string
  password: string
  remember: boolean
}

const formRef = ref<FormInstance>()
const form = reactive<LoginForm>({
  email: '',
  password: '',
  remember: false,
})

const rules = reactive<FormRules<LoginForm>>({
  email: [
    { required: true, message: 'Email wajib diisi', trigger: 'change' },
    { type: 'email' as const, message: 'Format email tidak valid', trigger: 'change' },
  ],
  password: [{ required: true, message: 'Password wajib diisi', trigger: 'change' }],
})

const isSubmitting = ref(false)
const router = useRouter()
const { apiFetch, getErrorMessage } = useApi()

const submitForm = async () => {
  const formEl = formRef.value
  if (!formEl) return

  await formEl.validate(async (valid) => {
    if (valid) {
      isSubmitting.value = true
      try {
        const data = await apiFetch<any>('/auth/login', {
          method: 'POST',
          body: {
            email: form.email,
            password: form.password,
            remember: form.remember,
          },
        })
        ElMessage.success('Login berhasil')

        const userRole = data?.role ?? data.role
        
        if (userRole === 3) {
          await router.push('/writer/dashboard')
        } else if (userRole === 1 || userRole === 2) {
          await router.push('/admin/dashboard')
        } else {
          await router.push('/') // fallback
        }
        
      } catch (error) {
        ElMessage.error(getErrorMessage(error, 'Login gagal.'))
      } finally {
        isSubmitting.value = false
      }
    } else {
      ElNotification({
        title: 'Error',
        message: 'Email dan Password wajib diisi dengan benar',
        type: 'error',
      })
    }
  })
}
</script>
