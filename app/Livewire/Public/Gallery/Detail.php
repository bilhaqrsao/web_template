<?php

namespace App\Livewire\Public\Gallery;

use Livewire\Component;
use App\Models\Core\Gallery;

class Detail extends Component
{
    public $slug, $data;
    public function render()
    {
        return view('livewire.public.gallery.detail')->layoutData(['title' => $this->data->title]);
    }

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->data = Gallery::where('slug', $slug)->first();
    }
}
