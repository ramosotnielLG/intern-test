<template>
  <div class="bg-[var(--paper)] text-[var(--ink)]">

    <div class="bg-[var(--ink)] text-[var(--paper)]">
      <div class="max-w-6xl mx-auto px-6 py-16 md:py-20">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-8">
          <div>
            <p class="font-mono text-[11px] tracking-[0.2em] text-[var(--brass)] uppercase mb-4">
              Publikasi Internal &mdash; Divisi Riset &amp; Konsultasi
            </p>
            <h1 class="font-serif text-4xl md:text-5xl leading-[1.05] max-w-xl">
              Artikel &amp; Wawasan
            </h1>
            <p class="mt-4 text-sm md:text-base text-[var(--paper)]/70 max-w-md leading-relaxed">
              Catatan analisis, studi kasus, dan perspektif tim konsultan kami untuk klien dan mitra.
            </p>
          </div>

          <div class="w-full md:w-72">
            <label class="block font-mono text-[10px] tracking-[0.15em] uppercase text-[var(--paper)]/50 mb-2">
              Cari dalam arsip
            </label>
            <el-input
              v-model="searchQuery"
              placeholder="Ketik kata kunci..."
              clearable
              class="masthead-search"
            >
              <template #prefix>
                <Icon icon="solar:magnifer-linear" class="text-[var(--paper)]/50" />
              </template>
            </el-input>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-14">

      <div v-if="loading" class="space-y-10">
        <div class="animate-pulse grid md:grid-cols-5 gap-8 pb-10 border-b border-[var(--hairline)]">
          <div class="md:col-span-2 h-56 bg-[var(--hairline)]/40 rounded-sm" />
          <div class="md:col-span-3 space-y-3 pt-2">
            <div class="h-3 w-24 bg-[var(--hairline)]/40 rounded-sm" />
            <div class="h-7 w-5/6 bg-[var(--hairline)]/40 rounded-sm" />
            <div class="h-4 w-full bg-[var(--hairline)]/40 rounded-sm" />
          </div>
        </div>
        <div v-for="i in 4" :key="i" class="flex gap-6 py-6 border-b border-[var(--hairline)] animate-pulse">
          <div class="w-16 shrink-0 h-4 bg-[var(--hairline)]/40 rounded-sm mt-1" />
          <div class="flex-1 space-y-2">
            <div class="h-5 w-3/4 bg-[var(--hairline)]/40 rounded-sm" />
            <div class="h-3 w-1/2 bg-[var(--hairline)]/40 rounded-sm" />
          </div>
        </div>
      </div>

      <div v-else-if="loadError" class="text-center py-24 border border-[var(--hairline)]">
        <p class="font-mono text-[11px] tracking-[0.15em] uppercase text-[var(--brass)] mb-3">Kesalahan Sistem</p>
        <p class="font-serif text-xl text-[var(--ink)]">Arsip tidak dapat dimuat</p>
        <p class="text-sm text-[var(--slate)] mt-2 max-w-sm mx-auto">{{ loadError }}</p>
        <button
          class="mt-6 inline-flex items-center gap-2 font-mono text-xs tracking-wide uppercase text-[var(--ink)] border border-[var(--ink)] px-4 py-2 hover:bg-[var(--ink)] hover:text-[var(--paper)] transition-colors"
          @click="fetchArticles"
        >
          <Icon icon="solar:refresh-outline" />
          Muat ulang
        </button>
      </div>

      <div v-else-if="articles.length === 0" class="text-center py-24 border border-[var(--hairline)]">
        <p class="font-mono text-[11px] tracking-[0.15em] uppercase text-[var(--slate)] mb-3">Arsip Kosong</p>
        <p class="font-serif text-xl">Tidak ada entri yang cocok</p>
        <button
          v-if="searchQuery"
          class="mt-4 font-mono text-xs uppercase tracking-wide text-[var(--brass)] hover:underline"
          @click="searchQuery = ''"
        >
          Hapus pencarian
        </button>
      </div>

      <div v-else>
        <NuxtLink
          :to="`/article/${featured.slug}`"
          class="group grid md:grid-cols-5 gap-8 pb-10 border-b border-[var(--hairline)] no-underline focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-[var(--brass)] focus-visible:ring-offset-4"
        >
          <div class="md:col-span-2 h-56 md:h-full bg-[var(--hairline)]/30 overflow-hidden">
            <img
              v-if="featured.thumbnail"
              :src="featured.thumbnail"
              :alt="featured.title"
              fetchpriority="high"
              class="w-full h-full object-cover grayscale-[15%] group-hover:grayscale-0 transition-all duration-500"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
              <Icon icon="solar:document-text-outline" class="text-4xl text-[var(--slate)]/40" />
            </div>
          </div>
          <div class="md:col-span-3 flex flex-col justify-center">
            <p class="font-mono text-[11px] tracking-[0.15em] uppercase text-[var(--brass)] mb-3">
              Memo No. {{ memoNumber(0) }} &middot; {{ featured.author || 'Tim Redaksi' }}
            </p>
            <h2 class="font-serif text-2xl md:text-[28px] leading-tight group-hover:text-[var(--brass)] transition-colors">
              {{ featured.title }}
            </h2>
            <p v-if="featured.description" class="mt-3 text-sm text-[var(--slate)] leading-relaxed line-clamp-3">
              {{ featured.description }}
            </p>
            <div class="mt-5 inline-flex items-center gap-2 font-mono text-xs uppercase tracking-wide text-[var(--ink)]">
              Baca briefing lengkap
              <Icon icon="solar:arrow-right-outline" class="group-hover:translate-x-1 transition-transform" />
            </div>
          </div>
        </NuxtLink>

        <NuxtLink
          v-for="(article, idx) in rest"
          :key="article.id"
          :to="`/article/${article.slug}`"
          class="group flex items-center gap-5 sm:gap-6 py-5 border-b border-[var(--hairline)] no-underline focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-[var(--brass)] focus-visible:ring-offset-4"
        >
          <span class="hidden sm:block shrink-0 w-14 font-mono text-xs text-[var(--slate)]">
            No. {{ memoNumber(idx + 1) }}
          </span>

          <div class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 bg-[var(--hairline)]/30 overflow-hidden">
            <img
              v-if="article.thumbnail"
              :src="article.thumbnail"
              :alt="article.title"
              loading="lazy"
              class="w-full h-full object-cover grayscale-[15%] group-hover:grayscale-0 transition-all duration-500"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
              <Icon icon="solar:document-text-outline" class="text-lg text-[var(--slate)]/40" />
            </div>
          </div>

          <div class="flex-1 min-w-0">
            <p class="sm:hidden font-mono text-[10px] text-[var(--slate)] mb-1">No. {{ memoNumber(idx + 1) }}</p>
            <h3 class="font-serif text-lg leading-snug line-clamp-1 group-hover:text-[var(--brass)] transition-colors">
              {{ article.title }}
            </h3>
            <p v-if="article.description" class="mt-1 text-sm text-[var(--slate)] line-clamp-1">
              {{ article.description }}
            </p>
          </div>

          <div class="hidden md:flex shrink-0 items-center gap-3 font-mono text-[11px] text-[var(--slate)] uppercase tracking-wide">
            <span>{{ article.author || 'Tim Redaksi' }}</span>
            <template v-if="article.views > 0">
              <span>&middot;</span>
              <span>{{ article.views }} dibaca</span>
            </template>
          </div>

          <Icon icon="solar:arrow-right-outline" class="shrink-0 text-[var(--ink)] group-hover:translate-x-1 transition-transform" />
        </NuxtLink>
      </div>

      <!-- Pagination -->
      <div
        v-if="!loadError && totalArticles > pageSize"
        class="mt-12 flex justify-center transition-opacity duration-200"
        :class="{ 'opacity-40 pointer-events-none': loading }"
      >
        <el-pagination
          v-model:current-page="currentPage"
          :page-size="pageSize"
          :total="totalArticles"
          layout="prev, pager, next"
          class="memo-pagination"
          @change="scrollToTop"
        />
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Icon } from '@iconify/vue'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'

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
const loadError = ref('')
const currentPage = ref(1)
const totalArticles = ref(0)
const pageSize = 9

