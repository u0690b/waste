import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import ui from '@nuxt/ui/vite'
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
const suff = 'v2';
export default defineConfig({
    base: '/mobile/',
    build: {
        rollupOptions: {
            output: {
                entryFileNames: 'assets/[name]-' + suff + '.js',
                chunkFileNames: 'assets/[name]-' + suff + '.js',
                assetFileNames: 'assets/[name]-' + suff + '[extname]',
            },
        },
    },
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),

        ui({
            inertia: true,
        }),
        tailwindcss(),
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
