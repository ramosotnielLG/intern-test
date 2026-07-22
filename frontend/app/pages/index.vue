<template>
  <div class="max-w-6xl mx-auto px-6 py-10">
    <el-carousel height="500px" class="rounded-3xl overflow-hidden shadow-lg">
      <el-carousel-item v-for="(slide, index) in slides" :key="index" class="relative rounded-3xl overflow-hidden">
        <img :src="slide.image" class="w-full h-full object-cover" :alt="slide.title" />
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/40 to-transparent flex flex-col justify-center items-center text-white text-center px-6">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight drop-shadow-sm">
              {{ slide.title }}
            </h1>
            <p class="mt-4 text-lg md:text-xl text-gray-200 max-w-xl leading-relaxed">
              {{ slide.description }}
            </p>
            <NuxtLink :to="slide.link">
              <button class="mt-8 bg-rose-800 hover:bg-rose-900 text-white px-8 py-3.5 rounded-xl font-bold transition-all duration-300 hover:shadow-lg hover:shadow-rose-700/30 hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                {{ slide.buttonText }}
              </button>
            </NuxtLink>
          </div>
      </el-carousel-item>
    </el-carousel>
  </div>

  <div class="max-w-3xl mx-auto text-center py-16 px-6">
    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 tracking-tight">
      Everything is Possible!
    </h1>
    <p class="text-slate-500 mt-4 text-base md:text-lg leading-relaxed">
      From logo design to video animation, web development to website copy, expert designers, developers, and digital talent are ready to complete your projects.
    </p>
  </div>

  <div class="max-w-6xl mx-auto px-6 pb-12 grid md:grid-cols-2 gap-8">
    <div class="flex gap-5 p-5 rounded-2xl border border-gray-50 hover:bg-gray-50/50 transition-all duration-300">
      <div class="p-3 bg-blue-50 rounded-xl h-fit">
        <img src="/img/telescope.png" class="w-10 h-10 object-contain">
      </div>
      <div>
        <h3 class="font-bold text-lg text-slate-800 mb-1">Discover core features</h3>
        <p class="text-slate-500 leading-relaxed text-sm">You can create awesome and powerful bootstrap landing pages with megapack and pixfort builder.</p>
      </div>
    </div>

    <div class="flex gap-5 p-5 rounded-2xl border border-gray-50 hover:bg-gray-50/50 transition-all duration-300">
      <div class="p-3 bg-purple-50 rounded-xl h-fit">
        <img src="/img/responsive.png" class="w-10 h-10 object-contain">
      </div>
      <div>
        <h3 class="font-bold text-lg text-slate-800 mb-1">Make responsive pages</h3>
        <p class="text-slate-500 leading-relaxed text-sm">You can create awesome and powerful bootstrap landing pages with megapack and pixfort builder.</p>
      </div>
    </div>

    <div class="flex gap-5 p-5 rounded-2xl border border-gray-50 hover:bg-gray-50/50 transition-all duration-300">
      <div class="p-3 bg-green-50 rounded-xl h-fit">
        <img src="/img/search.png" class="w-10 h-10 object-contain">
      </div>
      <div>
        <h3 class="font-bold text-lg text-slate-800 mb-1">Access to source code</h3>
        <p class="text-slate-500 leading-relaxed text-sm">You can create awesome and powerful bootstrap landing pages with megapack and pixfort builder.</p>
      </div>
    </div>

    <div class="flex gap-5 p-5 rounded-2xl border border-gray-50 hover:bg-gray-50/50 transition-all duration-300">
      <div class="p-3 bg-rose-50 rounded-xl h-fit">
        <img src="/img/meter.png" class="w-10 h-10 object-contain">
      </div>
      <div>
        <h3 class="font-bold text-lg text-slate-800 mb-1">SEO optimized</h3>
        <p class="text-slate-500 leading-relaxed text-sm">You can create awesome and powerful bootstrap landing pages with megapack and pixfort builder.</p>
      </div>
    </div>
  </div>

  <div class="flex justify-center pb-20">
    <NuxtLink to="/contact"><button class="bg-rose-800 font-bold text-white rounded-full px-10 py-4.5 hover:bg-rose-900 hover:shadow-lg hover:shadow-rose-700/20 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer tracking-wide text-sm">
      MAKE YOUR OWN SITE
    </button></NuxtLink>
  </div>

  <div class="bg-gray-50/70 py-20 border-y border-gray-100">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
      
      <div class="space-y-6">
        <div class="flex gap-5 p-4 rounded-xl">
          <img src="/img/circle compas.png" class="w-14 h-14 object-contain">
          <div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">Pixel Perfect Templates</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Create powerful bootstrap landing pages with megapack and pixfort builder.</p>
          </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-gray-100/50 flex gap-5">
          <img src="/img/layers.png" class="w-14 h-14 object-contain">
          <div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">High quality pages</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Create powerful bootstrap landing pages with megapack and pixfort builder.</p>
          </div>
        </div>

        <div class="flex gap-5 p-4 rounded-xl">
          <img src="/img/circle compas.png" class="w-14 h-14 object-contain">
          <div>
            <h3 class="text-xl font-bold text-slate-800 mb-1">SEO optimized</h3>
            <p class="text-slate-500 text-sm leading-relaxed">You can create awesome and powerful bootstrap landing pages with megapack and pixfort builder.</p>
          </div>
        </div>
      </div>

      <div class="flex justify-center">
        <img src="https://png.pngtree.com/png-vector/20241203/ourmid/pngtree-mobile-phone-frame-photo-png-image_14568670.png" class="max-w-full drop-shadow-xl transform hover:scale-[1.02] transition duration-500">
      </div>

    </div>
  </div>
      
  <div class="max-w-3xl mx-auto text-center pt-20 pb-10 px-6">
    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 tracking-tight">Our Portfolio is Here!</h1>
    <p class="text-slate-500 mt-4 leading-relaxed">This is just a simple text made for this unique and awesome template, you can replace it with any text.</p>
  </div>

  <div class="max-w-6xl mx-auto px-6 pb-20 grid grid-cols-2 md:grid-cols-3 gap-6">
    <div v-for="img in images" :key="img" class="overflow-hidden rounded-2xl bg-gray-100 shadow-sm border border-gray-100">
      <img :src="img" class="cursor-pointer w-full h-full object-cover hover:scale-105 transition-transform duration-500" @click="openImage(img)">
    </div>
  </div>

  <div v-if="showImage" class="fixed inset-0 bg-slate-900/90 flex items-center justify-center z-50 backdrop-blur-sm" @click="closeImage">
    <img :src="selectedImage" class="max-w-[85%] max-h-[85%] rounded-2xl shadow-2xl animate-fade-in" @click.stop>
    <button class="absolute top-6 right-8 text-white/70 hover:text-white text-4xl font-light cursor-pointer transition" @click="closeImage">&times;</button>
  </div>

  <div class="bg-gray-50/50 border-t border-gray-100">
    <div class="max-w-6xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-start">
      <div class="space-y-6">
        <div class="p-4 bg-rose-50 rounded-2xl w-fit">
          <img src="/img/chat.png" class="w-10 h-10 object-contain">
        </div>
        <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight">
          Have questions?
        </h3>
        <p class="text-slate-500 leading-relaxed">
          From logo design to video animation, web development to website copy, expert designers, developers and digital talent are ready to complete your projects.
        </p>
        <NuxtLink to="/contact"><button class="bg-rose-800 text-white px-8 py-3.5 rounded-xl hover:bg-rose-900 font-bold transition-all duration-300 hover:shadow-lg hover:shadow-rose-700/20 cursor-pointer text-sm">
          SEND US A MESSAGE
        </button></NuxtLink>
      </div>

      <div class="bg-white p-4 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100 custom-collapse-wrapper">
        <el-collapse v-model="activeName" accordion>
          <el-collapse-item title="Learn how to use the builder" name="1">
            <div class="text-slate-500 text-sm leading-relaxed pb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
          </el-collapse-item>

          <el-collapse-item title="Create awesome accordions" name="2">
            <div class="text-slate-500 text-sm leading-relaxed pb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
          </el-collapse-item>

          <el-collapse-item title="Based on Bootstrap framework" name="3">
            <div class="text-slate-500 text-sm leading-relaxed pb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
          </el-collapse-item>
        </el-collapse>
      </div>
    </div>
  </div>

  <div class="max-w-6xl mx-auto px-6 py-10">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Artikel Terbaru</h2>

    <div v-if="pending" class="text-slate-400">
      Sedang memuat artikel...
    </div>

    <div v-else-if="error" class="text-rose-500">
      Gagal mengambil data dari server: {{ error.message }}
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <div 
    v-for="artikel in daftarArtikel" 
    :key="artikel.slug" 
    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col justify-between"
  >
    <div>
      <div class="w-full h-48 mb-4 overflow-hidden rounded-xl bg-slate-50">
        <template v-if="artikel.thumbnail">
          <div class="w-full h-48 mb-4 overflow-hidden rounded-xl bg-slate-50 flex items-center justify-center">
            <img
              v-if="artikel.thumbnail || getFirstImage(artikel.description)"
              :src="artikel.thumbnail || getFirstImage(artikel.description)"
              :alt="artikel.title"
              class="w-full h-full object-cover"
            />
            <div v-else class="text-slate-400 text-sm">
              No Thumbnail
            </div>
          </div> 
        </template>
        
        <div v-else class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
          No Thumbnail
        </div>
      </div>

      <h3 class="text-xl font-bold text-slate-800 mb-2">{{ artikel.title }}</h3>
      
      <p class="text-slate-500 text-sm mb-4 line-clamp-3" v-html="artikel.description">
      </p>
    </div>
    
    <NuxtLink :to="`/article/${artikel.slug}`" class="text-rose-800 font-semibold inline-flex items-center hover:underline mt-4 text-sm tracking-wide">
      Baca Selengkapnya <span class="ml-1">&rarr;</span>
    </NuxtLink>
  </div>