const route = useRoute()
const router = useRouter()

const searchQuery = ref(typeof route.query.q === 'string' ? route.query.q : '')
const initialPage = Number(route.query.page)
if (Number.isInteger(initialPage) && initialPage > 0) {
  currentPage.value = initialPage
}

let searchTimeout: ReturnType<typeof setTimeout> | null = null
let isSyncingFromRoute = false

const stripHtml = (html: string | null): string => {
  if (!html) return ''
  return html.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').trim()
}

const mapThumbnail = (thumbnail: any): string | null => {
  if (!thumbnail) return null
  return thumbnail.path ?? thumbnail.url ?? null
}

const featured = computed(() => articles.value[0] as PublicArticle)
const rest = computed(() => articles.value.slice(1))

const memoNumber = (indexOnPage: number) => {
  const positionFromTop = (currentPage.value - 1) * pageSize + indexOnPage
  return String(Math.max(totalArticles.value - positionFromTop, 1)).padStart(3, '0')
}

const syncQueryToUrl = () => {
  isSyncingFromRoute = true
  router.replace({
    query: {
      ...(searchQuery.value ? { q: searchQuery.value } : {}),
      ...(currentPage.value > 1 ? { page: String(currentPage.value) } : {}),
    },
  }).finally(() => {
    isSyncingFromRoute = false
  })
}

