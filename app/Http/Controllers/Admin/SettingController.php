<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan form untuk mengedit pengaturan umum.
     */
    public function edit()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Update pengaturan di database.
     */
    public function update(Request $request)
    {
        
        // Aturan validasi dasar
        $validationRules = [
            'app_name' => 'required|string|max:255',
            'alamat_kantor' => 'required|string',
            'email_kontak' => 'required|email',
            'telp_kontak' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
        ];

        // Tambahkan aturan 'image' hanya jika file diunggah
        if ($request->file('app_logo')) {
            $validationRules['app_logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
        }
        
        if ($request->file('app_favicon')) {
            $validationRules['app_favicon'] = 'nullable|image|mimes:png,ico|max:100';
        }

        $validatedData = $request->validate($validationRules);
        
        // Siapkan array untuk menyimpan data yang akan diupdate ke database
        $dataToUpdate = $validatedData;

        // --- Perbaikan Logika Penyimpanan ---

        // Tangani unggahan logo
        $logoFile = $request->file('app_logo');
        if ($logoFile) {
            $fileName = 'logo.' . $logoFile->getClientOriginalExtension();
            $path = public_path('storage/images/settings');
            
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $logoFile->move($path, $fileName);
            $dataToUpdate['app_logo'] = 'images/settings/' . $fileName;
        } else {
            // Hapus dari data jika tidak ada file yang diunggah
            unset($dataToUpdate['app_logo']);
        }

        // Tangani unggahan favicon
        $faviconFile = $request->file('app_favicon');
        if ($faviconFile) {
            $fileName = 'favicon.' . $faviconFile->getClientOriginalExtension();
            $path = public_path('storage/images/settings');
            
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            
            $faviconFile->move($path, $fileName);
            $dataToUpdate['app_favicon'] = 'images/settings/' . $fileName;
        } else {
            // Hapus dari data jika tidak ada file yang diunggah
            unset($dataToUpdate['app_favicon']);
        }

        // Simpan semua data ke database
        foreach ($dataToUpdate as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.edit')
                         ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}