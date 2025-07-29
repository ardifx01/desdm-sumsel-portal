import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', // Aset Publik (Bootstrap)
                'resources/js/app.js',    // Aset Publik (Bootstrap JS, Chart.js)
                'resources/sass/admin_app.scss', // Aset Admin (Tailwind)
                'resources/js/admin_app.js',    // Aset Admin (Alpine.js)
            ],
            refresh: true,
        }),
    ],
});