// resources/js/admin/static-pages.js

document.addEventListener('DOMContentLoaded', () => {
    // Cari semua tombol dengan class 'copy-slug-button'
    const copyButtons = document.querySelectorAll('.copy-slug-button');

    copyButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah aksi default jika ada

            // Ambil teks slug dari atribut data-slug
            const textToCopy = this.dataset.slug;
            if (!textToCopy) return;

            // Simpan ikon asli
            const originalIcon = this.innerHTML;
            
            // Gunakan API modern jika tersedia
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    showSuccess(this, originalIcon);
                }).catch(err => {
                    console.error('Gagal menyalin dengan API modern:', err);
                    fallbackCopy(textToCopy, this, originalIcon);
                });
            } else {
                // Gunakan metode fallback
                fallbackCopy(textToCopy, this, originalIcon);
            }
        });
    });
});

/**
 * Menampilkan feedback visual bahwa teks berhasil disalin.
 * @param {HTMLElement} button - Tombol yang diklik.
 * @param {string} originalIcon - HTML ikon asli.
 */
function showSuccess(button, originalIcon) {
    // Ganti ikon menjadi centang
    button.innerHTML = '<i class="bi bi-check-lg text-green-500"></i>';
    
    // Kembalikan ikon asli setelah 1.5 detik
    setTimeout(() => {
        button.innerHTML = originalIcon;
    }, 1500);
}

/**
 * Metode fallback untuk menyalin teks di browser lama atau koneksi HTTP.
 * @param {string} text - Teks yang akan disalin.
 * @param {HTMLElement} button - Tombol yang diklik.
 * @param {string} originalIcon - HTML ikon asli.
 */
function fallbackCopy(text, button, originalIcon) {
    let textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    textArea.style.left = "-9999px";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        showSuccess(button, originalIcon);
    } catch (err) {
        console.error('Gagal menyalin dengan metode fallback:', err);
        alert('Gagal menyalin slug.');
    }
    document.body.removeChild(textArea);
}