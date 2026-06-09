<template>
  <div class="py-20 bg-gradient-to-b from-[#757F9A] to-[#D7DDE8] px-6">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
      
      <!-- CARD LEFT: WhatsApp Contact (Menggunakan warna #283048 & Crimson Rose) -->
      <div class="bg-[#283048] rounded-3xl p-8 text-white shadow-xl flex flex-col justify-between border border-white/5">
        <div class="space-y-4">
          <h3 class="text-2xl font-bold tracking-tight">Butuh Respon Cepat?</h3>
          <p class="text-slate-300 text-sm leading-relaxed">
            Hubungi tim sales kami melalui WhatsApp untuk mendapatkan konsultasi langsung dan penawaran instan.
          </p>
        </div>
        
        <a
          href="https://wa.me/6289637560279"
          target="_blank" 
          class="mt-8 inline-flex w-full items-center justify-center rounded-2xl bg-[#3CCF29] hover:bg-[#4AB03E] px-6 py-4 text-sm font-bold text-white transition-all duration-300 shadow-lg shadow-[#4AB03E/40] hover:-translate-y-0.5 active:translate-y-0 text-center"
        >
          Chat via WhatsApp
        </a>
      </div>

      <div class="md:col-span-2 bg-white p-8 md:p-10 rounded-3xl shadow-xl border border-gray-100 flex flex-col justify-between">
        <div>
          <div class="space-y-1 mb-6">
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Formulir Inquiry</h2>
            <p class="text-slate-500 text-sm">Isi formulir di bawah ini untuk mengajukan penawaran atau konsultasi proyek.</p>
          </div>

          <transition name="el-zoom-in-top">
            <el-alert 
              v-if="isSubmitted"
              title="Formulir inquiry berhasil dikirim!" 
              type="success" 
              show-icon
              closable
              class="mb-6 rounded-xl"
              @close="isSubmitted = false"
            />
          </transition>

          <el-form 
            ref="formRef" 
            :model="form" 
            :rules="rules" 
            label-width="auto" 
            class="bg-white" 
            label-position="top"
          >
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4">
              <el-form-item label="Nama Lengkap" prop="name">
                <el-input v-model="form.name" placeholder="Masukkan nama Anda"/>
              </el-form-item>
              <el-form-item label="Nama Perusahaan" prop="company">
                <el-input v-model="form.company" placeholder="PT. Perusahaan Anda"/>
              </el-form-item>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4">    
              <el-form-item label="Email Bisnis" prop="email">
                <el-input v-model="form.email" placeholder="nama@perusahaan.com"/>
              </el-form-item>
              <el-form-item label="Nomor Telepon / WA" prop="phone">
                <el-input v-model="form.phone" placeholder="+62 812..."/>
              </el-form-item>
            </div>

            <el-form-item label="Subjek / Keperluan" prop="subject">
              <el-input v-model="form.subject" placeholder="Contoh: Penawaran Pengadaan Server" />
            </el-form-item>

            <el-form-item label="Pesan / Detail Kebutuhan" prop="message">
              <el-input v-model="form.message" type="textarea" :rows="4" placeholder="Jelaskan kebutuhan spesifikasi atau detail proyek Anda..."></el-input>
            </el-form-item>

            <div class="mt-6">
              <el-button 
                class="!bg-rose-800 hover:!bg-rose-900 !border-none w-full sm:w-auto !px-8 !py-5 !rounded-xl !font-bold !h-auto tracking-wide" 
                type="primary" 
                :loading="isSubmitting" 
                @click="onSubmit(formRef)"
              >
                Kirim Pesan Inquiry
              </el-button>
            </div>

          </el-form>
        </div>
      </div>

    </div>
  </div>
</template>

<style scoped>
:deep(.el-input__wrapper.is-focus),
:deep(.el-textarea__inner:focus) {
  box-shadow: 0 0 0 1px #be123c inset !important;
}

:deep(.el-form-item__label) {
  font-weight: 600;
  color: #334155;
  margin-bottom: 4px !important;
}

:deep(.el-input__inner),
:deep(.el-textarea__inner) {
  padding: 8px 4px;
}
</style>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import type { FormInstance, FormRules } from 'element-plus'
import { fa } from 'element-plus/es/locale/index.mjs'
import { useApi } from '../composables/useApi'  

definePageMeta({
  layout: 'public',
})

const formRef = ref<FormInstance>()

const isSubmitting = ref(false)
const isSubmitted = ref(false)

const form = reactive({
  name: '',
  company: '',
  email: '',
  phone: '',
  subject: '',
  message: '',
})

const rules = reactive<FormRules>({
  name: [{ required: true, message: 'Nama lengkap wajib diisi', trigger: 'blur' }],
  company: [{ required: true, message: 'Nama perusahaan wajib diisi', trigger: 'blur' }],
  email: [
    { required: true, message: 'Email bisnis wajib diisi', trigger: 'blur' },
    { type: 'email', message: 'Format email tidak valid', trigger: ['blur', 'change'] }
  ],
  phone: [{ required: true, message: 'Nomor telepon/WA wajib diisi', trigger: 'blur' }],
  subject: [{ required: true, message: 'Subjek keperluan wajib diisi', trigger: 'blur' }],
  message: [{ required: true, message: 'Pesan detail kebutuhan wajib diisi', trigger: 'blur' }],
})

const { apiFetch, getErrorMessage } = useApi()
const onSubmit = async (formEl: FormInstance | undefined) => {
  if (!formEl) return

  await formEl.validate(async (valid, fields) => {
    if (valid) {
      isSubmitting.value = true 
      try {
        await apiFetch('/contact', {
          method: 'POST',
          body: {
            name: form.name,
            company: form.company || null,
            email: form.email,
            phone: form.phone || null,
            subject: form.subject,
            message: form.message,
          },
        })
        
        isSubmitted.value = true
        formEl.resetFields()
      } catch (error) {
        console.error('Gagal mengirim data', error)
      } finally {
        isSubmitting.value = false
      }
    } else {
      console.log('Validasi gagal!', fields)
    }
  })
}
</script>