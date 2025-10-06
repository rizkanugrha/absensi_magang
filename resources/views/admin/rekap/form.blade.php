<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekapitulasi Absensi Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Tombol Kembali ke Filter Form --}}
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                &larr; Kembali ke Dashboard
            </a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <header class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('Filter Data Absensi') }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Pilih rentang tanggal dan nama peserta untuk melihat data absensi.
                    </p>
                </header>

                {{-- Form akan mengarah ke route generateRekap (asumsi admin.rekap.generate sudah didefinisikan) --}}
                <form method="GET" action="{{ route('admin.rekap.generate') }}"
                    class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">

                    {{-- Filter User --}}
                    <div>
                        <x-input-label for="user_id" :value="__('Pilih Peserta')" />
                        <select id="user_id" name="user_id"
                            class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full md:w-64">
                            <option value="">-- Semua Peserta --</option>
                            {{-- $users dikirim dari controller showRekapForm() --}}
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ (request('user_id') == $user->id) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->user_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div>
                        <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 w-full md:w-40"
                            :value="request('start_date')" required />
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div>
                        <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 w-full md:w-40"
                            :value="request('end_date')" required />
                    </div>

                    <div class="pt-2 md:pt-0">
                        <x-primary-button>{{ __('Tampilkan Rekap') }}</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>