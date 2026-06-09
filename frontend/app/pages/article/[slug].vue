<template>
  <div>
    <!-- Loading -->
    <div v-if="status === 'pending'" class="max-w-3xl mx-auto px-6 py-20 space-y-6">
      <div class="h-8 bg-slate-100 animate-pulse rounded w-2/3" />
      <div class="h-4 bg-slate-100 animate-pulse rounded w-1/3" />
      <div class="h-64 bg-slate-100 animate-pulse rounded-2xl" />
      <div class="space-y-3">
        <div class="h-4 bg-slate-100 animate-pulse rounded w-full" />
        <div class="h-4 bg-slate-100 animate-pulse rounded w-full" />
        <div class="h-4 bg-slate-100 animate-pulse rounded w-3/4" />
      </div>
    </div>

    <!-- Not Found -->
    <div v-else-if="!article" class="text-center py-32 px-6">
      <div class="inline-flex p-5 bg-rose-50 rounded-2xl mb-4">
        <Icon icon="solar:document-text-outline" class="text-4xl text-rose-300" />
      </div>
      <h2 class="text-xl font-bold text-slate-800 mb-2">Artikel tidak ditemukan</h2>
      <p class="text-slate-500 text-sm mb-6">Artikel yang Anda cari tidak tersedia atau telah dihapus.</p>
      <NuxtLink
        to="/articles"
        class="inline-flex items-center gap-2 bg-rose-800 hover:bg-rose-900 text-white text-sm font-semibold px-6 py-3 rounded-xl transition-colors no-underline"
      >
        <Icon icon="solar:arrow-left-outline" />
        Kembali ke Artikel
      </NuxtLink>
    </div>

    <!-- Article Content -->
    <div v-else>
      <!-- Hero Thumbnail -->
      <div v-if="article.thumbnail" class="w-full h-[420px] bg-slate-100 overflow-hidden flex items-center justify-center">
        <img
          :src="article.thumbnail"
          :alt="article.title"
          class="w-full h-full object-contain"
        />
      </div>
      <div v-else class="w-full h-48 bg-gradient-to-br from-slate-800 to-slate-900" />

      <!-- Article Body -->
      <div class="max-w-3xl mx-auto px-6 py-12">

        <!-- Back Link -->
        <NuxtLink
          to="/articles"
          class="inline-flex items-center gap-1.5 text-md text-slate-500 hover:text-rose-800 transition-colors hover:underline underline-offset-4 mb-8"
        >
          <Icon icon="solar:arrow-left-outline" />
          Kembali ke semua artikel
        </NuxtLink>

        <!-- Title -->
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight leading-tight">
          {{ article.title }}
        </h1>

        <!-- Meta -->
        <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-slate-400">
          <span class="flex items-center gap-1.5">
            <Icon icon="solar:user-outline" />
            {{ article.author || 'Tim Redaksi' }}
          </span>
          <span class="flex items-center gap-1.5">
            <Icon icon="solar:eye-outline" />
            {{ article.views }} views
          </span>
        </div>

        <div class="w-16 h-1 bg-rose-800 rounded-full mt-6 mb-8" />

        <!-- Content -->
        <div
          class="prose prose-slate max-w-none"
          v-html="article.description"
        />

      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Icon } from '@iconify/vue'

definePageMeta({
  layout: 'public',
})

type ArticleDetail = {
  id: string
  title: string
  slug: string
  description: string | null
  author: string | null
  thumbnail: string | null
  views: number
}

const route = useRoute()
const config = useRuntimeConfig()
const apiBase = config.public.apiBase.replace(/\/$/, '')
const slug = route.params.slug as string

const { data: article, status } = await useAsyncData<ArticleDetail>(
  `article-${slug}`,
  async () => {
    const data = await $fetch<any>(`${apiBase}/api/public/articles/${slug}`)
    return {
      id: data.id,
      title: data.title,
      slug: data.slug,
      description: data.description ?? null,
      author: data.author?.name ?? null,
      thumbnail: data.thumbnail?.path ?? data.thumbnail?.url ?? null,
      views: data.views ?? 0,
    }
  },
)
</script>

<style scoped>
.prose :deep(h1),
.prose :deep(h2),
.prose :deep(h3) {
  font-weight: 700;
  color: #1e293b;
  margin-top: 1.5em;
  margin-bottom: 0.5em;
}

.prose :deep(h1) { font-size: 1.75rem; }
.prose :deep(h2) { font-size: 1.4rem; }
.prose :deep(h3) { font-size: 1.2rem; }

.prose :deep(p) {
  color: #475569;
  line-height: 1.8;
  margin-bottom: 1.2em;
}

.prose :deep(strong) {
  color: #1e293b;
  font-weight: 600;
}

.prose :deep(em) {
  color: #64748b;
}

.prose :deep(a) {
  color: #9f1239;
  text-decoration: underline;
}

.prose :deep(ul),
.prose :deep(ol) {
  padding-left: 1.5rem;
  margin-bottom: 1.2em;
  color: #475569;
}

.prose :deep(li) {
  margin-bottom: 0.4em;
  line-height: 1.7;
}

.prose :deep(blockquote) {
  border-left: 4px solid #fda4af;
  padding-left: 1rem;
  color: #64748b;
  font-style: italic;
  margin: 1.5em 0;
}

.prose :deep(img) {
  border-radius: 1rem;
  max-width: 100%;
  margin: 1.5em auto;
}

.prose :deep(code) {
  background: #f1f5f9;
  padding: 0.2em 0.4em;
  border-radius: 0.3em;
  font-size: 0.875em;
  color: #be123c;
}

.prose :deep(pre) {
  background: #1e293b;
  color: #e2e8f0;
  padding: 1.25rem;
  border-radius: 0.75rem;
  overflow-x: auto;
  margin: 1.5em 0;
}
</style>