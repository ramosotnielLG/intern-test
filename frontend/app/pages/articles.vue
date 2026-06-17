<template>
<div class="relative h-[400px] w-full overflow-hidden shadow-sm flex items-center justify-center">
  <img 
    src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=1170&auto=format&fit=crop" 
    class="absolute inset-0 w-full h-full object-cover" 
    alt="Artikel Terbaru Background"
  />
  <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/50 to-transparent flex flex-col justify-center items-center text-white text-center px-6">
    <div class="w-full max-w-2xl mx-auto">
      <p class="text-xs font-bold uppercase tracking-[0.35em] text-rose-400 mb-3">Blog & Insights</p>
      <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight drop-shadow-sm uppercase">
        Artikel Terbaru
      </h1>
      <p class="mt-4 text-base md:text-lg text-gray-300 leading-relaxed font-light">
        Temukan wawasan, tips, dan berita terkini dari tim kami.
      </p>
      <div class="mt-8 max-w-md mx-auto">
        <el-input
          v-model="searchQuery"
          placeholder="Cari artikel..."
          clearable
          size="large"
          class="rounded-xl shadow-md text-slate-800"
        >
          <template #prefix>
            <Icon icon="solar:magnifer-linear" class="text-slate-400" />
          </template>
        </el-input>
      </div>
    </div>
  </div>
</div>

  <div class="max-w-6xl mx-auto px-6 py-16">

    <div v-if="loading" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
      <div v-for="i in 6" :key="i" class="rounded-2xl border border-gray-100 overflow-hidden">
        <div class="h-48 bg-slate-100 animate-pulse" />
        <div class="p-5 space-y-3">
          <div class="h-4 bg-slate-100 animate-pulse rounded w-3/4" />
          <div class="h-3 bg-slate-100 animate-pulse rounded w-full" />
          <div class="h-3 bg-slate-100 animate-pulse rounded w-2/3" />
        </div>
      </div>
    </div>

    <div v-else-if="articles.length === 0" class="text-center py-24">
      <div class="inline-flex p-5 bg-rose-50 rounded-2xl mb-4">
        <Icon icon="solar:document-text-outline" class="text-4xl text-rose-300" />
      </div>
      <p class="text-slate-500 font-medium">Tidak ada artikel ditemukan.</p>
      <button
        v-if="searchQuery"
        class="mt-4 text-sm text-rose-700 hover:underline"
        @click="searchQuery = ''"
      >
        Hapus pencarian
      </button>
    </div>

    <div v-else class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
      <NuxtLink
        v-for="article in articles"
        :key="article.id"
        :to="`/article/${article.slug}`"
        class="group block rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 bg-white no-underline"
      >
        <div class="relative h-48 bg-slate-100 overflow-hidden">
          <img
            v-if="article.thumbnail"
            :src="article.thumbnail"
            :alt="article.title"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
          <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
            <Icon icon="solar:document-text-outline" class="text-4xl text-slate-300" />
          </div>
        </div>

        <div class="p-5">
          <div class="flex items-center gap-2 mb-3 text-xs text-slate-400">
            <Icon icon="solar:user-outline" class="text-sm" />
            <span>{{ article.author || 'Tim Redaksi' }}</span>
            <span class="mx-1">·</span>
            <Icon icon="solar:eye-outline" class="text-sm" />
            <span>{{ article.views ?? 0 }} views</span>
          </div>
          <h2 class="font-bold text-slate-800 text-base leading-snug line-clamp-2 group-hover:text-rose-800 transition-colors">
            {{ article.title }}
          </h2>
          <p v-if="article.description" class="mt-2 text-sm text-slate-500 leading-relaxed line-clamp-2">
            {{ article.description }}
          </p>
          <div class="mt-4 flex items-center text-xs font-semibold text-rose-700 gap-1">
            Baca selengkapnya
            <Icon icon="solar:arrow-right-outline" class="text-sm group-hover:translate-x-1 transition-transform" />
          </div>
        </div>
      </NuxtLink>
    </div>

    <div v-if="!loading && totalArticles > pageSize" class="mt-12 flex justify-center">
      <el-pagination
        v-model:current-page="currentPage"
        :page-size="pageSize"
        :total="totalArticles"
        layout="prev, pager, next"
        background
        @change="scrollToTop"
      />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Icon } from '@iconify/vue'
import { onMounted, ref, watch } from 'vue'

definePageMeta({
  layout: 'public',
})

type PublicArticle = {
  id: string
  title: string
  slug: string
  description: string | null
  author: string | null
  thumbnail: string | null
  views: number
}

const articles = ref<PublicArticle[]>([])
const loading = ref(true)
const searchQuery = ref('')
const currentPage = ref(1)
const totalArticles = ref(0)
const pageSize = 9

let searchTimeout: ReturnType<typeof setTimeout> | null = null

const stripHtml = (html: string | null): string => {
  if (!html) return ''
  return html.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').trim()
}

const mapThumbnail = (thumbnail: any): string | null => {
  if (!thumbnail) return null
  return thumbnail.path ?? thumbnail.url ?? null
}

const fetchArticles = async () => {
  loading.value = true
  try {
    const config = useRuntimeConfig()
    const apiBase = config.public.apiBase.replace(/\/$/, '')
    const response = await $fetch<any>(`${apiBase}/api/public/articles`, {
      query: {
        page: currentPage.value,
        limit: pageSize,
        ...(searchQuery.value ? { search: searchQuery.value } : {}),
      },
    })
    const data = Array.isArray(response) ? response : response.data ?? []
    articles.value = data.map((a: any) => ({
      id: a.id,
      title: a.title,
      slug: a.slug,
      description: stripHtml(a.description ?? null),
      author: a.author?.name ?? a.author ?? null,
      thumbnail: mapThumbnail(a.thumbnail),
      views: a.views ?? 0,
    }))
    totalArticles.value = response.total ?? data.length
  } catch (error) {
    console.error('Gagal memuat artikel:', error)
  } finally {
    loading.value = false
  }
}

watch(currentPage, fetchArticles)

watch(searchQuery, () => {
  currentPage.value = 1
  if (searchTimeout) clearTimeout(searchTimeout)
  searchTimeout = setTimeout(fetchArticles, 400)
})

const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(fetchArticles)
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>