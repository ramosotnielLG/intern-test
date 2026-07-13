<template>
  <AdminShell>
    <section class="glass-panel p-4 sm:p-6">
      <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="min-w-0">
          <h2 class="section-title">My Articles</h2>
          <p class="text-sm text-[var(--slate-500)]">Kelola artikel yang Anda buat.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
          <el-input v-model="searchQuery" placeholder="Cari artikel..." clearable class="w-full sm:w-64">
            <template #prefix>
              <Icon icon="solar:magnifer-linear" />
            </template>
          </el-input>
          <el-button type="primary" @click="openCreate">Tulis Artikel</el-button>
        </div>
      </div>

      <!-- Filter Tab: Semua / Milik Saya -->
      <div class="mt-4 flex gap-2">
        <el-radio-group v-model="filterMode" @change="applyFilter">
          <el-radio-button value="all">Semua Artikel</el-radio-button>
          <el-radio-button value="mine">Artikel Saya</el-radio-button>
        </el-radio-group>
      </div>

      <div class="mt-6 overflow-x-auto -mx-4 sm:-mx-6 px-4 sm:px-6">
        <el-table
          :data="paginatedArticles"
          row-key="id"
          stripe
          v-loading="loading"
          class="min-w-[700px] w-full"
          @sort-change="handleSort"
          :default-sort="{ prop: 'title', order: 'ascending' }"
        >
          <el-table-column prop="title" sortable="custom" label="Judul" min-width="200" show-overflow-tooltip />
          <el-table-column prop="author.name" sortable="custom" label="Penulis" min-width="150" show-overflow-tooltip>
            <template #default="{ row }">
              <div class="flex items-center gap-2">
                <span
                  class="h-6 w-6 rounded-full bg-[var(--blue-100)] text-[var(--blue-900)] flex items-center justify-center text-[10px] font-bold flex-shrink-0"
                >
                  {{ (row.author?.name || 'U').charAt(0).toUpperCase() }}
                </span>
                <span :class="row.is_mine ? 'font-semibold text-[var(--blue-700)]' : ''">
                  {{ row.author?.name || 'Unknown' }}
                  <span v-if="row.is_mine" class="ml-1 text-[10px] bg-[var(--blue-100)] text-[var(--blue-700)] px-1.5 py-0.5 rounded-full font-medium">Saya</span>
                </span>
              </div>
            </template>
          </el-table-column>
          <el-table-column label="Status" width="120">
            <template #default="{ row }">
              <span
                class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium"
                :class="row.status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'"
              >
                {{ row.status === 'published' ? 'Published' : 'Draft' }}
              </span>
            </template>
          </el-table-column>
          <el-table-column label="Thumbnail" min-width="140">
            <template #default="{ row }">
              <el-image
                v-if="row.thumbnail?.url"
                :src="row.thumbnail.url"
                fit="cover"
                class="h-10 w-16 rounded-lg border border-slate-100 bg-white"
              />
              <span v-else class="text-sm text-[var(--slate-400)]">Tidak ada</span>
            </template>
          </el-table-column>
          <el-table-column label="Aksi" width="120" align="center">
            <template #default="{ row }">
              <template v-if="row.is_mine">
                <el-button text type="primary" aria-label="Edit" @click="openEdit(row)">
                  <Icon icon="solar:pen-2-outline" class="text-lg" />
                </el-button>
                <el-button text type="danger" aria-label="Delete" @click="confirmDelete(row)">
                  <Icon icon="solar:trash-bin-trash-outline" class="text-lg" />
                </el-button>
              </template>
              <span v-else class="text-xs text-[var(--slate-400)] italic">Hanya Baca</span>
            </template>
          </el-table-column>
        </el-table>
      </div>

      <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-sm text-[var(--slate-500)]">
        <span>Menampilkan {{ showingFrom }}–{{ showingTo }} dari {{ filteredArticles.length }}</span>
        <el-pagination
          v-model:current-page="currentPage"
          v-model:page-size="pageSize"
          :page-sizes="[10, 25, 50, 100]"
          :total="filteredArticles.length"
          layout="sizes, prev, pager, next"
          size="small"
          background
        />
      </div>
    </section>
  </AdminShell>
</template>

