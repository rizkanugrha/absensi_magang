<x-guest-layout>
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">

        {{-- Icon bulat di atas --}}
        <div class="flex justify-center mb-4">
            <div class="bg-blue-500 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
        </div>

        {{-- Judul --}}
        <h1 class="text-2xl font-bold text-center text-gray-800">Absensi Magang</h1>
        <p class="text-sm text-center text-gray-500 mb-6">Sign in to your account</p>

        {{-- Pesan error --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Pesan status --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- User ID -->
            <div class="mb-4">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1118.364 4.56M12 7v5l3 3" />
                        </svg>
                    </span>
                    <input id="user_id" type="text" name="user_id" placeholder="User ID" value="{{ old('user_id') }}"
                        required autofocus
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0-1.105-.895-2-2-2s-2 .895-2 2 2 2 2 2zm0 0v6m0-6c0-1.105.895-2 2-2s2 .895 2 2-2 2-2 2zm0 0v6" />
                        </svg>
                    </span>
                    <input id="password" type="password" name="password" placeholder="Password" required
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Role -->
            <div class="mb-6">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V7a2 2 0 00-2-2h-4V3H10v2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4" />
                        </svg>
                    </span>
                    <select id="role" name="role" required
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="peserta" {{ old('role') == 'peserta' ? 'selected' : '' }}>Peserta</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition">
                Sign In
            </button>
        </form>
    </div>
</x-guest-layout>