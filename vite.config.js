import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js', 
                
                // 1 - Assets of admin
                'resources/admin/css/materialdesignicons.min.css',
                'resources/admin/css/lineicons.css',
                'resources/admin/scss/admin.scss',
                'resources/admin/js/admin.js',
            ],
            refresh: true,
        }),
    ],
});
