<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Akun Admin Utama Compro — SPEC §16.1
    |--------------------------------------------------------------------------
    | ADMIN_EMAIL dan ADMIN_PASSWORD wajib diatur via environment di produksi.
    */

    'name' => env('ADMIN_NAME', 'Administrator Destinara'),
    'email' => env('ADMIN_EMAIL'),
    'password' => env('ADMIN_PASSWORD'),

];
