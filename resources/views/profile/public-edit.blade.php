@extends('layouts.public_app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Pengaturan Akun</h2>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success">
                Profil Anda berhasil diperbarui.
            </div>
        @endif
        @if (session('status') === 'password-updated')
            <div class="alert alert-success">
                Kata sandi Anda berhasil diubah.
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                {{-- Form Update Informasi Profil --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Informasi Profil</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted mb-4">Perbarui informasi profil dan data kontak Anda.</p>
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            {{-- INPUT TERSEMBUNYI UNTUK PENGALIHAN --}}
                            <input type="hidden" name="source" value="public">

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="telp" class="form-label">Nomor Telepon</label>
                                <input id="telp" name="telp" type="text" class="form-control @error('telp') is-invalid @enderror" value="{{ old('telp', $user->telp) }}" autocomplete="tel">
                                @error('telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>

                {{-- Form Update Password --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="bi bi-key-fill me-2 text-primary"></i>Ubah Kata Sandi</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted mb-4">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            {{-- INPUT TERSEMBUNYI UNTUK PENGALIHAN --}}
                            <input type="hidden" name="source" value="public">

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                                <input id="current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
                                @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi Baru</label>
                                <input id="password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                                @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Kata Sandi</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                {{-- Opsi Hapus Akun --}}
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Hapus Akun</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Setelah akun Anda dihapus, semua datanya akan dihapus secara permanen.</p>
                        <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
                            Hapus Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus Akun -->
        <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirm-user-deletion-label">Apakah Anda yakin?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Setelah akun Anda dihapus, semua datanya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi.</p>
                        <div class="mt-3">
                            <label for="password-delete" class="form-label">Kata Sandi</label>
                            <input id="password-delete" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Kata Sandi">
                            @error('password', 'userDeletion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus Akun Permanen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection