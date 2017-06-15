<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    |  following language lines contain  default error messages used by
    |  validator class. Some of se rules memiliki multiple versions such
    | as  size rules. Feel free to tweak each of se messages here.
    |
    */

    'accepted'             => ':attribute harus diterima.',
    'active_url'           => ':attribute bukan URL yang valid.',
    'after'                => ':attribute harus sehari setelah :date.',
    'after_or_equal'       => ':attribute harus sehari setelah atau sama dengan :date.',
    'alpha'                => ':attribute hanya boleh mengandung huruf alfabet.',
    'alpha_dash'           => ':attribute hanya boleh mengandung huruf dan angka dan dash.',
    'alpha_num'            => ':attribute hanya boleh mengandung huruf dan angka.',
    'array'                => ':attribute harus berupa array',
    'before'               => ':attribute harus sehari sebelum :date.',
    'before_or_equal'      => ':attribute harus sehari sebelum atau sama dengan :date.',
    'diantara'              => [
        'numeric' => ' :attribute memiliki diantara :min dan :max.',
        'file'    => ' :attribute memiliki diantara :min dan :max kilobytes.',
        'string'  => ' :attribute memiliki diantara :min dan :max characters.',
        'array'   => ' :attribute memiliki diantara :min dan :max items.',
    ],
    'boolean'              => ' :attribute field memiliki benar atau salah.',
    'confirmed'            => ' :attribute konfirmasi tidak sesuai.',
    'date'                 => ' :attribute bukan tanggal yang valid.',
    'date_format'          => ' :attribute tidak sesuai format :format.',
    'different'            => ' :attribute and :or memiliki perbedaan.',
    'digits'               => ' :attribute memiliki :digits digits.',
    'digits_between'       => ' :attribute memiliki nilai diantara :min and :max digits.',
    'dimensions'           => ' :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct'             => ' :attribute memiliki nilai yang sama.',
    'email'                => ' :attribute memiliki email yang tidak valid.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'file'                 => ' :attribute harus berupa file.',
    'filled'               => ' :attribute harus diisi.',
    'image'                => ' :attribute harus berupa gambar.',
    'in'                   => ':attribute yang dipilih tidak valid',
    'in_array'             => ' :attribute tidak ada di :or.',
    'integer'              => ' :attribute harus memiliki angka.',
    'ip'                   => ' :attribute harus memiliki alamat IP yang valid.',
    'json'                 => ' :attribute harus memiliki karakter JSON.',
    'max'                  => [
        'numeric' => ' :attribute tidak boleh lebih besar dari :max.',
        'file'    => ' :attribute tidak boleh lebih besar dari :max kilobytes.',
        'string'  => ' :attribute tidak boleh lebih besar dari :max characters.',
        'array'   => ' :attribute tidak boleh memiliki nilai yang lebih besar dari :max items.',
    ],
    'mimes'                => ' :attribute harus memiliki tipe file: :values.',
    'mimetypes'            => ' :attribute harus memiliki tipe file: :values.',
    'min'                  => [
        'numeric' => ' :attribute harus memiliki setidaknya :min.',
        'file'    => ' :attribute harus memiliki setidaknya :min kilobytes.',
        'string'  => ' :attribute harus memiliki setidaknya :min karakter.',
        'array'   => ' :attribute harus memiliki setidaknya :min data.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'numeric'              => ' :attribute harus memiliki angka.',
    'present'              => ' :attribute harus ada.',
    'regex'                => ' :attribute tidak memiliki format yang valid.',
    'required'             => ' :attribute harus diisi.',
    'required_if'          => ' :attribute field harus diisi ketika :or sama dengan :value.',
    'required_unless'      => ' :attribute field harus diisi kecuali :or ada di dalam :values.',
    'required_with'        => ' :attribute field harus diisi ketika :values diisi.',
    'required_with_all'    => ' :attribute field harus diisi ketika :values diisi.',
    'required_without'     => ' :attribute field harus diisi ketika :values tidak diisi.',
    'required_without_all' => ' :attribute field harus diisi ketika tidak ada :values diisi.',
    'same'                 => ' :attribute dan :or memili nilai yang sama',
    'size'                 => [
        'numeric' => ' :attribute harus memiliki :size.',
        'file'    => ' :attribute harus memiliki :size kilobytes.',
        'string'  => ' :attribute harus memiliki :size characters.',
        'array'   => ' :attribute harus memiliki contain :size items.',
    ],
    'string'               => ' :attribute harus memiliki a huruf alfabet.',
    'timezone'             => ' :attribute harus memiliki waktu yang valid.',
    'unique'               => ' :attribute sudah terdaftar.',
    'uploaded'             => ' :attribute gagal diunggahº.',
    'url'                  => ' :attribute mempunyai format yang tidak valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using
    | convention "attribute.rule" to name  lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    |  following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
