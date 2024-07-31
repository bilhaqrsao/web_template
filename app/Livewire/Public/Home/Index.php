<?php

namespace App\Livewire\Public\Home;

use Livewire\Component;
use App\Models\Core\Video;
use App\Models\Core\Banner;
use App\Models\Core\Article;
use App\Models\Core\Gallery;
use App\Models\Core\LinkTerkait;
use App\Models\Core\Pengumuman;

class Index extends Component
{
    public function render()
    {
        $banners = Banner::get();
        $pengumumans = Pengumuman::where('status', 'Publish')->latest()->take(3)->get();
        $videos = Video::where('status', 'Publish')->latest()->get();
        $galleries = Gallery::where('status', 'Publish')->latest()->take(10)->get();
        $articles = Article::where('status', 'Publish')->latest()->take(6)->get();
        // get 3 random article
        $randomArticles = Article::where('status', 'Publish')->inRandomOrder()->take(3)->get();
        $linkeds = LinkTerkait::latest()->get();
        return view('livewire.public.home.index',[
            'banners' => $banners,
            'pengumumans' => $pengumumans,
            'videos' => $videos,
            'galleries' => $galleries,
            'articles' => $articles,
            'randomArticles' => $randomArticles,
            'linkeds' => $linkeds
        ])->layoutData(['title' => 'Beranda']);
    }
}