</div>
  </div>

  <div class="py-24 bg-white border-t border-gray-100">
    <div class="max-w-4xl mx-auto p-8 md:p-14 text-center bg-gradient-to-b from-gray-50 to-white rounded-[40px] border border-gray-100 shadow-[0_10px_40px_rgb(0,0,0,0.02)]">
        
        <div class="inline-flex p-4 bg-rose-50 rounded-2xl mb-6 shadow-sm">
            <img src="/img/open-email.png" class="w-10 h-10 object-contain">
        </div>

        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-3 tracking-tight">
            Subscribe to newsletter
        </h2>

        <p class="text-slate-500 max-w-md mx-auto mb-10 text-sm md:text-base leading-relaxed">
            The best text style you can find on themeforest. Stay updated with premium digital resources.
        </p>

        <transition name="el-zoom-in-top">
          <div v-if="isSubmitted" class="max-w-md mx-auto bg-emerald-50 text-emerald-700 py-3.5 px-6 rounded-2xl mb-6 font-medium text-sm border border-emerald-100 flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
            Thank you for submitting the form!
          </div>
        </transition>

        <el-form
          ref="formRef" 
            :model="form" 
            :rules="rules" 
            label-width="auto" 
            class="bg-white" 
            label-position="top">
          <div class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto items-stretch sm:items-center">
            <el-form-item prop="name" class="!mb-0 flex-1">
              <el-input v-model="form.name" placeholder="Full Name" />
            </el-form-item>
            
            <el-form-item prop="email" class="!mb-0 flex-1">
              <el-input v-model="form.email" placeholder="Your email (your@email.com)" />
            </el-form-item>

            <el-button
              @click="onSubmit(formRef)"
              type="primary"
              :loading="isSubmitting"
              class="!bg-rose-800 hover:!bg-rose-900 !border-none text-white font-semibold !px-5 !py-3 !rounded-xl hover:shadow-lg hover:shadow-rose-700/20 transition-all active:scale-[0.98] cursor-pointer text-sm whitespace-nowrap !h-auto"
            >
              Subscribe
            </el-button>
          </div>
        </el-form>

        <p class="text-gray-400 text-xs mt-6 flex items-center justify-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            *Don't worry! We hate SPAM as much as you do!
        </p>

    </div>
  </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import type { FormInstance, FormRules } from 'element-plus'
