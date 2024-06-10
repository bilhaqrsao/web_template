<div>
    <div class="app-hero-header d-flex align-items-start">
        <ol class="breadcrumb d-none d-lg-flex">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1"></i>
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.sales') }}" class="text-decoration-none">Daftar Transaksi</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Edit Invoice</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row gx-3">
            <div class="col-xl-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Edit Invoice</h5>
                    </div>
                    <div class="card-body">
                        <div class="create-invoice-wrapper">
                            <div class="row gx-3">
                                <div class="col-sm-6 col-12">
                                    <div class="row gx-3">
                                        <div class="col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="invNumber" class="form-label">Invoice Number</label>
                                                <input wire:model="invoice_number" type="text" id="invNumber"
                                                    class="form-control" readonly />
                                                @error('invoice_number') <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label for="dueDate" class="form-label">Due Date</label>
                                                <div class="input-group">
                                                    <input wire:model="sale_date" type="text" class="form-control"
                                                        id="dueDate" readonly />
                                                    <span class="input-group-text">
                                                        <i class="bi bi-calendar4"></i>
                                                    </span>
                                                </div>
                                                @error('sale_date') <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-12">
                                            <div class="mb-2">
                                                <label for="msgCustomer" class="form-label">Message</label>
                                                <textarea wire:model="note" rows="3" id="msgCustomer"
                                                    class="form-control"></textarea>
                                                @error('note') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row gx-3">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="4" class="pt-3 pb-3">Items/Produk</th>
                                                <th>Total</th>
                                            </tr>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Jumlah</th>
                                                <th>Harga / Satuan</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $index => $product)
                                            <tr>
                                                <td>
                                                    <select wire:model="products.{{ $index }}.product_id"
                                                        class="form-select">
                                                        <option value="">Pilih Produk</option>
                                                        @foreach($productOptions as $productOption)
                                                        <option value="{{ $productOption->id }}" @if($productOption->id == $product['product_id']) selected @endif>
                                                            {{ $productOption->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('products.'.$index.'.product_id') <span
                                                        class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                                <td>
                                                    <div class="m-0">
                                                        <input wire:model.lazy="products.{{ $index }}.quantity"
                                                            type="number" class="form-control" placeholder="Qty" />
                                                        @error('products.'.$index.'.quantity') <span
                                                            class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group m-0">
                                                        <input wire:model.lazy="products.{{ $index }}.price" type="text"
                                                            class="form-control" readonly />
                                                        <span class="input-group-text"><i
                                                                class="bi bi-currency-dollar"></i></span>
                                                        @error('products.'.$index.'.price') <span
                                                            class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>
                                                        @php
                                                        // Konversi nilai ke integer dan float sebelum dilakukan perhitungan
                                                        $quantity = isset($product['quantity']) ? (int) $product['quantity'] : 0;
                                                        $price = isset($product['price']) ? (float) $product['price'] : 0;
                                                        $total = $quantity * $price;
                                                        @endphp
                                                        Rp. {{ number_format($total, 2, ',', '.') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-inline-flex gap-3">
                                                        <button wire:click.prevent="removeFromChart({{ $index }})"
                                                            class="btn btn-outline-danger">
                                                            <i class="bi bi-trash m-0"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td>
                                                    <button wire:click.prevent="addToChart"
                                                        class="btn btn-secondary">Tambah Baris Baru</button>
                                                </td>
                                                <td colspan="3">
                                                    <div class="row justify-content-end">
                                                        <div class="col-auto">
                                                            <label class="col-form-label">Diskon % dari Total</label>
                                                        </div>
                                                        <div class="col-auto">
                                                            <input wire:model.live="discount" type="number" class="form-control" placeholder="0%" />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                                <td>
                                                    <h5 class="mt-2 text-red">Total</h5>
                                                </td>
                                                <td wire:ignore.self>
                                                    <h5 class="mt-2 text-red">Rp. {{ number_format($total_amount, 2, ',', '.') }}</h5>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-end">
                                    <button wire:click="update" class="btn btn-success ms-1">Update Invoice</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
