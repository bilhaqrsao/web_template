<?php

namespace App\Livewire\Public\Components;

use App\Models\Utility\IdentityWeb;
use App\Models\Utility\Menu;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        $identitas = IdentityWeb::first();
        $menus = Menu::where('status', 'Publish')
            ->where('parent_id', 0)
            ->orderBy('sort')
            ->with('children')
            ->get();
        return view('livewire.public.components.header',[
            'identitas' => $identitas,
            'menus' => $menus
        ])->layoutData(['title' => 'Header']);
    }
}
