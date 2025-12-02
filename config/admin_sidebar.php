<?php

return [
    [
        'label' => 'Menu utama',
        'type' => 'menu-title',
        'roles' => ['admin', 'pengelola_pendaftaran', 'bendahara']
    ],
    [
        'label' => 'Dashboard',
        'type' => 'menu',
        'icon' => 'home',
        'route_name' => 'admin.dashboard.index',
        'roles' => ['admin', 'pengelola_pendaftaran', 'bendahara']
    ],
    [
        'label' => 'Manajemen akun',
        'type' => 'menu-title',
        'roles' => ['admin']
    ],
    [
        'label' => 'Akun pengguna',
        'icon' => 'users',
        'type' => 'menu',
        'route_name' => 'admin.users.index',
        'roles' => ['admin']
    ],
    [
        'label' => 'Manajemen keuangan',
        'type' => 'menu-title',
        'roles' => ['bendahara']
    ],
    [
        'label' => 'Rekening',
        'icon' => 'banknote',
        'type' => 'menu',
        'route_name' => 'admin.rekening.index',
        'roles' => ['bendahara']
    ],
    [
        'label' => 'Pembayaran pelatihan',
        'icon' => 'coins',
        'type' => 'menu',
        'route_name' => 'admin.pembayaran-pelatihan.index',
        'roles' => ['bendahara']
    ],
    [
        'label' => 'Manajemen Pelatihan',
        'type' => 'menu-title',
        'roles' => ['admin', 'pengelola_pendaftaran']
    ],
    [
        'label' => 'Daftar pelatihan',
        'icon' => 'file-text',
        'type' => 'menu',
        'route_name' => 'admin.pelatihan.index',
        'roles' => ['admin']
    ],
    [
        'label' => 'Gelombang pelatihan',
        'icon' => 'calendar-sync',
        'type' => 'menu',
        'route_name' => 'admin.gelombang-pelatihan.index',
        'roles' => ['admin']
    ],
    [
        'label' => 'Pendaftaran pelatihan',
        'icon' => 'file-input',
        'type' => 'menu',
        'route_name' => 'admin.pendaftaran-pelatihan.index',
        'roles' => ['admin', 'pengelola_pendaftaran']
    ],
    [
        'label' => 'Pelatihan peserta',
        'icon' => 'user-round-pen',
        'type' => 'menu',
        'route_name' => 'admin.pelatihan-peserta.index',
        'roles' => ['admin']
    ],
    [
        'label' => 'Manajemen kontrak kerja',
        'type' => 'menu-title',
        'roles' => ['admin', 'pengelola_pendaftaran']
    ],
    [
        'label' => 'Daftar Kontrak kerja',
        'icon' => 'file-text',
        'type' => 'menu',
        'route_name' => 'admin.kontrak-kerja.index',
        'roles' => ['admin']
    ],
    [
        'label' => 'Pengajuan kontrak kerja',
        'icon' => 'file-input',
        'type' => 'menu',
        'route_name' => 'admin.pengajuan-kontrak-kerja.index',
        'roles' => ['admin', 'pengelola_pendaftaran']
    ],
    [
        'label' => 'Kontrak kerja peserta',
        'icon' => 'file-user',
        'type' => 'menu',
        'route_name' => 'admin.kontrak-kerja-peserta.index',
        'roles' => ['admin']
    ],
];
