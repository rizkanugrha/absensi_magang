<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Dasar Pengguna') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui nama, ID Peserta (NIP/NIM), Email, dan Role pengguna ini.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        {{-- Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- ID Peserta (User ID) --}}
        <div>
            <x-input-label for="user_id" :value="__('ID Peserta (NIP/NIM/Stambuk)')" />
            <x-text-input id="user_id" name="user_id" type="text" class="mt-1 block w-full" :value="old('user_id', $user->user_id)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- Role --}}
        <div>
            <x-input-label for="role" :value="__('Role / Peran')" />
            <select id="role" name="role"
                class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                required>
                <option value="peserta" {{ (old('role', $user->role) == 'peserta') ? 'selected' : '' }}>Peserta Magang
                </option>
                <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Administrator</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('role')" />
        </div>

        {{-- Jurusan --}}
        <div>
            <x-input-label for="jurusan" :value="__('Jurusan')" />
            <x-text-input id="jurusan" name="jurusan" type="text" class="mt-1 block w-full" :value="old('jurusan', $user->jurusan)" required autofocus autocomplete="jurusan" />
            <x-input-error class="mt-2" :messages="$errors->get('jurusan')" />
        </div>

        {{-- Instansi --}}
        <div>
            <x-input-label for="instansi" :value="__('Instansi')" />
            <x-text-input id="instansi" name="instansi" type="text" class="mt-1 block w-full" :value="old('instansi', $user->instansi)" required autofocus autocomplete="instansi" />
            <x-input-error class="mt-2" :messages="$errors->get('instansi')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
        </div>
    </form>
</section>