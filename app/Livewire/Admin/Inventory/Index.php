<?php

namespace App\Livewire\Admin\Inventory;

use Livewire\Component;
use App\Models\Core\Product;
use Livewire\WithPagination;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.inventory.index')->layout('components.admin_layouts.app');
    }
}
