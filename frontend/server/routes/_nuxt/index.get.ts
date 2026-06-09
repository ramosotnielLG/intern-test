import { defineEventHandler, setResponseStatus } from 'h3'

export default defineEventHandler((event) => {
  // Return 204 for accidental directory hits on /_nuxt to avoid noisy 404 logs.
  setResponseStatus(event, 204)
  return ''
})
