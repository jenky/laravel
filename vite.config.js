import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { callArtisan, laravel, findPhpPath } from 'vite-plugin-laravel'

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      watch: [
        {
          condition: (file) => file.includes('routes/'),
          handle: () => callArtisan(findPhpPath(), 'ziggy:generate'),
        },
      ],
    })
  ]
})
