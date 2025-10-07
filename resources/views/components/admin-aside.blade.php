<aside class="w-64 bg-white border-r shadow-lg">
    <div class="p-6 flex items-center space-x-2 border-b">
        <span class="text-xl font-extrabold text-blue-800">Admin Management</span>
    </div>
    <nav class="mt-6">
        {{-- Dashboard --}}
        <h4 class="text-xs font-semibold text-gray-500 uppercase px-6 pt-4 pb-2">Menu Utama</h4>
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600 
            {{ request()->routeIs('admin.dashboard') ? 'text-white bg-blue-600 font-bold border-l-4 border-yellow-400 hover:bg-blue-600 hover:text-white' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2.586l3.293 3.293a1 1 0 001.414-1.414L10.707 2.293z" />
            </svg>
            Dashboard
        </a>

        {{-- Manajemen User --}}
        <h4 class="text-xs font-semibold text-gray-500 uppercase px-6 pt-4 pb-2">Manajemen User</h4>
        <a href="{{ route('admin.users.index') }}"
            class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600
            {{ request()->routeIs('admin.users.*') ? 'text-white bg-blue-600 font-bold border-l-4 border-yellow-400 hover:bg-blue-600 hover:text-white' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            Data Peserta
        </a>

        {{-- Manajemen Agenda --}}
        <h4 class="text-xs font-semibold text-gray-500 uppercase px-6 pt-4 pb-2">Manajemen Agenda</h4>
        <a href="{{ route('admin.agenda.index') }}"
            class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600
            {{ request()->routeIs('admin.agenda.*') ? 'text-white bg-blue-600 font-bold border-l-4 border-yellow-400 hover:bg-blue-600 hover:text-white' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            Data Agenda
        </a>

        {{-- Manajemen Absensi --}}
        <h4 class="text-xs font-semibold text-gray-500 uppercase px-6 pt-4 pb-2">Manajemen Absensi</h4>

        {{-- 1. Kelola Absensi Peserta (Lihat Semua Absensi) --}}
        <a href="{{ route('admin.attendances.index') }}"
            class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600
            {{ request()->routeIs('admin.attendances.index') ? 'text-white bg-blue-600 font-bold border-l-4 border-yellow-400 hover:bg-blue-600 hover:text-white' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Kelola Absensi
        </a>

        {{-- 2. Rekap Absensi (Per-Periode) --}}
        <a href="{{ route('admin.rekap.form') }}"
            class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100 hover:text-blue-600
            {{ request()->routeIs('admin.rekap.*') ? 'text-white bg-blue-600 font-bold border-l-4 border-yellow-400 hover:bg-blue-600 hover:text-white' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Rekap Periode
        </a>
    </nav>
</aside>