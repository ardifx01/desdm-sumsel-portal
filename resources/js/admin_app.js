import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;

Alpine.start();

import './admin/bidang-form.js';
import './admin/photo-upload.js';
import './admin/static-pages.js';

// --- INISIALISASI TINYMCE ---
// Pastikan DOM sudah siap sebelum menginisialisasi TinyMCE
document.addEventListener('DOMContentLoaded', function () {
    // Cek apakah ada elemen textarea dengan ID 'editor' atau class 'tinymce-editor'
    if (typeof tinymce !== 'undefined') { // Pastikan TinyMCE library sudah dimuat
        tinymce.init({
            selector: 'textarea.tinymce-editor', // Targetkan textarea dengan class ini
            plugins: 'advlist autolink lists link image charmap print preview anchor ' +
                     'searchreplace visualblocks code fullscreen insertdatetime media table paste ' +
                     'wordcount', // Plugin yang diaktifkan

            toolbar: 'undo redo | formatselect | bold italic backcolor | ' +
                     'alignleft aligncenter alignright alignjustify | ' +
                     'bullist numlist outdent indent | removeformat | help | link image code', // Toolbar kustom

            branding: false, // <-- PENTING: Untuk menghilangkan tulisan 'Powered by TinyMCE'
            menubar: false,  // Opsional: Untuk menghilangkan menubar di atas toolbar
            height: 400,     // Tinggi editor
            // content_css: '//www.tiny.cloud/css/codex.min.css' // Contoh CSS tambahan untuk konten editor

            // Integrasi untuk upload gambar (jika Anda ingin fitur upload gambar langsung dari TinyMCE)
            // Ini memerlukan backend khusus untuk menerima dan menyimpan file.
            // Saat ini, Anda bisa mengabaikan atau menggunakan fitur link gambar eksternal.
            // file_picker_callback: function (cb, value, meta) {
            //     var input = document.createElement('input');
            //     input.setAttribute('type', 'file');
            //     input.setAttribute('accept', 'image/*');
            //     input.onchange = function () {
            //         var file = this.files[0];
            //         var reader = new FileReader();
            //         reader.onload = function () {
            //             var id = 'blobid' + (new Date()).getTime();
            //             var blobCache = tinymce.activeEditor.editorUpload.blobCache;
            //             var base64 = reader.result.split(',')[1];
            //             var blobInfo = blobCache.create(id, file, base64);
            //             blobCache.add(blobInfo);
            //             cb(blobInfo.blobUri(), { title: file.name });
            //         };
            //         reader.readAsDataURL(file);
            //     };
            //     input.click();
            // }
        });
    }


    
});