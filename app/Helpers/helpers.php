<?php

// Tidak perlu namespace di file helper global

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (! function_exists('highlight')) {
    /**
     * Memberikan highlight pada query di dalam sebuah teks.
     *
     * @param  string|null  $text
     * @param  string|null  $query
     * @return string
     */
    function highlight($text, $query): string
    {
        if (!$query || !is_string($text)) {
            return $text;
        }

        $escapedQuery = preg_quote($query, '/');
        return preg_replace("/($escapedQuery)/i", '<mark>$1</mark>', $text);
    }
}

if (! function_exists('getUniqueBadgeColor')) {
    /**
     * Mendapatkan nama warna Tailwind yang DIJAMIN UNIK
     * dari peta warna statis.
     *
     * @param string $categoryName Nama kategori
     * @return string Nama warna (misal: 'red', 'blue')
     */
    function getUniqueBadgeColor(string $categoryName): string
    {
        // Bersihkan nama kategori untuk pencocokan yang andal
        $cleanName = strtolower(trim($categoryName));

        // ==========================================================
        //         PETA WARNA STATIS (SUMBER KEBENARAN TUNGGAL)
        // ==========================================================
        static $colorMap = [
            // pattern: /^(bg|text)-(red|blue|green|indigo|purple|orange|pink|teal|cyan|lime|amber|sky|violet|fuchsia|rose|gray)-(100|800)$/,
            // Kategori Berita
            'energi' => 'green',
            'berita' => 'purple',
            'ketenagalistrikan' => 'lime',
            'pengusahaan minerba' => 'yellow',
            'teknik dan penerimaan minerba' => 'orange',
            'geolab' => 'blue',
            'edukasi' => 'red',
            
            // Kategori Dokumen
            'dokumen perencanaan' => 'yellow',
            'laporan keuangan' => 'red',
            'laporan kinerja' => 'green',
            'materi edukasi' => 'purple',
            'regulasi' => 'blue',
            
            // Kategori Informasi Publik
            'informasi berkala' => 'yellow',
            'informasi serta merta' => 'green',
            'informasi setiap saat' => 'rose',
        ];
        
        // Cek apakah nama ada di peta. Jika ya, kembalikan warnanya.
        if (isset($colorMap[$cleanName])) {
            return $colorMap[$cleanName];
        }

        // Fallback jika ada kategori baru yang belum dipetakan
        return 'gray';
    }
}

if (! function_exists('generate_excerpt')) {
    /**
     * Membuat potongan teks (excerpt) di sekitar kata kunci yang ditemukan.
     *
     * @param string|null $content Teks lengkap.
     * @param string|null $keyword Kata kunci yang dicari.
     * @param int $radius Jumlah karakter sebelum dan sesudah kata kunci.
     * @param int $totalLength Panjang total fallback jika kata kunci tidak ditemukan.
     * @return string Potongan teks yang relevan.
     */
    function generate_excerpt(?string $content, ?string $keyword, int $radius = 100, int $totalLength = 150): string
    {
        if (is_null($content)) {
            return '';
        }

        // Hapus tag HTML untuk mencegah potongan teks yang rusak
        $strippedContent = strip_tags($content);

        // Jika tidak ada kata kunci, atau kata kunci kosong, gunakan Str::limit standar
        if (is_null($keyword) || trim($keyword) === '') {
            return Str::limit($strippedContent, $totalLength);
        }

        // Cari posisi kata kunci (case-insensitive)
        $pos = mb_stripos($strippedContent, $keyword);

        // Jika kata kunci tidak ditemukan di konten, gunakan Str::limit standar
        if ($pos === false) {
            return Str::limit($strippedContent, $totalLength);
        }

        // Hitung titik awal untuk potongan teks
        $start = max(0, $pos - $radius);

        // Hitung panjang potongan teks
        $length = mb_strlen($keyword) + ($radius * 2);

        // Ambil potongan teks dari string asli
        $excerpt = mb_substr($strippedContent, $start, $length);

        // Tambahkan elipsis "..." di awal jika potongan tidak dimulai dari awal teks
        if ($start > 0) {
            $excerpt = '... ' . $excerpt;
        }

        // Tambahkan elipsis "..." di akhir jika potongan tidak berakhir di akhir teks
        if (($start + $length) < mb_strlen($strippedContent)) {
            $excerpt = $excerpt . ' ...';
        }

        return $excerpt;
    }
}