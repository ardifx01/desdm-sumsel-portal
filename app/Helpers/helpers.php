<?php

// Tidak perlu namespace di file helper global

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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