<script lang="ts" setup>
import { Icon } from '@iconify/vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import type { UploadUserFile } from 'element-plus'
import { computed, onMounted, ref, watch } from 'vue'
import { useRouter } from 'vue-router'
import AdminShell from '~/components/Admin/Shell.vue'
import type { Article, ArticleApi, AttachmentApi } from '~/types/admin'
import { useApi } from '~/composables/useApi'

definePageMeta({
  layout: false,
})

const router = useRouter()
const { apiFetch, unwrap, getErrorMessage } = useApi()

const articles = ref<Article[]>([])
const loading = ref(false)
const currentPage = ref(1)
const pageSize = ref(10)
const searchQuery = ref('')
const filterMode = ref<'all' | 'mine'>('all')
const searchTimeout = ref<ReturnType<typeof setTimeout> | null>(null)
const sortProp = ref<string>('title')
const sortOrder = ref<string>('ascending')

// Ambil authUser untuk cek is_mine
const authUser = useState<{ id?: string; name?: string; role?: number } | null>('auth-user', () => null)

const mapAttachment = (attachment: AttachmentApi | null): UploadUserFile | null => {
  if (!attachment) return null
  return {
    uid: attachment.id as any,
    name: attachment.name,
    url: attachment.path,
  }
}

const mapArticle = (article: ArticleApi): Article & { is_mine: boolean } => ({
  id: article.id,
  title: article.title,
  slug: article.slug,
  status: article.status ?? 'draft',
  author: article.author ? { id: article.author.id, name: article.author.name } as any : null,
  description: article.description,
  thumbnail: mapAttachment(article.thumbnail),
  is_mine: article.author?.id === authUser.value?.id,
})

// Filter berdasarkan tab dan search
const filteredArticles = computed(() => {
  let list = articles.value as any[]
  if (filterMode.value === 'mine') {
    list = list.filter((a) => a.is_mine)
  }
  return list
})

const paginatedArticles = computed(() => {
  const start = (currentPage.value - 1) * pageSize.value
  return filteredArticles.value.slice(start, start + pageSize.value)
})

const showingFrom = computed(() =>
  filteredArticles.value.length === 0 ? 0 : (currentPage.value - 1) * pageSize.value + 1,
)
const showingTo = computed(() =>
  Math.min(currentPage.value * pageSize.value, filteredArticles.value.length),
)

const handleSort = ({ prop, order }: { prop: string | null; order: string | null }) => {
  sortProp.value = prop || 'title'
  sortOrder.value = order || 'ascending'
  loadArticles()
}

const applyFilter = () => {
  currentPage.value = 1
}

const loadArticles = async () => {
  loading.value = true
  try {
    const query = new URLSearchParams()
    if (searchQuery.value) query.append('search', searchQuery.value)
    if (sortProp.value) {
      query.append('sort_by', sortProp.value)
      query.append('sort_order', sortOrder.value === 'descending' ? 'desc' : 'asc')
    }
    const response = await apiFetch<ArticleApi[] | { data: ArticleApi[] }>(`/articles?${query.toString()}`)
    articles.value = unwrap(response).map(mapArticle)
    currentPage.value = 1
  } catch (error) {
    ElMessage.error(getErrorMessage(error, 'Gagal memuat artikel.'))
  } finally {
    loading.value = false
  }
}

watch(searchQuery, () => {
  if (searchTimeout.value) clearTimeout(searchTimeout.value)
  searchTimeout.value = setTimeout(() => loadArticles(), 300)
})

const openCreate = () => {
  router.push('/admin/articles/create')
}

const openEdit = (article: Article) => {
  router.push(`/admin/articles/${article.id}`)
}

const confirmDelete = async (article: Article) => {
  try {
    await ElMessageBox.confirm(`Hapus artikel "${article.title}"?`, 'Hapus Artikel', {
      confirmButtonText: 'Hapus',
      cancelButtonText: 'Batal',
      type: 'warning',
    })
  } catch {
    return
  }

  try {
    await apiFetch(`/articles/${article.id}`, { method: 'DELETE' })
    articles.value = articles.value.filter((item) => item.id !== article.id)
    ElMessage.success('Artikel dihapus')
  } catch (error) {
    ElMessage.error(getErrorMessage(error, 'Gagal menghapus artikel.'))
  }
}

onMounted(() => {
  loadArticles()
})
</script>