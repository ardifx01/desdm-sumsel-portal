<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-bold">Total Pengunjung Website</h5>
                            <form action="{{ route('admin.settings.reset-counter') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset counter pengunjung?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Reset Counter</button>
                            </form>
                        </div>
                        <p class="text-muted">Jumlah kunjungan sejak terakhir kali direset</p>
                        <div class="card p-4 shadow-sm">
                            <h1 class="display-4 fw-bold">{{ $settings['visitors'] ?? 0 }}</h1>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
