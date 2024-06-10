<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Header extends Component
{
    use LivewireAlert;
    public $searchQuery = '';
    public $sidebarPages;
    public $searchResults = [];

    public function mount()
    {
        // Ambil daftar halaman dari session
        $this->sidebarPages = Session::get('sidebarPages', []);
    }

    public function render()
    {
        $user = auth()->user();
        return view('livewire.admin.components.header',[
            'user' => $user,
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function handleSearch()
    {
        // Ambil daftar halaman yang diterima dari session
        $pages = $this->sidebarPages;

        // Reset hasil pencarian
        $this->searchResults = [];

        // Loop melalui setiap halaman
        foreach ($pages as $page) {
            // Jika menu memiliki child
            if (!empty($page['child'])) {
                // Loop melalui setiap child
                foreach ($page['child'] as $child) {
                    // Periksa apakah nama child cocok dengan query pencarian
                    if (str_contains(strtolower($child['name']), strtolower($this->searchQuery))) {
                        // Jika cocok, tambahkan ke hasil pencarian
                        $this->searchResults[] = [
                            'name' => $child['name'],
                            'link' => $child['link'],
                        ];
                    }
                }
            } else {
                // Jika menu tidak memiliki child
                // Periksa apakah nama menu cocok dengan query pencarian
                if (str_contains(strtolower($page['name']), strtolower($this->searchQuery))) {
                    // Jika cocok, tambahkan ke hasil pencarian
                    $this->searchResults[] = [
                        'name' => $page['name'],
                        'link' => route($page['route']),
                    ];
                }
            }
        }
    }

    public function leaveImpersonation()
    {
        Auth::user()->leaveImpersonation();
        $this->flash('success', 'You have successfully left impersonation mode.',[], route('admin.dashboard'));
    }

}
