<?php

namespace App\Livewire\Public\Video;

use App\Models\Core\Video;
use App\Models\Utility\IdentityWeb;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $identitas = IdentityWeb::first();
        $datas = Video::where('status', 'Publish')->latest()->paginate(12);
        return view('livewire.public.video.index',[
            'identitas' => $identitas,
            'datas' => $datas
        ])->layoutData([
            'title' => 'Video'
        ]);
    }
}