import { useApi } from '../composables/useApi' 

definePageMeta({
  layout: 'public',
})

const slides = [
  {
    image: 'https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    title: 'The Perfect Design',
    description: 'From logo design to website designs, we are ready.',
    buttonText: 'Purchase MegaPack',
    link: '/contact'
  },
  {
    image: 'https://images.unsplash.com/photo-1587440871875-191322ee64b0?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    title: 'Grow Your Business',
    description: 'We help startups and brands scale with modern tech solution.',
    buttonText: 'Our Services',
    link: '/services'
  },
  {
    image: 'https://images.unsplash.com/photo-1602576666092-bf6447a729fc?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    title: 'Creative Marketing',
    description: 'Reach more customers with data-driven marketing strategies.',
    buttonText: 'Learn More',
    link: '/about'
  }
]

interface Artikel {
  id: number
  title: string
  slug: string
  description: string | null
  thumbnail: {
    path?: string
    url?: string
  } | null
}

const form = reactive({
  name: '',
  email: '',
})

const showImage = ref<boolean>(false)
const selectedImage = ref<string>('')
const activeName = ref('1')

const images = [
  'https://images.unsplash.com/photo-1508317469940-e3de49ba902e?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  'https://plus.unsplash.com/premium_photo-1714618828448-abf8732500c6?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDMyfHx8ZW58MHx8fHx8',
  'https://images.unsplash.com/photo-1707836868495-3307d371aba4?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  'https://images.unsplash.com/photo-1690192699379-fb68bb749eaa?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  'https://images.unsplash.com/photo-1594892185343-0241e1d47d15?q=80&w=765&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
  'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
]

