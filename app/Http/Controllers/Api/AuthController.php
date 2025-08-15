<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menangani permintaan login melalui API.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required|string', // Nama perangkat untuk token (misal: 'My iPhone 14')
        ]);

        $user = User::where('email', $request->email)->first();

        // Periksa apakah pengguna ada dan password cocok
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial yang diberikan tidak cocok dengan catatan kami.'],
            ]);
        }

        // Hapus token lama dengan nama perangkat yang sama untuk mencegah duplikasi
        $user->tokens()->where('name', $request->device_name)->delete();

        // Buat token baru
        $token = $user->createToken($request->device_name)->plainTextToken;

        // Catat aktivitas login
        activity()
           ->causedBy($user)
           ->log('Pengguna berhasil masuk melalui API');

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Menangani permintaan logout melalui API.
     */
    public function logout(Request $request)
    {
        // Dapatkan pengguna yang terotentikasi saat ini
        $user = $request->user();

        // Hapus token yang digunakan untuk permintaan ini
        $user->currentAccessToken()->delete();

        // Catat aktivitas logout
        activity()
           ->causedBy($user)
           ->log('Pengguna berhasil keluar melalui API');

        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }
}