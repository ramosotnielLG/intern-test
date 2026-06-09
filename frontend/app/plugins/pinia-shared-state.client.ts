import { PiniaSharedState } from 'pinia-shared-state'
import type { Pinia } from 'pinia' // 1. Import tipe data Pinia asli

export default defineNuxtPlugin((nuxtApp) => {
  if (import.meta.client && nuxtApp.$pinia) {
    // 2. Bungkus dengan kurung dan cast 'as Pinia'
    (nuxtApp.$pinia as Pinia).use(
      PiniaSharedState({
        enable: true,
        initialize: true,
      }),
    )
  }
})