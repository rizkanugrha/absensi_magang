<x-app-layout>
    @php
        $isEdit = isset($agenda);
        $title = $isEdit ? 'Edit Agenda' : 'Tambah Agenda Baru';
        $action = $isEdit ? route('admin.agenda.update', $agenda) : route('admin.agenda.store');
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-50">
        <x-admin-aside />
        <main class="flex-1 py-12 px-6">
            <div class="max-w-3xl mx-auto">
                <a href="{{ route('admin.agenda.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mb-4 inline-block">
                    &larr; Kembali ke Data Agenda
                </a>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-2xl font-semibold mb-6 text-gray-800">{{ $title }}</h2>

                    <form method="POST" action="{{ $action }}">
                        @csrf
                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Tanggal Kegiatan')" />
                            <x-text-input id="date" type="date" name="date" :value="old('date', $agenda->date ?? date('Y-m-d'))" required autofocus />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Judul Agenda')" />
                            <x-text-input id="title" type="text" name="title" :value="old('title', $agenda->title ?? '')"
                                required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Detail kegiatan harian atau agenda penting.">{{ old('description', $agenda->description ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex space-x-4 mb-6">
                            <div class="flex-1">
                                <x-input-label for="start_time" :value="__('Waktu Mulai')" />
                                <x-text-input id="start_time" type="time" name="start_time" :value="old('start_time', $agenda->start_time ?? '')" />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                            <div class="flex-1">
                                <x-input-label for="end_time" :value="__('Waktu Selesai')" />
                                <x-text-input id="end_time" type="time" name="end_time" :value="old('end_time', $agenda->end_time ?? '')" />
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.agenda.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ $isEdit ? 'Simpan Perubahan' : 'Buat Agenda' }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>