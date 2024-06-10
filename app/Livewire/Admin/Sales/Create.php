<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;
use App\Models\Core\Sales;
use Illuminate\Support\Str;
use App\Models\Core\Product;
use App\Models\Core\SalesItems;
use Illuminate\Support\Facades\DB;
use App\Models\LogActivity\LogStore;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;

    public $invoice_number;
    public $sale_date;
    public $total_amount;
    public $note;
    public $discount = 0;


    public $products = [];

    protected $rules = [
        'invoice_number' => 'required|unique:sales,invoice_number',
        'sale_date' => 'required',
        'total_amount' => 'required',
        'products.*.product_id' => 'required',
        'products.*.quantity' => 'required|numeric|min:1',
        'products.*.price' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
    ];

    protected $messages = [
        'invoice_number.required' => 'Nomor invoice harus diisi',
        'invoice_number.unique' => 'Nomor invoice sudah ada',
        'sale_date.required' => 'Tanggal penjualan harus diisi',
        'total_amount.required' => 'Total harus diisi',
        'products.*.product_id.required' => 'Produk harus dipilih',
        'products.*.quantity.required' => 'Kuantitas harus diisi',
        'products.*.quantity.numeric' => 'Kuantitas harus berupa angka',
        'products.*.quantity.min' => 'Kuantitas minimal 1',
        'products.*.price.required' => 'Harga harus diisi',
        'products.*.price.numeric' => 'Harga harus berupa angka',
        'products.*.price.min' => 'Harga minimal 0',
        'discount.numeric' => 'Diskon harus berupa angka',
        'discount.min' => 'Diskon tidak boleh kurang dari 0',
    ];

    public function mount()
    {
        $this->invoice_number = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        $this->sale_date = now()->format('Y-m-d');
        $this->products = [['product_id' => null, 'quantity' => 0, 'price' => null]];
        $this->updateTotal();
    }

    public function render()
    {
        $user_store = auth()->user()->store->name;
        $productOptions = Product::where('store_id', auth()->user()->store->id)->get();
        return view('livewire.admin.sales.create', [
            'user_store' => $user_store,
            'productOptions' => $productOptions,
        ])->layout('components.admin_layouts.app');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        // Automatically update price when product is selected
        if (Str::contains($propertyName, 'products.') && Str::contains($propertyName, '.product_id')) {
            $index = (int)Str::between($propertyName, 'products.', '.product_id');
            $this->updatePrice($index);
        }

        // Automatically update total when quantity or price is changed
        if (Str::contains($propertyName, 'products.') && (Str::contains($propertyName, '.quantity') || Str::contains($propertyName, '.price'))) {
            $this->updateTotal();
        }

        // Validate quantity not exceeding stock
        if (Str::contains($propertyName, 'products.') && Str::contains($propertyName, '.quantity')) {
            $index = (int)Str::between($propertyName, 'products.', '.quantity');
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

    public function store()
    {
        $this->validate();

        // Validasi stok produk sebelum melakukan transaksi
        foreach ($this->products as $product) {
            $productModel = Product::find($product['product_id']);
            if ($productModel && $productModel->stock < $product['quantity']) {
                $this->addError('products.' . array_search($product, $this->products) . '.quantity', 'Jumlah kuantitas tidak boleh melebihi stok');
                return;
            }
        }

        DB::transaction(function () {
            $sales = Sales::create([
                'invoice_number' => $this->invoice_number,
                'sale_date' => $this->sale_date,
                'user_id' => auth()->user()->id,
                'store_id' => auth()->user()->store->id,
                'total_amount' => $this->total_amount,
                'discount' => $this->discount,
                'status' => '1', // '1' = active, '0' = inactive
                'note' => $this->note,
                'payment_method' => 'cash',
                'payment_status' => 'unpaid', // 'unpaid', 'paid', 'partial'
            ]);

            // Simpan data item invoice dan kurangi stok produk
            foreach ($this->products as $product) {
                $salesItem = SalesItems::create([
                    'sale_id' => $sales->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);

                // Kurangi stok produk
                $productModel = Product::find($product['product_id']);
                if ($productModel) {
                    $productModel->stock -= $product['quantity'];
                    $productModel->save();
                }

                LogStore::create([
                    'store_id' => auth()->user()->store->id,
                    'user_id' => auth()->user()->id,
                    'activity' => 'Sale',
                    'description' => 'Menjual produk ' . $productModel->name . ' sebanyak ' . $product['quantity'] . ' unit dengan harga Rp ' . number_format($product['price'], 0, ',', '.') . ' per unit',
                ]);
            }
        });

        $this->resetForm();
        $this->flash('success', 'Invoice Berhasil ditambahkan', [], route('admin.sales'));
    }


    public function addToChart()
    {
        $this->products[] = ['product_id' => null, 'quantity' => 1, 'price' => null];
    }

    public function removeFromChart($index)
    {
        unset($this->products[$index]);
        $this->products = array_values($this->products);
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

    private function resetForm()
    {
        $this->invoice_number = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        $this->sale_date = now()->format('Y-m-d');
        $this->total_amount = '';
        $this->note = '';
        $this->discount = 0;
        $this->products = [['product_id' => null, 'quantity' => 1, 'price' => null]];
    }
}