const fetchArticles = async () => {
  loading.value = true
  loadError.value = ''
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
    loadError.value = 'Terjadi masalah saat menghubungi server. Periksa koneksi Anda dan coba lagi.'
    articles.value = []
  } finally {
    loading.value = false
  }
}

watch(currentPage, () => {
  syncQueryToUrl()
  fetchArticles()
})

watch(searchQuery, () => {
  currentPage.value = 1
  syncQueryToUrl()
  if (searchTimeout) clearTimeout(searchTimeout)
  searchTimeout = setTimeout(fetchArticles, 400)
})

watch(
  () => route.query,
  (query) => {
    if (isSyncingFromRoute) return
    const q = typeof query.q === 'string' ? query.q : ''
    const page = Number(query.page) || 1
    if (q !== searchQuery.value) searchQuery.value = q
    if (page !== currentPage.value) currentPage.value = page
  }
)

const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(fetchArticles)

onUnmounted(() => {
  if (searchTimeout) clearTimeout(searchTimeout)
})

useSeoMeta({
  title: 'Artikel & Wawasan — Divisi Riset & Konsultasi',
  description: 'Catatan analisis, studi kasus, dan perspektif tim konsultan kami untuk klien dan mitra.',
  ogTitle: 'Artikel & Wawasan',
  ogDescription: 'Catatan analisis, studi kasus, dan perspektif tim konsultan kami untuk klien dan mitra.',
  ogType: 'website',
  twitterCard: 'summary_large_image',
})

useHead({
  link: [
    { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
    { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' },
    {
      rel: 'stylesheet',
      href: 'https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap',
    },
  ],
  script: [
    {
      type: 'application/ld+json',
      innerHTML: JSON.stringify({
        '@context': 'https://schema.org',
        '@type': 'Blog',
        name: 'Artikel & Wawasan',
        description: 'Catatan analisis, studi kasus, dan perspektif tim konsultan kami untuk klien dan mitra.',
      }),
    },
  ],
})
</script>

<style scoped>
div {
  --ink: #101b2d;
  --paper: #f4f2ed;
  --brass: #9c6b30;
  --slate: #5b6472;
  --hairline: #d8d4c9;
}

h1, h2, h3, p, span, label, button, div {
  font-family: 'Inter', system-ui, sans-serif;
}
.font-serif {
  font-family: 'Source Serif 4', Georgia, serif !important;
}
.font-mono {
  font-family: 'IBM Plex Mono', ui-monospace, monospace !important;
}

.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

:deep(.masthead-search .el-input__wrapper) {
  background: transparent;
  box-shadow: none !important;
  border-bottom: 1px solid rgba(244, 242, 237, 0.3);
  border-radius: 0;
  padding: 8px 2px;
}
:deep(.masthead-search .el-input__inner) {
  color: var(--paper);
}
:deep(.masthead-search .el-input__inner::placeholder) {
  color: rgba(244, 242, 237, 0.4);
}
:deep(.masthead-search.is-focus .el-input__wrapper) {
  border-bottom-color: var(--brass);
}

:deep(.memo-pagination .el-pager li) {
  font-family: 'IBM Plex Mono', monospace;
  background: transparent;
  color: var(--slate);
  border-radius: 0;
}
:deep(.memo-pagination .el-pager li.is-active) {
  color: var(--ink);
  font-weight: 600;
  border-bottom: 1px solid var(--brass);
}
:deep(.memo-pagination .btn-prev),
:deep(.memo-pagination .btn-next) {
  background: transparent;
  color: var(--ink);
}
</style>