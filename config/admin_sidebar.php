<?php

return [
    [
        'label' => 'Menu utama',
        'type' => 'menu-title',
        'roles' => ['admin']
    ],
    [
        'label' => 'Dashboard',
        'type' => 'menu',
        'icon' => 'home',
        'route_name' => 'admin.dashboard.index',
        'roles' => ['admin']
    ],
    [
        'label' => 'Manajemen Pendaftaran',
        'type' => 'menu-title',
        'roles' => ['admin']
    ],
    [
        'label' => 'Pendaftaran',
        'icon' => 'home',
        'type' => 'file',
        'route_name' => 'admin.dashboard.index',
        'roles' => ['admin']
    ],
];
