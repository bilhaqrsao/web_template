<?php

namespace App\Livewire\Public\Page;

use Livewire\Component;
use App\Models\Core\Page;
use App\Models\Utility\Visitor;

class Detail extends Component
{
    public $page;
    public function render()
    {
        return view('livewire.public.page.detail')->layoutData(['title' => 'Beranda']);
    }

    public function mount($slug)
    {
        // Cari halaman berdasarkan
        $data = Page::where('slug', $slug)->first();
        if ($data) {
            $this->page = $data;

            // check ip address
            $visitor = Visitor::where('ip_address', request()->ip())->first();
            if ($visitor){
                $this->page->view = $this->page->view + 1;
                $this->page->save();
            }
        } else {
            abort(404);
        }
    }

    public function storeLike()
    {

    }
}
