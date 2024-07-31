<?php

namespace App\Livewire\Public\Gallery;

use App\Models\Core\Gallery;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $limit = 12;
    public function render()
    {
        $datas = Gallery::latest()->paginate($this->limit);
        return view('livewire.public.gallery.index',[
            'datas' => $datas
        ])->layoutData(['title' => 'Gallery']);
    }
}
