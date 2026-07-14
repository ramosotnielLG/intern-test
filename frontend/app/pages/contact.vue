<template>
  <div class="py-20 bg-gradient-to-b from-[#757F9A] to-[#D7DDE8] px-6">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">

      <div class="order-2 md:order-1 bg-[#283048] rounded-3xl p-8 text-white shadow-xl flex flex-col justify-between border border-white/5">
        <div class="space-y-4">
          <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center">
            <svg viewBox="0 0 24 24" class="w-6 h-6 fill-[#3CCF29]">
              <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.28-1.39a9.9 9.9 0 0 0 4.76 1.21h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2Zm0 18.13a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.13.82.84-3.05-.2-.31a8.16 8.16 0 0 1-1.26-4.36c0-4.53 3.69-8.22 8.24-8.22 2.2 0 4.27.86 5.82 2.42a8.17 8.17 0 0 1 2.41 5.81c0 4.54-3.69 8.22-8.23 8.22Zm4.51-6.16c-.25-.12-1.46-.72-1.68-.8-.23-.08-.39-.12-.56.12-.16.25-.64.8-.78.96-.14.17-.29.19-.53.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.23-1.46-1.37-1.71-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.13-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.86.84-.86 2.05s.88 2.38 1 2.55c.13.17 1.73 2.65 4.2 3.71.59.25 1.05.4 1.41.52.59.19 1.13.16 1.55.1.47-.07 1.46-.6 1.67-1.17.2-.58.2-1.08.14-1.18-.06-.11-.23-.17-.48-.29Z"/>
            </svg>
          </div>
          <h3 class="text-2xl font-bold tracking-tight">Butuh Respon Cepat?</h3>
          <p class="text-slate-300 text-sm leading-relaxed">
            Hubungi tim sales kami melalui WhatsApp untuk mendapatkan konsultasi langsung dan penawaran instan.
          </p>
          <div class="flex items-center gap-2 text-xs text-slate-400 pt-2">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#3CCF29] opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-[#3CCF29]"></span>
            </span>
            Online — biasanya balas dalam 15 menit
          </div>
        </div>

        <a
          :href="waLink"
          target="_blank"
          rel="noopener noreferrer"
          class="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#3CCF29] hover:bg-[#35b825] px-6 py-4 text-sm font-bold text-white transition-all duration-300 shadow-lg shadow-black/20 hover:-translate-y-0.5 active:translate-y-0 text-center"
        >
          Chat via WhatsApp
        </a>
      </div>

      <div class="order-1 md:order-2 md:col-span-2 bg-white p-8 md:p-10 rounded-3xl shadow-xl border border-gray-100 flex flex-col justify-between">
        <div>
          <div class="space-y-1 mb-6">
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Formulir Inquiry</h2>
            <p class="text-slate-500 text-sm">Isi formulir di bawah ini untuk mengajukan penawaran atau konsultasi proyek.</p>
          </div>

          <transition name="el-zoom-in-top">
            <el-alert
              v-if="isSubmitted"
              title="Formulir inquiry berhasil dikirim!"
              description="Tim kami akan menghubungi Anda dalam 1x24 jam kerja."
              type="success"
              show-icon
              closable
              class="mb-6 rounded-xl"
              @close="isSubmitted = false"
            />
          </transition>

          <transition name="el-zoom-in-top">
            <el-alert
              v-if="submitError"
              title="Gagal mengirim formulir"
              :description="submitError"
              type="error"
              show-icon
              closable
              class="mb-6 rounded-xl"
              @close="submitError = ''"
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
                <el-input v-model="form.name" placeholder="Masukkan nama Anda" />
              </el-form-item>
              <el-form-item label="Nama Perusahaan" prop="company">
                <el-input v-model="form.company" placeholder="PT. Perusahaan Anda" />
              </el-form-item>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4">
              <el-form-item label="Email Bisnis" prop="email">
                <el-input v-model="form.email" placeholder="nama@perusahaan.com" />
              </el-form-item>
              <el-form-item label="Nomor Telepon / WA" prop="phone">
                <el-input v-model="form.phone" placeholder="+62 812..." />
              </el-form-item>
            </div>

            <el-form-item label="Jenis Kebutuhan" prop="inquiryType">
              <el-select v-model="form.inquiryType" placeholder="Pilih jenis kebutuhan" class="w-full">
                <el-option label="Penawaran Harga / Pengadaan" value="penawaran" />
                <el-option label="Konsultasi Produk" value="konsultasi" />
                <el-option label="Kerja Sama / Partnership" value="partnership" />
                <el-option label="Dukungan Purna Jual" value="support" />
                <el-option label="Lainnya" value="lainnya" />
              </el-select>
            </el-form-item>

            <el-form-item label="Subjek / Keperluan" prop="subject">
              <el-input v-model="form.subject" placeholder="Contoh: Penawaran Pengadaan Server" />
            </el-form-item>

            <el-form-item label="Pesan / Detail Kebutuhan" prop="message">
              <el-input
                v-model="form.message"
                type="textarea"
                :rows="4"
                maxlength="500"
                show-word-limit
                placeholder="Jelaskan kebutuhan spesifikasi atau detail proyek Anda..."
              />
            </el-form-item>

            <div
              class="!absolute !w-px !h-px !overflow-hidden !p-0 !m-[-1px] !whitespace-nowrap"
              style="clip: rect(0 0 0 0); clip-path: inset(50%);"
              aria-hidden="true"
            >
              <el-input v-model="form.website" tabindex="-1" autocomplete="off" />
            </div>

            <el-form-item prop="consent">
              <el-checkbox v-model="form.consent">
                Saya menyetujui data ini digunakan tim sales untuk keperluan follow-up sesuai
                <a href="/" class="text-rose-800 underline hover:text-rose-900">kebijakan privasi</a>.
              </el-checkbox>
            </el-form-item>

            <div class="mt-2">
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

