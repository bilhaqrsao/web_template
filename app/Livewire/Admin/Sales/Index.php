<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use App\Models\Core\Sales;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination,LivewireAlert;

    public $data, $search;

    public function getListeners()
    {
        return [
            'deleteSales' => 'deleteSales',
        ];
    }

    public function render()
    {
        $datas = Sales::where('store_id', auth()->user()->store_id)->when($this->search, function($query){
            $query->where('invoice_number', 'like', '%'.$this->search.'%');
        })->orderBy('id', 'desc')->paginate(10);

        return view('livewire.admin.sales.index',[
            'datas' => $datas
        ])->layout('components.admin_layouts.app');
    }

    public function destroy($id)
    {
        $this->confirm('Are you sure you want to delete?', [
            'toast' => false,
            'text' => '',
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'deleteSales',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = Sales::find($id);
    }

    public function deleteSales()
    {
        // delete semua salesItem
        $this->data->salesItems()->delete();
        $this->data->delete();
        $this->alert('success', 'Sales has been deleted successfully');
    }
}
