<?php

namespace App\Livewire\Public\Components;

use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        return view('livewire.public.components.header');
    }

    public function store()
    {
        dd('store');
    }
}
