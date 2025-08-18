// resources/js/admin/bidang-form.js

document.addEventListener('DOMContentLoaded', function () {
    const tipeSelect = document.getElementById('tipe');
    const wilayahKerjaField = document.getElementById('wilayah_kerja_field');
    const alamatField = document.getElementById('alamat_field');
    const mapField = document.getElementById('map_field');

    // --- PENINGKATAN KODE: Pastikan elemen ada sebelum menambahkan event listener ---
    // Ini membuat kode lebih aman dan tidak akan error jika dijalankan di halaman lain
    // yang tidak memiliki elemen 'tipe'.
    if (tipeSelect) {
        function toggleFields() {
            const selectedType = tipeSelect.value;
            if (selectedType === 'cabang_dinas') {
                wilayahKerjaField.style.display = 'block';
                alamatField.style.display = 'block';
                mapField.style.display = 'block';
            } else if (selectedType === 'UPTD') {
                wilayahKerjaField.style.display = 'none';
                alamatField.style.display = 'block';
                mapField.style.display = 'block';
            }
            else { // Bidang atau pilihan kosong
                wilayahKerjaField.style.display = 'none';
                alamatField.style.display = 'none';
                mapField.style.display = 'none';
            }
        }

        tipeSelect.addEventListener('change', toggleFields);
        toggleFields(); // Panggil saat halaman dimuat untuk initial state
    }
});