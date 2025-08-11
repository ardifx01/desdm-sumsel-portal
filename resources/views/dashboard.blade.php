<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- KONTEN DASHBOARD BERDASARKAN PERAN --}}
            @if(Auth::user()->role === 'super_admin')
                @include('dashboard.partials.super_admin')
            @elseif(Auth::user()->role === 'ppid_admin')
                @include('dashboard.partials.ppid_admin')
            @elseif(Auth::user()->role === 'editor')
                @include('dashboard.partials.editor')
            @else
                @include('dashboard.partials.user_default')
            @endif
        </div>
    </div>
</x-app-layout>