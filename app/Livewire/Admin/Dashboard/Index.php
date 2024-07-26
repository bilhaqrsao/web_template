<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Core\Article;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        // article
        // jumlah article
        $sumArticle = Article::count();
        return view('livewire.admin.dashboard.index')->layout('components.admin_layouts.app')->layoutData([
            'title' => 'Dashboard',
        ]);
    }
}
