<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hapus Akun Pengguna') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Setelah akun dihapus, semua sumber daya dan datanya akan dihapus secara permanen.") }}
        </p>
    </header>

    {{-- Logika Pengecekan Keamanan: Admin tidak bisa menghapus akunnya sendiri --}}
    @php
        $isSelf = (Auth::user() && Auth::user()->id === $user->id);
    @endphp

    @if ($isSelf)
        {{-- Jika Admin mencoba menghapus akunnya sendiri --}}
        <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded relative">
            <p class="font-bold">{{ __('Peringatan!') }}</p>
            <p>{{ __('Anda tidak dapat menghapus akun Anda sendiri melalui halaman ini.') }}</p>
        </div>
        <x-danger-button disabled>
            {{ __('Hapus Akun') }}
        </x-danger-button>
    @else
        {{-- Form Hapus Akun --}}
        <form method="post" action="{{ route('admin.users.destroy', $user) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Apakah Anda yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Tindakan ini tidak dapat dibatalkan. Setelah dihapus, semua data absensi juga akan hilang.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-danger-button type="submit"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?')">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    @endif
</section>