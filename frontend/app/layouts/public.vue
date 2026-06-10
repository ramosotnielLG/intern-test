<template>
  <div class="flex flex-col min-h-screen bg-white">
    <header class="border-b border-gray-100 sticky top-0 z-50 bg-white/90 backdrop-blur-md">
      <div class="flex justify-between items-center py-6 max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex items-center">
          <p class="font-extrabold text-gray-800 tracking-wider text-2xl md:text-3xl">
            <NuxtLink to="/">MEGAPACK</NuxtLink>
          </p>
        </div>

        <div class="flex items-center gap-6 md:gap-10">
          <nav>
            <ul class="flex gap-6 md:gap-8 font-semibold text-gray-600 text-sm md:text-base">
              <li class="hover:text-gray-900 cursor-pointer transition-colors"><NuxtLink to="/services">SERVICES</NuxtLink></li>
              <li class="hover:text-gray-900 cursor-pointer transition-colors flex items-center">
                <el-dropdown 
                class="hover:text-gray-900 cursor-pointer transition-colors custom-nav-dropdown">
                  <span class="el-dropdown-link">DROPDOWN</span>
                  <template #dropdown>
                    <el-dropdown-menu>
                      <el-dropdown-item>
                        <NuxtLink to="/articles" class="block w-full h-full">Articles</NuxtLink>
                        </el-dropdown-item>
                      <el-dropdown-item>
                        <NuxtLink to="/about" class="block w-full h-full">About Us</NuxtLink></el-dropdown-item>
                    </el-dropdown-menu>
                  </template>
                </el-dropdown>
              </li>
              <li class="hover:text-gray-900 cursor-pointer transition-colors"><NuxtLink to="/contact">CONTACT</NuxtLink></li>
            </ul>
          </nav>

          <div class="flex gap-3 items-center text-gray-500">
            <NuxtLink to="/login" class="hover:text-gray-900 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
              </svg>
            </NuxtLink>
          </div>
        </div>
      </div>
    </header>
    
    <main>
      <slot />
    </main>

    <footer class="bg-gray-900 text-gray-400">
      <div class="max-w-7xl mx-auto px-6 md:px-12 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-gray-800">
          
          <div class="space-y-4">
            <p class="font-extrabold text-white tracking-wider text-xl">MEGAPACK</p>
            <p class="text-sm leading-relaxed text-gray-400">
              Menyediakan solusi kemasan dan infrastruktur pengemasan terbaik berskala internasional untuk bisnis Anda.
            </p>
          </div>

          <div class="space-y-3">
            <p class="text-white font-bold text-sm tracking-wider uppercase">Quick Links</p>
            <ul class="space-y-2 text-sm">
              <li><NuxtLink to="/services" class="hover:text-white transition-colors hover:underline underline-offset-4">Our Services</NuxtLink></li>
              <li><NuxtLink to="/about" class="hover:text-white transition-colors hover:underline underline-offset-4">About Us</NuxtLink></li>
              <li><NuxtLink to="/contact" class="hover:text-white transition-colors hover:underline underline-offset-4">Contact Support</NuxtLink></li>
              <li><a href="https://music.apple.com/id/album/obzen/1882049235" target="_blank" class="hover:text-white transition-colors hover:underline underline-offset-4">Privacy Policy</a></li>
            </ul>
          </div>

          <div class="space-y-3">
            <p class="text-white font-bold text-sm tracking-wider uppercase">Contact Us</p>
            <ul class="space-y-2 text-sm">
              <li>📍 Jakarta, Indonesia</li>
              <li>✉️ info@megapack.co.id</li>
              <li>📞 +62 21 1234 5678</li>
            </ul>
          </div>

        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center pt-8 text-xs text-gray-500 gap-4">
          <p>&copy; 2026 MEGAPACK. All rights reserved.</p>
          <p>Designed for professional industrial inquiry systems.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
:deep(.custom-nav-dropdown) {
  color: inherit !important;
  font-size: inherit !important;
  font-weight: inherit !important;
  letter-spacing: inherit !important;
  transition: color 150ms cubic-bezier(0.4, 0, 0.2, 1) !important;
}

:deep(.el-tooltip__trigger:focus-visible) {
  outline: none !important;
}

.block-col-2 .el-dropdown-link {
  display: flex;
  align-items: center;
}
</style>