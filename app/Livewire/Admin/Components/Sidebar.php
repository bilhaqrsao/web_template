<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public function render()
    {
        $menus = [
            [
                'hasRole' => 'admin,developer,super-admin,user',
                'name' => 'Dashboard',
                'icon' => 'bi bi-house',
                'active' => request()->routeIs('admin.dashboard'),
                'route' => 'admin.dashboard',
                'space' => false,
                'child' => [],
            ],
            [
                'hasRole' => 'admin,user',
                'name' => 'Sales',
                'icon' => 'bi bi-cash',
                'active' => request()->routeIs('admin.sales') || request()->routeIs('admin.sales.create') || request()->routeIs('admin.sales.edit'),
                'route' => 'admin.sales',
                'space' => true,
                'child' => [
                    [
                        'hasRole' => 'admin,user',
                        'name' => 'Daftar Penjualan',
                        'icon' => 'bi bi-cash',
                        'active' => request()->routeIs('admin.sales'),
                        'link' => 'admin.sales',
                    ],
                ],
            ],
            // [
            //     'hasRole' => 'admin',
            //     'name' => 'Inventory',
            //     'icon' => 'bi bi-archive',
            //     'active' => request()->routeIs('admin.inventory'),
            //     'route' => 'admin.inventory',
            //     'space' => false,
            //     'child' => [],
            // ],
            [
                'hasRole' => 'developer,super-admin,admin',
                'name' => 'Store Management',
                'icon' => 'bi bi-shop',
                'active' => request()->routeIs('admin.store') || request()->routeIs('admin.list-store') || request()->routeIs('admin.product'),
                'route' => 'admin.store',
                'space' => true,
                'child' => [
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Daftar Toko',
                        'icon' => 'bi bi-shop',
                        'active' => request()->routeIs('admin.list-store'),
                        'link' => 'admin.list-store',
                    ],
                    [
                        'hasRole' => 'admin',
                        'name' => 'Toko Saya',
                        'icon' => 'bi bi-shop',
                        'active' => request()->routeIs('admin.store'),
                        'link' => 'admin.store',
                    ],
                    [
                        'hasRole' => 'admin',
                        'name' => 'Produk',
                        'icon' => 'bi bi-box',
                        'active' => request()->routeIs('admin.product'),
                        'link' => 'admin.product',
                    ],
                ],
            ],
            [
                'hasRole' => 'developer,super-admin',
                'name' => 'User Management',
                'icon' => 'bi bi-people',
                'active' => request()->routeIs('admin.users'),
                'route' => '',
                'child' => [
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Users',
                        'icon' => 'bi bi-people',
                        'active' => request()->routeIs('admin.users'),
                        'link' => 'admin.users',
                    ],
                ],
            ]
        ];


        // Ambil peran pengguna saat ini
        $userRoles = auth()->user()->getRoleNames()->toArray();

        // Filter menu berdasarkan peran pengguna
        $filteredMenus = array_filter($menus, function($menu) use ($userRoles) {
            $menuRoles = explode(',', $menu['hasRole']);
            foreach ($menuRoles as $role) {
                if (in_array($role, $userRoles)) {
                    return true;
                }
            }
            return false;
        });

        $user = Auth::user();
        return view('livewire.admin.components.sidebar', [
            'menus' => $filteredMenus,
            'userRoles' => $userRoles,
            'user' => $user,
        ]);


    }


}