function openImage(img: string): void {
  selectedImage.value = img
  showImage.value = true
}

function closeImage() {
  showImage.value = false
}

const formRef = ref<FormInstance>()
const isSubmitting = ref(false)
const isSubmitted = ref(false)

const rules = reactive<FormRules>({
  name: [{ required: true, message: 'Nama lengkap wajib diisi', trigger: 'blur' }],
  email: [
    { required: true, message: 'Email bisnis wajib diisi', trigger: 'blur' },
    { type: 'email', message: 'Format email tidak valid', trigger: ['blur', 'change'] }
  ],
})

const { apiFetch, getErrorMessage } = useApi()
const onSubmit = async (formEl: FormInstance | undefined) => {
  if (!formEl) return

  await formEl.validate(async (valid, fields) => {
    if (valid) {
      isSubmitting.value = true 
      try {
        await apiFetch('/index', {
          method: 'POST',
          body: {
            name: form.name,
            email: form.email,
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

const { data: daftarArtikel, pending, error } = await useFetch<any>('http://localhost:8000/api/v1/home-articles', {
  transform: (response) => {
    const articlesArray = Array.isArray(response) ? response : (response.data || response.articles || []);
    
    return articlesArray.map((item: any) => ({
      id: item.id,
      title: item.title,
      slug: item.slug,
      description: item.description ?? null,
      thumbnail: item.thumbnail?.path || item.thumbnail?.url || item.thumbnail || null
    }));
  }
});

// Fungsi untuk mengekstrak URL gambar pertama dari teks HTML deskripsi5
function getFirstImage(htmlString: string | null): string | undefined {
  if (!htmlString) return undefined;
  
  // Mencari tag <img src="...">
  const regex = /<img[^>]+src=["']([^"']+)["']/i;
  const match = htmlString.match(regex);
  
  if (match && match[1]) {
    const imageUrl = match[1];
    
    // Jika gambarnya adalah blob lama yang rusak, kita abaikan saja agar berubah jadi 'No Thumbnail'
    if (imageUrl.startsWith('blob:')) {
      return undefined; 
    }
    
    return imageUrl;
  }
  return undefined;
}
</script>

<style scoped>
:deep(.el-carousel__button) {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.4);
  transition: all 0.3s ease;
}

:deep(.el-carousel__indicator--active .el-carousel__button) {
  width: 24px;
  border-radius: 8px;
  background-color: #be123c;
}

:deep(.el-collapse) {
  border-top: none;
  border-bottom: none;
}

:deep(.el-collapse-item__header) {
  font-size: 1rem;
  font-weight: 600;
  color: #1e293b;
  padding: 1rem 0.5rem;
  transition: color 0.2s ease;
}

:deep(.el-collapse-item__header:hover) {
  color: #be123c;
}

:deep(.el-collapse-item__wrap) {
  border-bottom: 1px solid #f1f5f9;
}

:deep(.el-collapse-item__content) {
  padding-left: 0.5rem;
  padding-right: 0.5rem;
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-out forwards;
}

@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
</style>