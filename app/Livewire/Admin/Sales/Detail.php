<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use Barryvdh\DomPDF\PDF;
use App\Models\Core\Sales;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Detail extends Component
{
    use LivewireAlert;
    public $data;
    public function render()
    {
        return view('livewire.admin.sales.detail')->layout('components.admin_layouts.app');
    }

    public function mount($invoice_number)
    {
        $this->data = Sales::where('invoice_number', $invoice_number)->with('salesItems')->with('store')->with('user')->first();
    }

    public function updatePaymentStatus($id)
    {
        $sales = Sales::find($id);
        if ($sales->payment_status == 'unpaid') {
            $sales->payment_status = 'paid';
            $sales->save();
            $this->flash('success', 'Pembayaran Berhasil', [], route('admin.sales.detail', $sales->invoice_number));
        }
    }

    public function print($id)
    {
        $sales = Sales::find($id);
        $pdf = PDF::loadView('admin.sales.detail', compact('sales'));
        return $pdf->stream();
    }
}
