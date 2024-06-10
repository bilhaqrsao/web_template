<?php

namespace App\Livewire\Admin\Store;

use Livewire\Component;
use App\Models\Core\Store;
use App\Models\Core\Product;
use App\Models\LogActivity\LogStore;

class Index extends Component
{
    public function render()
    {
        // check store_id user yang login
        $data = Store::where('id', auth()->user()->store_id)->first();

        // log activity
        $activities = LogStore::where('store_id', auth()->user()->store_id)->orderBy('id', 'desc')->get();

        $products = Product::where('store_id', auth()->user()->store_id)->get();

        return view('livewire.admin.store.index',[
            'data' => $data,
            'products' => $products,
            'activities' => $activities
        ])->layout('components.admin_layouts.app');
    }
}
