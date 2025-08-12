<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // <-- Tambahkan ini

class SettingController extends Controller
{
    public function edit()
    {
        Gate::authorize('view', Setting::class); // <-- Terapkan Policy
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        Gate::authorize('update', Setting::class); // <-- Terapkan Policy
        
        // ... sisa kode method update Anda tidak berubah ...
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

        if ($request->file('app_logo')) {
            $validationRules['app_logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
        }
        
        if ($request->file('app_favicon')) {
            $validationRules['app_favicon'] = 'nullable|image|mimes:png,ico|max:100';
        }

        $validatedData = $request->validate($validationRules);
        $dataToUpdate = $validatedData;

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
            unset($dataToUpdate['app_logo']);
        }

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
            unset($dataToUpdate['app_favicon']);
        }

        foreach ($dataToUpdate as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.edit')
                         ->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function resetCounter()
    {
        // Asumsi hanya super_admin yang bisa reset, kita bisa kunci juga
        Gate::authorize('update', Setting::class); // <-- Terapkan Policy

        $visitorCount = Setting::where('key', 'visitors')->first();
        if ($visitorCount) {
            $visitorCount->value = 0;
            $visitorCount->save();
        }

        return redirect()->route('dashboard')
                         ->with('success', 'Counter pengunjung berhasil direset!');
    }
}