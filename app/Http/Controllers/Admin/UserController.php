<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna.
     */
    public function index()
    {
        $users = User::latest()->paginate(15);
        $roles = ['super_admin', 'ppid_admin', 'editor', 'moderator', 'user'];

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Tampilkan form untuk membuat pengguna baru.
     */
    public function create()
    {
        $roles = ['super_admin', 'ppid_admin', 'editor', 'moderator', 'user'];
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Simpan pengguna baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:super_admin,ppid_admin,editor,moderator,user',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form untuk mengedit profil pengguna lain.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Perbarui peran pengguna lain.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:super_admin,ppid_admin,editor,moderator,user',
        ]);
        
        $user->role = $request->input('role');
        $user->save();

        return back()->with('success', "Peran pengguna '{$user->name}' berhasil diperbarui.");
    }
    
    /**
     * Perbarui informasi profil pengguna lain.
     */
    public function updateProfile(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        $user->save();

        return redirect()->route('admin.users.edit', $user)
                         ->with('success', "Informasi profil pengguna berhasil diperbarui.");
    }
    
    /**
     * Perbarui kata sandi pengguna lain.
     */
    public function updatePassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('admin.users.edit', $user)
                         ->with('success', "Kata sandi pengguna berhasil diperbarui.");
    }

        /**
     * Hapus pengguna.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', "Pengguna '{$user->name}' berhasil dihapus.");
    }
}