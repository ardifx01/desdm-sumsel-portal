import './bootstrap'; // Ini mengimpor konfigurasi bootstrap.js bawaan Laravel
import * as bootstrap from 'bootstrap'; // Ini mengimpor seluruh Bootstrap JavaScript

// Impor Chart.js (jika ada)
import Chart from 'chart.js/auto';
window.Chart = Chart; // Membuat Chart.js tersedia secara global

console.log('Aplikasi JavaScript utama dimuat!');

import './bootstrap';
import './pejabat-modal.js';
import './comment-system.js';
import './load-more.js';
// Fungsi untuk mengontrol tombol "Kembali ke atas" dan animasi wiggle
document.addEventListener('DOMContentLoaded', function() {
    const scrollToTopButton = document.getElementById('scroll-to-top');
    const wiggleButton = document.querySelector('.floating-list .floating-item:first-child button');
    let scrollTimeout;

    // Tampilkan/sembunyikan tombol saat halaman di-scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollToTopButton.style.display = 'block';
        } else {
            scrollToTopButton.style.display = 'none';
        }

        // --- Perbaikan pada logika animasi di sini ---
        if (wiggleButton && !wiggleButton.classList.contains('animate-wiggle')) {
            // Tambahkan kelas animasi HANYA jika belum ada
            wiggleButton.classList.add('animate-wiggle');
        }
        
        // Atur timeout untuk menghapus kelas setelah durasi animasi (3 detik)
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        scrollTimeout = setTimeout(() => {
            if (wiggleButton) {
                wiggleButton.classList.remove('animate-wiggle');
            }
        }, 3100); // 3100ms agar ada jeda sedikit setelah 3s
    });

    // Fungsi untuk kembali ke atas saat tombol diklik
    if (scrollToTopButton) {
        scrollToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});