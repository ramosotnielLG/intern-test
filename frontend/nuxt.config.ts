import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  css: ['./app/assets/css/main.css'],
  vite: {
    plugins: [
      tailwindcss(),
    ],
    optimizeDeps: {
      include: [
        '@vue/devtools-core',
        '@vue/devtools-kit',
        'dayjs', // CJS
        'dayjs/plugin/*.js',
        'lodash-unified',
        'pinia-shared-state',
      ]
    },
    server:{
      fs:{
        allow:[
          'C:/Users/RAMOS/intern-test'
        ]
      }
    }
  },
  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://localhost:8000',
    },
  },
  modules: [
    '@element-plus/nuxt',
    '@pinia/nuxt'
  ],
});