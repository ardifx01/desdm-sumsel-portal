import './bootstrap'; // Ini mengimpor konfigurasi bootstrap.js bawaan Laravel
import * as bootstrap from 'bootstrap'; // Ini mengimpor seluruh Bootstrap JavaScript

// Impor Chart.js (jika ada)
import Chart from 'chart.js/auto';
window.Chart = Chart; // Membuat Chart.js tersedia secara global

console.log('Aplikasi JavaScript utama dimuat!');