<?php

namespace App\Livewire\Admin\Components;

use App\Models\Utility\IdentityWeb;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    public function render()
    {
        $menus = [
            [
                'hasRole' => 'admin,developer,super-admin',
                'name' => 'Dashboard',
                'icon' => 'bi bi-house',
                'active' => request()->routeIs('admin.dashboard'),
                'route' => 'admin.dashboard',
                'space' => false,
                'child' => [],
            ],
            [
                'hasRole' => 'admin,developer,super-admin',
                'name' => 'Article',
                'icon' => 'bi bi-newspaper',
                'active' => request()->routeIs('admin.articles') || request()->routeIs('admin.articles.create') || request()->routeIs('admin.articles.edit'),
                'route' => 'admin.articles',
                'space' => false,
                'child' => [],
            ],
            [
                'hasRole' => 'admin,developer,super-admin',
                'name' => 'Page',
                'icon' => 'bi bi-file-earmark-text',
                'active' => request()->routeIs('admin.pages') || request()->routeIs('admin.pages.create') || request()->routeIs('admin.pages.edit'),
                'route' => 'admin.pages',
                'space' => false,
                'child' => [],
            ],
            [
                'hasRole' => 'admin,developer,super-admin',
                'name' => 'Pengumuman',
                'icon' => 'bi bi-megaphone',
                'active' => request()->routeIs('admin.pengumumans') || request()->routeIs('admin.pengumumans.create') || request()->routeIs('admin.pengumumans.edit'),
                'route' => 'admin.pengumumans',
                'space' => false,
                'child' => [],
            ],
            [
                'hasRole' => 'admin,developer,super-admin',
                'name' => 'Link Terkait',
                'icon' => 'bi bi-share',
                'active' => request()->routeIs('admin.link-terkaits'),
                'route' => 'admin.link-terkaits',
                'space' => false,
                'child' => [],
            ],
            [
                'hasRole' => 'admin,developer,super-admin',
                'name' => 'Kritik & Saran',
                'icon' => 'bi bi-flag',
                'active' => request()->routeIs('admin.feedback'),
                'route' => 'admin.feedback',
                'space' => false,
                'child' => [],
            ],
            [
                'hasRole' => 'developer,super-admin',
                'name' => 'Media',
                'icon' => 'bi bi-collection-play-fill',
                'active' => request()->routeIs('admin.galleries') || request()->routeIs('admin.videos') || request()->routeIs('admin.banners') || request()->routeIs('admin.berkas'),
                'route' => '',
                'child' => [
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Galeri',
                        'icon' => 'bi bi-card-image',
                        'active' => request()->routeIs('admin.galleries'),
                        'link' => 'admin.galleries',
                    ],
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Video',
                        'icon' => 'bi bi-card-image',
                        'active' => request()->routeIs('admin.videos'),
                        'link' => 'admin.videos',
                    ],
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Banner',
                        'icon' => 'bi bi-card-image',
                        'active' => request()->routeIs('admin.banners'),
                        'link' => 'admin.banners',
                    ],
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Berkas',
                        'icon' => 'bi bi-card-image',
                        'active' => request()->routeIs('admin.berkas'),
                        'link' => 'admin.berkas',
                    ],
                ],
            ],
            [
                'hasRole' => 'developer,super-admin',
                'name' => 'Setting',
                'icon' => 'bi bi-gear',
                'active' => request()->routeIs('admin.users') || request()->routeIs('admin.identity-web') || request()->routeIs('admin.menus'),
                'route' => '',
                'child' => [
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Users',
                        'icon' => 'bi bi-people',
                        'active' => request()->routeIs('admin.users'),
                        'link' => 'admin.users',
                    ],
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Menu',
                        'icon' => 'bi bi-list',
                        'active' => request()->routeIs('admin.menus'),
                        'link' => 'admin.menus',
                    ],
                    [
                        'hasRole' => 'developer,super-admin',
                        'name' => 'Identitas Website',
                        'icon' => 'bi bi-globe',
                        'active' => request()->routeIs('admin.identity-web'),
                        'link' => 'admin.identity-web',
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

        $identitas = IdentityWeb::first();
        return view('livewire.admin.components.sidebar', [
            'menus' => $filteredMenus,
            'userRoles' => $userRoles,
            'user' => $user,
            'identitas' => $identitas,
        ]);


    }


}
