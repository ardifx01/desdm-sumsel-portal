@extends('layouts.public_app')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
        </ol>
    </nav>
    <h2 class="mb-4">Hasil Pencarian untuk "{{ $query }}"</h2>

    @forelse ($results as $group)
        @if ($group['items']->isNotEmpty())
            <h3 class="mt-5 mb-3">{{ $group['label'] }} ({{ $group['items']->count() }})</h3>
            <div class="row">
                @foreach ($group['items'] as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm pejabat-card">
                            <div class="card-body ">
                                {{-- Judul dengan highlight --}}
                                <h5 class="card-title">{!! highlight($item['title'], $query) !!}</h5>

                                {{-- Meta info, seperti kategori --}}
                                @if(isset($item['category_name']))
                                <p class="card-text text-muted small">
                                    <span class="badge bg-secondary">{{ $item['category_name'] }}</span>
                                </p>
                                @endif

                                {{-- Ringkasan konten dengan highlight --}}
                                <p class="card-text">{{ Str::limit(strip_tags(highlight($item['content'] ?? '', $query)), 150) }}</p>

                                {{-- Tautan detail --}}
                                @if($item['type'] === 'seksi')
                                    <a href="{{ route($group['route_name'], $item['parent_slug']) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail Induk</a>
                                @elseif(isset($item['slug']))
                                    <a href="{{ route($group['route_name'], $item['slug']) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
                                @else
                                    <a href="{{ route($group['route_name'], $item['id']) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr>
        @endif
    @empty
        <div class="alert alert-info text-center" role="alert">
            Tidak ada hasil yang ditemukan untuk "{{ $query }}".
        </div>
    @endforelse

    {{-- Catatan: Pagination tidak disertakan dalam pencarian ini karena menggabungkan beberapa model. --}}
</div>
@endsection