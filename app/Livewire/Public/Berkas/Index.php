<?php

namespace App\Livewire\Public\Berkas;

use App\Models\Core\Berkas;
use Livewire\Component;

class Index extends Component
{
    public $url = 'https://cdn.oganilirkab.go.id/storage/';

    public function render()
    {
        $datas = Berkas::where('status', 'Publish')->latest()->get();
        return view('livewire.public.berkas.index',[
            'datas' => $datas
        ])->layoutData([
            'title' => 'Berkas'
        ]);
    }

    public function countView($id)
    {
        $data = Berkas::find($id);
        $data->increment('download');
    }
}
