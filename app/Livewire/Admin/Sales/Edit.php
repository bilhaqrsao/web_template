<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use App\Models\Core\Sales;
use App\Models\Core\Product;
use App\Models\Core\SalesItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;

    public $sale;
    public $invoice_number;
    public $sale_date;
    public $total_amount;
    public $note;
    public $discount;

    public $products = [];

    public function mount($id)
    {
        // Mendapatkan data penjualan yang akan diedit
        $this->sale = Sales::findOrFail($id);

        // Mengisi data penjualan ke dalam properti
        $this->invoice_number = $this->sale->invoice_number;
        $this->sale_date = $this->sale->sale_date;
        $this->total_amount = $this->sale->total_amount;
        $this->note = $this->sale->note;
        $this->discount = $this->sale->discount;

        // Mengisi data produk yang terkait penjualan
        $salesItems = SalesItems::where('sale_id', $this->sale->id)->get();
        foreach ($salesItems as $item) {
            $this->products[] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ];
        }
    }

    public function render()
    {
        // Mengambil pilihan produk dari toko pengguna
        $productOptions = Product::where('store_id', auth()->user()->store->id)->get();

        return view('livewire.admin.sales.edit', [
            'productOptions' => $productOptions,
        ])->layout('components.admin_layouts.app');
    }

    public function update()
    {
        // Memulai transaksi database
        DB::beginTransaction();

        try {
            // Update data penjualan
            $this->sale->update([
                'invoice_number' => $this->invoice_number,
                'sale_date' => $this->sale_date,
                'total_amount' => $this->total_amount,
                'discount' => $this->discount,
                'note' => $this->note,
            ]);

            // Hapus item penjualan yang ada
            $this->sale->salesItems()->delete(); // Ubah disini

            // Simpan kembali item penjualan yang diperbarui
            foreach ($this->products as $product) {
                SalesItems::create([
                    'sale_id' => $this->sale->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }

            // Commit transaksi
            DB::commit();

            // Tampilkan pesan sukses
            $this->alert('success', 'Data penjualan berhasil diperbarui');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();
            $this->alert('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function addToChart()
    {
        $this->products[] = ['product_id' => null, 'quantity' => 1, 'price' => null];
    }

    public function removeFromChart($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
        $this->updateTotal();
    }

    private function updateTotal()
    {
        logger('Updating total...');
        $total = collect($this->products)->sum(function ($product) {
            $quantity = isset($product['quantity']) ? (int) $product['quantity'] : 0;
            $price = isset($product['price']) ? (float) $product['price'] : 0;
            return $quantity * $price;
        });

        // Hitung total setelah diskon dalam bentuk persen
        $this->total_amount = $total - ($total * $this->discount / 100);
    }

    public function updated($propertyName)
    {
        // Automatically update price when product is selected
        if (Str::contains($propertyName, 'products.') && Str::contains($propertyName, '.product_id')) {
            $index = (int) Str::between($propertyName, 'products.', '.product_id');
            $this->updatePrice($index);
        }

        // Automatically update total when quantity or price is changed
        if (Str::contains($propertyName, 'products.') && (Str::contains($propertyName, '.quantity') || Str::contains($propertyName, '.price'))) {
            $this->updateTotal();
        }

        // Validate quantity not exceeding stock
        if (Str::contains($propertyName, 'products.') && Str::contains($propertyName, '.quantity')) {
            $index = (int) Str::between($propertyName, 'products.', '.quantity');
            $product = Product::find($this->products[$index]['product_id']);
            if ($product && $this->products[$index]['quantity'] > $product->stock) {
                $this->addError('products.' . $index . '.quantity', 'Quantity tidak boleh melebihi stok produk');
            }
        }

        if ($propertyName === 'discount') {
            logger('Discount updated...');
            $this->updateTotal();
        }
    }

    private function updatePrice($index)
    {
        $product = Product::find($this->products[$index]['product_id']);
        $this->products[$index]['price'] = $product ? $product->price : null;
        $this->updateTotal();
    }

}
