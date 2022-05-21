import { defineConfig, splitVendorChunkPlugin } from 'vite'
import vue from '@vitejs/plugin-vue'
import AutoImport from 'unplugin-auto-import/vite'
import { callArtisan, laravel, findPhpPath } from 'vite-plugin-laravel'

export default defineConfig({
  plugins: [
    splitVendorChunkPlugin(),
    vue(),
    AutoImport({
      imports: [
        'vue',
        {
          '@inertiajs/inertia-vue3': [
            'useForm',
          ],
        },
      ],
    }),
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