:deep(.el-checkbox__input.is-checked .el-checkbox__inner) {
  background-color: #9f1239;
  border-color: #9f1239;
}
</style>

<script lang="ts" setup>
import { reactive, ref, computed } from 'vue'
import type { FormInstance, FormRules } from 'element-plus'
import { useApi } from '../composables/useApi'

definePageMeta({
  layout: 'public',
})

const formRef = ref<FormInstance>()

const isSubmitting = ref(false)
const isSubmitted = ref(false)
const submitError = ref('')

const form = reactive({
  name: '',
  company: '',
  email: '',
  phone: '',
  inquiryType: '',
  subject: '',
  message: '',
  consent: false,
  website: '',
})

const rules = reactive<FormRules>({
  name: [{ required: true, message: 'Nama lengkap wajib diisi', trigger: 'blur' }],
  company: [{ required: true, message: 'Nama perusahaan wajib diisi', trigger: 'blur' }],
  email: [
    { required: true, message: 'Email bisnis wajib diisi', trigger: 'blur' },
    { type: 'email', message: 'Format email tidak valid', trigger: ['blur', 'change'] },
  ],
  phone: [
    { required: true, message: 'Nomor telepon/WA wajib diisi', trigger: 'blur' },
    { pattern: /^[+()0-9\s-]{8,16}$/, message: 'Format nomor telepon tidak valid', trigger: 'blur' },
  ],
  inquiryType: [{ required: true, message: 'Pilih jenis kebutuhan Anda', trigger: 'change' }],
  subject: [{ required: true, message: 'Subjek keperluan wajib diisi', trigger: 'blur' }],
  message: [{ required: true, message: 'Pesan detail kebutuhan wajib diisi', trigger: 'blur' }],
  consent: [
    {
      validator: (_rule, value, callback) => {
        if (!value) callback(new Error('Anda harus menyetujui kebijakan privasi'))
        else callback()
      },
      trigger: 'change',
    },
  ],
})

const waLink = computed(() => {
  const text = encodeURIComponent('Halo, saya ingin bertanya mengenai produk/layanan Anda.')
  return `https://wa.me/6289637560279?text=${text}`
})

const { apiFetch, getErrorMessage } = useApi()

const onSubmit = async (formEl: FormInstance | undefined) => {
  if (!formEl) return

  await formEl.validate(async (valid, fields) => {
    if (!valid) {
      console.log('Validasi gagal!', fields)
      return
    }

    if (form.website) {
      isSubmitted.value = true
      formEl.resetFields()
      return
    }

    isSubmitting.value = true
    submitError.value = ''

    try {
      await apiFetch('/contact', {
        method: 'POST',
        body: {
          name: form.name,
          company: form.company || null,
          email: form.email,
          phone: form.phone || null,
          inquiry_type: form.inquiryType,
          subject: form.subject,
          message: form.message,
        },
      })

      isSubmitted.value = true
      formEl.resetFields()
    } catch (error) {
      submitError.value = getErrorMessage(error, 'Terjadi kesalahan. Silakan coba lagi beberapa saat lagi.')
      console.error('Gagal mengirim data', error)
    } finally {
      isSubmitting.value = false
    }
  })
}
</script>