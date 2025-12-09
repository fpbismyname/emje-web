<?php

return [
    [
        'label' => 'Dashboard',
        'icon' => 'home',
        'type' => 'menu',
        'route_name' => 'client.dashboard.index',
        'roles' => ['peserta']
    ],
    [
        'label' => 'Pelatihan',
        'icon' => 'file-input',
        'type' => 'dropdown',
        'roles' => ['peserta'],
        'route_name' => 'client.pelatihan.',
        'children' => [
            [
                'label' => 'Daftar pelatihan',
                'icon' => 'file-text',
                'route_name' => 'daftar-pelatihan.index',
                'roles' => ['peserta']
            ],
            [
                'label' => 'Pendaftaran pelatihan',
                'icon' => 'file-user',
                'route_name' => 'pendaftaran-pelatihan.index',
                'roles' => ['peserta']
            ],
            [
                'label' => 'Pelatihan diikuti',
                'icon' => 'user',
                'route_name' => 'pelatihan-diikuti.index',
                'roles' => ['peserta']
            ],
        ]
    ],
    [
        'label' => 'Kontrak kerja',
        'icon' => 'file-input',
        'type' => 'dropdown',
        'roles' => ['peserta'],
        'route_name' => 'client.kontrak-kerja.',
        'children' => [
            [
                'label' => 'Daftar kontrak kerja',
                'icon' => 'file-text',
                'route_name' => 'daftar-kontrak-kerja.index',
                'roles' => ['peserta']
            ],
            [
                'label' => 'Pengajuan kontrak kerja',
                'icon' => 'file-user',
                'route_name' => 'pengajuan-kontrak-kerja.index',
                'roles' => ['peserta']
            ],
            [
                'label' => 'Kontrak kerja diikuti',
                'icon' => 'user',
                'route_name' => 'kontrak-kerja-diikuti.index',
                'roles' => ['peserta']
            ],
        ]
    ]
];
