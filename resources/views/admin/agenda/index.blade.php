{{-- File: resources/views/admin/agenda/index.blade.php --}}
<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">

       <aside class="w-64 bg-white border-r shadow-lg">
            <div class="p-6 flex items-center space-x-2 border-b">
                <span class="text-xl font-extrabold text-blue-800">Admin Management</span>
            </div>
            <nav class="mt-6">
                {{-- Dashboard Aktif --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-6 py-3 text-white bg-blue-600 font-bold border-l-4 border-yellow-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2.586l3.293 3.293a1 1 0 001.414-1.414L10.707 2.293z" />
                    </svg>
                    Dashboard
                </a>

                {{-- Manajemen User --}}
                <h4 class="text-xs font-semibold text-gray-500 uppercase px-6 pt-4 pb-2">Manajemen User</h4>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                    Data Peserta
                </a>

                {{-- Manajemen Agenda --}}
                <h4 class="text-xs font-semibold text-gray-500 uppercase px-6 pt-4 pb-2">Manajemen Agenda</h4>
                <a href="{{ route('admin.agenda.index') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                    Data Agenda
                </a>

                {{-- Manajemen Absensi --}}
                <h4 class="text-xs font-semibold text-gray-500 uppercase px-6 pt-4 pb-2">Manajemen Absensi</h4>

                {{-- 1. Kelola Absensi Peserta (Lihat Semua Absensi) --}}
                <a href="{{ route('admin.attendances.index') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Kelola Absensi
                </a>

                {{-- 2. Rekap Absensi (Per-Periode) --}}
                <a href="{{ route('admin.rekap.form') }}"
                    class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Rekap Periode
                </a>
            </nav>
        </aside>

        <main class="flex-1 py-10 px-6">
            <div class="max-w-7xl mx-auto">
                {{-- Notifikasi --}}
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Agenda Harian</h2>
                        <a href="{{ route('admin.agenda.create') }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            + Tambah Agenda
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($agendas as $agenda)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($agenda->date)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $agenda->start_time ?? '00:00' }} - {{ $agenda->end_time ?? '23:59' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            {{ $agenda->title }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $agenda->description }}">
                                            {{ \Illuminate\Support\Str::limit($agenda->description, 50) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                            <a href="{{ route('admin.agenda.edit', $agenda) }}"
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('admin.agenda.destroy', $agenda) }}" method="POST"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data agenda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $agendas->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>