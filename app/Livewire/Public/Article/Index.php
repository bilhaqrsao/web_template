<?php

namespace App\Livewire\Public\Article;

use Livewire\Component;
use App\Models\Core\Article;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $limit = 5;
    public function render()
    {
        $datas = Article::latest()->paginate($this->limit);
        return view('livewire.public.article.index',[
            'datas' => $datas
        ])->layoutData(['title' => 'Article List']);
    }
}
