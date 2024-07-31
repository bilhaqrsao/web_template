<?php

namespace App\Livewire\Public\Components;

use App\Models\Core\Article;
use Livewire\Component;
use App\Models\Utility\Tag;
use App\Models\Core\Pengumuman;

class Sidebar extends Component
{
    public function render()
    {
        $tags = Tag::all();
        $pengumumans = Pengumuman::latest()->take(2)->get();
        $beritas = Article::latest()->take(5)->get();
        return view('livewire.public.components.sidebar',[
            'tags' => $tags,
            'pengumumans' => $pengumumans,
            'beritas' => $beritas
        ]);
    }
}
