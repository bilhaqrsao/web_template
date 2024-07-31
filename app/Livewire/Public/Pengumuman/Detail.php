<?php

namespace App\Livewire\Public\Pengumuman;

use Livewire\Component;
use App\Models\Core\Pengumuman;
use App\Models\Utility\PivotTags;

class Detail extends Component
{
    public $slug, $data;
    public function mount($slug)
    {
        $this->slug = $slug;
        $this->data = Pengumuman::where('slug', $this->slug)->where('status', 'Publish')->first();
        if (!$this->data) {
            return abort(404);
        }
    }


    public function render()
    {
        // call tags from pivot_tags
        $tags = PivotTags::where('taggable_id', $this->data->id)->where('taggable_type', 'pengumuman')->with('getTags')->get();
        // dd($tags);
        return view('livewire.public.pengumuman.detail',[
            'tags' => $tags,
        ])->layoutData([
            'title' => $this->data->title,
        ]);
    }

    public function previous()
    {
        $previous = Pengumuman::where('id', '<', $this->data->id)->latest()->first();
        if ($previous) {
            return redirect()->route('pengumuman.detail', $previous->slug);
        }
    }

    public function next()
    {
        $next = Pengumuman::where('id', '>', $this->data->id)->latest()->first();
        if ($next) {
            return redirect()->route('pengumuman.detail', $next->slug);
        }
    }
}
