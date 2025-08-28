import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import ui from '@nuxt/ui/vite'
import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
const suff = 'v14';
export default defineConfig({
    base: '/mobile/build/',
    build: {
        rollupOptions: {
            output: {
                manualChunks: undefined,
                inlineDynamicImports: true,
                entryFileNames: `[name]-${suff}.js`, // currently does not work for the legacy bundle
                assetFileNames: `[name]-${suff}.[ext]`, // currently does not work for images
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
