<?php

return [
    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'numeric' => ':attribute harus berupa angka.',
    'array' => ':attribute harus berupa daftar dengan format yang sesuai.',
    'date_format' => ':attribute harus berupa tanggal yang valid dengan format :format.',
    'after_or_equal' => ':attribute harus sama dengan atau setelah :date.',
    'in' => ':attribute yang dipilih tidak valid.',
    'regex' => ':attribute harus menggunakan angka dan maksimal dua desimal dengan tanda titik.',
    'min' => [
        'numeric' => ':attribute minimal :min.',
        'array' => ':attribute harus memiliki minimal :min item.',
        'string' => ':attribute minimal :min karakter.',
    ],
    'max' => [
        'numeric' => ':attribute maksimal :max.',
        'array' => ':attribute maksimal :max item.',
        'string' => ':attribute maksimal :max karakter.',
    ],
    'attributes' => ['invoice_date' => 'tanggal invoice'],
];
