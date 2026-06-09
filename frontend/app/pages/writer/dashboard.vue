<template>
  <AdminShell>
    <!-- Header Section dengan Tombol Tambah Artikel -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
      <div>
        <h1 class="text-2xl font-bold text-[var(--slate-800)]">Writer Dashboard</h1>
        <p class="text-sm text-[var(--slate-500)]">Kelola artikel Anda dan lihat kontribusi writer lainnya.</p>
      </div>
      <!-- Tombol Buat Artikel Baru -->
      <NuxtLink 
        to="/admin/articles/create" 
        class="flex items-center gap-2 rounded-xl bg-[var(--blue-600)] px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[var(--blue-700)] transition-colors"
      >
        <Icon icon="solar:pen-new-square-bold" class="text-lg" />
        Buat Artikel Baru
      </NuxtLink>
    </div>

    <!-- Statistics Cards Khusus Writer -->
    <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
      <div v-for="stat in writerStats" :key="stat.key" class="stat-card group">
        <div class="stat-icon" :style="{ background: stat.gradient }">
          <Icon :icon="stat.icon" class="text-2xl text-white" />
        </div>
        <div>
          <p class="text-xs font-medium uppercase tracking-widest text-[var(--slate-400)]">
            {{ stat.label }}
          </p>
          <p class="mt-1 text-2xl font-bold text-[var(--slate-800)]">
            <span v-if="loading" class="inline-block h-7 w-16 animate-pulse rounded bg-slate-200" />
            <span v-else>{{ stat.value }}</span>
          </p>
        </div>
      </div>
    </section>

    <!-- Daftar Artikel Lain & Milik Sendiri -->
    <section class="glass-panel mt-6 p-6">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="section-title">Artikel Terbaru</h2>
          <p class="text-sm text-[var(--slate-500)]">Daftar artikel yang diterbitkan oleh tim penulis.</p>
        </div>
        <NuxtLink to="/admin/articles" class="text-xs font-semibold text-[var(--blue-600)] hover:underline">
          Lihat Semua Artikel →
        </NuxtLink>
      </div>

      <!-- Loading State untuk Tabel -->
      <div v-if="loading" class="space-y-3">
        <div v-for="i in 3" :key="i" class="h-16 w-full animate-pulse rounded-xl bg-slate-100" />
      </div>

      <!-- Tabel Artikel -->
      <div v-else class="overflow-x-auto">
        <table class="w-full text-left text-sm text-[var(--slate-600)]">
          <thead class="bg-slate-50 text-xs uppercase text-[var(--slate-400)] font-semibold">
            <tr>
              <th class="px-4 py-3">Judul Artikel</th>
              <th class="px-4 py-3">Penulis</th>
              <th class="px-4 py-3">Status</th>
              <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-for="article in articles" :key="article.id" class="hover:bg-slate-50/50 transition-colors">
              <td class="px-4 py-4 font-medium text-[var(--slate-800)] max-w-xs truncate">
                {{ article.title }}
              </td>
              <td class="px-4 py-4 flex items-center gap-2">
                <span class="h-6 w-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold">
                  {{ article.author.name.charAt(0) }}
                </span>
                {{ article.author.name }}
              </td>
              <td class="px-4 py-4">
                <span 
                  class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium"
                  :class="article.status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'"
                >
                  {{ article.status === 'published' ? 'Published' : 'Draft' }}
                </span>
              </td>
              <td class="px-4 py-4 text-right">
                <!-- Jika artikel ini milik writer yang sedang login, dia bisa edit -->
                <NuxtLink 
                  v-if="article.is_mine"
                  :to="`/admin/articles/${article.id}`" 
                  class="inline-flex items-center gap-1 text-xs font-semibold text-[var(--blue-600)] hover:text-[var(--blue-800)]"
                >
                  <Icon icon="solar:pen-bold" /> Edit
                </NuxtLink>
                <!-- Jika milik orang lain, hanya bisa lihat/preview -->
                <span v-else class="text-xs text-[var(--slate-400)] italic">
                  Hanya Baca
                </span>
              </td>
            </tr>
            <tr v-if="articles.length === 0">
              <td colspan="4" class="text-center py-8 text-[var(--slate-400)]">Belum ada artikel.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </AdminShell>
</template>

<script lang="ts" setup>
import { Icon } from '@iconify/vue'
import { computed, onMounted, ref } from 'vue'
import { useApi } from '~/composables/useApi'
import AdminShell from '~/components/Admin/Shell.vue'

// Interface data artikel
type Article = {
  id: number | string
  title: string
  status: 'draft' | 'published'
  is_mine: boolean // Menandakan apakah ini artikel buatan dia sendiri
  author: {
    name: string
  }
}

type WriterDashboardResponse = {
  stats: {
    my_total_articles: number
    published_articles: number
    draft_articles: number
  }
  recent_articles: Article[]
}

const { apiFetch, getErrorMessage } = useApi()

const loading = ref(true)
const articles = ref<Article[]>([])
const stats = ref<WriterDashboardResponse['stats']>({
  my_total_articles: 0,
  published_articles: 0,
  draft_articles: 0,
})

// Mengubah Card Stats agar relevan dengan tugas Writer
const writerStats = computed(() => [
  {
    key: 'my_articles',
    label: 'Artikel Saya',
    value: stats.value.my_total_articles,
    icon: 'solar:document-text-bold',
    gradient: 'linear-gradient(135deg, #6366f1, #818cf8)',
  },
  {
    key: 'published',
    label: 'Sudah Rilis (Published)',
    value: stats.value.published_articles,
    icon: 'solar:check-circle-bold',
    gradient: 'linear-gradient(135deg, #10b981, #34d399)',
  },
  {
    key: 'drafts',
    label: 'Draf Artikel',
    value: stats.value.draft_articles,
    icon: 'solar:notes-bold',
    gradient: 'linear-gradient(135deg, #f59e0b, #fbbf24)',
  },
])

onMounted(async () => {
  try {
    // Sesuaikan endpoint API backend khusus untuk data dashboard writer
    const data = await apiFetch<WriterDashboardResponse>('/writer/dashboard')
    stats.value = data.stats
    articles.value = data.recent_articles
  } catch (error) {
    console.error('Gagal memuat dashboard writer:', getErrorMessage(error, 'Unknown error'))
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
/* Mewarisi style stat-card Anda yang sudah sangat rapi */
.stat-card {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1.25rem 1.5rem;
  border-radius: 1.25rem;
  background: rgba(255, 255, 255, 0.85);
  border: 1px solid rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(12px);
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.stat-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 3rem;
  height: 3rem;
  border-radius: 0.875rem;
  flex-shrink: 0;
}
</style>