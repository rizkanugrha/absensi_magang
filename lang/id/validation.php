<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Kolom :attribute harus diterima.',
    'active_url' => 'Kolom :attribute bukan URL yang valid.',
    'after' => 'Kolom :attribute harus berisi tanggal setelah :date.',
    'after_or_equal' => 'Kolom :attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha' => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Kolom :attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'array' => 'Kolom :attribute harus berupa sebuah array.',
    'before' => 'Kolom :attribute harus berisi tanggal sebelum :date.',
    'before_or_equal' => 'Kolom :attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => 'Kolom :attribute harus bernilai antara :min sampai :max.',
        'file' => 'Kolom :attribute harus berukuran antara :min sampai :max kilobytes.',
        'string' => 'Kolom :attribute harus berisi antara :min sampai :max karakter.',
        'array' => 'Kolom :attribute harus memiliki antara :min sampai :max item.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai true atau false.',
    'confirmed' => 'Konfirmasi Kolom :attribute tidak cocok.',
    'date' => 'Kolom :attribute bukan tanggal yang valid.',
    'date_format' => 'Kolom :attribute tidak cocok dengan format :format.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus berupa :digits digit.',
    'digits_between' => 'Kolom :attribute harus terdiri dari :min sampai :max digit.',
    'dimensions' => 'Kolom :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Kolom :attribute memiliki nilai yang duplikat.',
    'email' => 'Kolom :attribute harus berupa alamat surel yang valid.',
    'exists' => 'Kolom :attribute yang dipilih tidak valid.',
    'file' => 'Kolom :attribute harus berupa sebuah file.',
    'filled' => 'Kolom :attribute wajib diisi.',
    'image' => 'Kolom :attribute harus berupa gambar.',
    'in' => 'Kolom :attribute yang dipilih tidak valid.',
    'in_array' => 'Kolom :attribute tidak ada di dalam :other.',
    'integer' => 'Kolom :attribute harus berupa bilangan bulat.',
    'ip' => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'json' => 'Kolom :attribute harus berupa string JSON yang valid.',
    'max' => [
        'numeric' => 'Kolom :attribute maskimal bernilai :max.',
        'file' => 'Kolom :attribute maksimal berukuran :max kilobytes.',
        'string' => 'Kolom :attribute maksimal berisi :max karakter.',
        'array' => 'Kolom :attribute maksimal memiliki :max item.',
    ],
    'mimes' => 'Kolom :attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => 'Kolom :attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'numeric' => 'Kolom :attribute minimal bernilai :min.',
        'file' => 'Kolom :attribute minimal berukuran :min kilobytes.',
        'string' => 'Kolom :attribute minimal berisi :min karakter.',
        'array' => 'Kolom :attribute minimal memiliki :min item.',
    ],
    'not_in' => 'Kolom :attribute yang dipilih tidak valid.',
    'not_regex' => 'Format Kolom :attribute tidak valid.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'present' => 'Kolom :attribute wajib ada.',
    'regex' => 'Format Kolom :attribute tidak valid.',
    'required' => 'Kolom :attribute wajib diisi.',
    'required_if' => 'Kolom :attribute wajib diisi bila :other adalah :value.',
    'required_unless' => 'Kolom :attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with' => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_with_all' => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_without' => 'Kolom :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Kolom :attribute wajib diisi bila tidak terdapat satupun :values.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'size' => [
        'numeric' => 'Kolom :attribute harus berukuran :size.',
        'file' => 'Kolom :attribute harus berukuran :size kilobytes.',
        'string' => 'Kolom :attribute harus berukuran :size karakter.',
        'array' => 'Kolom :attribute harus mengandung :size item.',
    ],
    'string' => 'Kolom :attribute harus berupa string.',
    'timezone' => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => 'Kolom :attribute sudah digunakan.',
    'uploaded' => 'Kolom :attribute gagal diunggah.',
    'url' => 'Format Kolom :attribute tidak valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'password' => [
            'min' => 'Kolom :attribute minimal harus 8 karakter.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more readable such as "E-Mail Address" instead
    | of "email". This simply helps us make messages more expressive.
    |
    */

    'attributes' => [
        'name' => 'Nama',
        'email' => 'Email',
        'password' => 'Kata Sandi',
        'password_confirmation' => 'Konfirmasi Kata Sandi',
        'role' => 'Peran',
        // Tambahkan atribut lain yang Anda gunakan di form Tambah Peserta
        'tanggal_masuk' => 'Tanggal Masuk',
        'tanggal_keluar' => 'Tanggal Keluar',
    ],
];