@extends('layouts.public_app')

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
            </ol>
        </nav>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                    {!! $page->content !!}

        {{-- Tampilkan tanggal dari properti model yang sudah ada --}}
        {{-- Gunakan $page->updated_at untuk tanggal terakhir diperbarui --}}
        <p class="mt-4 text-muted text-gray-300">
            Terakhir diperbarui: {{ $page->updated_at->format('d F Y') }}
        </p>
            </div>
        </div>
    </div>
@endsection