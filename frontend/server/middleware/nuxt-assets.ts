import { defineEventHandler, getRequestURL, send } from 'h3'

export default defineEventHandler(async (event) => {
  const { pathname } = getRequestURL(event)

  if (pathname === '/_nuxt' || pathname === '/_nuxt/') {
    event.node.res.statusCode = 204
    return send(event, '')
  }
})
