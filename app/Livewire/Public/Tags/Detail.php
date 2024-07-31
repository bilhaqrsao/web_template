<?php

namespace App\Livewire\Public\Tags;

use App\Models\Core\Article;
use App\Models\Utility\PivotTags;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Utility\Tag;

class Detail extends Component
{
    use WithPagination;

    public $tag;
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
        // $this->tag = Tag::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        // dd($this->slug);
        // $articles = $this->tag->articles()->with('tags','tagable')->get();
        // $datas = Article::with('tags','getTags')->first();

        $tags = PivotTags::with('getArticles','getTags')->whereHas('getTags', function($q){
            $q->where('name', $this->slug);
        })->groupBy('taggable_id')->get();

        // dd($tags);
        $tagsPengumuman = PivotTags::with('getPengumumans','getTags')->whereHas('getTags', function($q){
            $q->where('name', $this->slug);
        })->where('taggable_type', 'pengumuman')->groupBy('taggable_id')->get();

        // dd($tagsPengumuman);

        return view('livewire.public.tags.detail', [
            'tags' => $tags,
            'tagsPengumuman' => $tagsPengumuman,
        ])->layoutData([
            'title' => 'Detail Tag - ' . $this->slug,
        ]);
    }
}


