<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;

class MobileMenu extends Component
{
    public function render()
    {
        $menus = [
            [
                'hasRole' => 'admin,developer,super-admin,user',
                'name' => 'Dashboard',
                'icon' => 'home',
                'active' => request()->routeIs('admin.dashboard'),
                'route' => 'admin.dashboard',
                'space' => false,
                'child' => [],
            ],
            [
                'hasRole' => 'developer,super-admin,admin',
                'name' => 'Store Management',
                'icon' => 'store',
                'active' => request()->routeIs('admin.store') || request()->routeIs('admin.list-store') || request()->routeIs('admin.store.create') || request()->routeIs('admin.store.edit'),
                'route' => 'admin.store',
                'space' => true,
                'child' => [
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Daftar Toko',
                        'icon' => 'list',
                        'active' => request()->routeIs('admin.list-store') || request()->routeIs('admin.store.create') || request()->routeIs('admin.store.edit'),
                        'link' => 'admin.list-store',
                    ],
                    [
                        'hasRole' => 'developer,super-admin,admin',
                        'name' => 'Toko Saya',
                        'icon' => 'store',
                        'active' => request()->routeIs('admin.store') || request()->routeIs('admin.store.edit'),
                        'link' => 'admin.store',
                    ],
                ],
            ],
            [
                'hasRole' => 'developer,super-admin',
                'name' => 'User Management',
                'icon' => 'users',
                'active' => request()->routeIs('admin.users') || request()->routeIs('admin.users.create') || request()->routeIs('admin.users.edit'),
                'route' => '',
                'child' => [
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Users',
                        'icon' => 'user',
                        'active' => request()->routeIs('admin.users') || request()->routeIs('admin.users.edit'),
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
        return view('livewire.admin.components.mobile-menu',[
            'menus' => $filteredMenus,
            'userRoles' => $userRoles,
        ]);
    }
}
