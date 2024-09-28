import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { defineConfig } from 'vite';

export default defineConfig({
    server: {
        cors: true,
    },
    build: {
        rollupOptions: {
          output: {
            manualChunks: {
              pdfjs: ['pdfjs-dist'],
            },
          },
        },
      },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
