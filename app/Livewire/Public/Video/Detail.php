<?php

namespace App\Livewire\Public\Video;

use Livewire\Component;
use App\Models\Core\Video;

class Detail extends Component
{
    public $data;
    public function render()
    {
        return view('livewire.public.video.detail')->layoutData(['title' => $this->data->title]);
    }

    public function mount($slug)
    {
        $data = Video::where('slug', $slug)->first();
        if ($data) {
            $this->data = $data;
        } else {
            abort(404);
        }
    }
}
