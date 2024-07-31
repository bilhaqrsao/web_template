<?php

namespace App\Livewire\Public\Pengumuman;

use App\Models\Core\Pengumuman;
use Livewire\Component;

class Index extends Component
{
    public $limit = 5;
    public function render()
    {
        $pengumumans = Pengumuman::where('status', 'Publish')->latest()->paginate($this->limit);
        return view('livewire.public.pengumuman.index',[
            'pengumumans' => $pengumumans,
        ])->layoutData([
            'title' => 'Pengumuman',
        ]);
    }
}
