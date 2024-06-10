<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="app-hero-header d-flex align-items-start">

        <!-- Breadcrumb start -->
        <ol class="breadcrumb d-none d-lg-flex">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1"></i>
                <a href="index.html" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item">Invoice</li>
            <li class="breadcrumb-item" aria-current="page">View invoice</li>
        </ol>
        <!-- Breadcrumb end -->

    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">

        <!-- Row start -->
        <div class="row gx-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ $data->invoice_number }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- Row start -->
                        <div class="row gx-3">
                            <div class="col-xxl-3 col-sm-3 col-12">
                                <img src="{{ asset('storage/store/logo/'.$data->Store->logo) }}"
                                    alt="{{ $data->Store->name }}" class="img-fluid" />
                            </div>
                            <div class="col-sm-9 col-12">
                                <p class="text-end m-0">
                                    {{ $data->Store->address }}
                                </p>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row gx-3">
                            <div class="col-sm-12 col-12">
                                <div class="d-flex justify-content-between my-4">
                                    <p class="m-0">
                                        {{ $data->User->name }},<br />
                                    </p>

                                    <div class="text-end">
                                        <p class="m-0">
                                            <strong>Invoice Date:</strong>
                                        </p>
                                        <p class="m-0">{{ \Carbon\Carbon::parse($data->sale_date)->format('d M Y') }}
                                        </p>
                                        <p class="m-0">{{ \Carbon\Carbon::parse($data->created_at)->format('H:i') }}</p>
                                        @if ($data->payment_status == 'paid')
                                        <span class="badge bg-success">Paid</span>
                                        @elseif ($data->payment_status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @else
                                        <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row gx-3">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Quantity</th>
                                                <th>Harga</th>
                                                <th>Total (Net)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data->salesItems as $item)
                                            <tr>
                                                <td>
                                                    <h6>{{ $item->Product->name }}</h6>
                                                </td>
                                                <td>
                                                    <h6>{{ $item->quantity }}</h6>
                                                </td>
                                                <td>
                                                    <h6>
                                                        Rp. {{ number_format($item->price, 0, ',', '.') }}
                                                    </h6>
                                                </td>
                                                <td>
                                                    <h6>Rp.
                                                        {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                                    </h6>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Data tidak ditemukan</td>
                                            </tr>
                                            @endforelse
                                            <tr>
                                                <td colspan="2">&nbsp;</td>
                                                <td>
                                                    <p>Subtotal</p>
                                                    <p>Discount</p>
                                                    <h5 class="mt-4 text-blue">Total USD</h5>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{-- sum $item->quantity * $item->price --}}
                                                        Rp. {{ number_format($data->salesItems->sum(function($item) {
                                                        return $item->quantity * $item->price;
                                                        }), 0, ',', '.') }}
                                                    </p>
                                                    <p>
                                                        {{ $data->discount }}%
                                                    </p>
                                                    <h5 class="mt-4 text-blue">
                                                        Rp. {{ number_format($data->total_amount, 0, ',', '.') }}
                                                    </h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <h6 class="text-red">NOTES</h6>
                                                    <small>
                                                        Terima kasih atas pembelian Anda. Jika ada pertanyaan lebih
                                                        lanjut, jangan ragu untuk menghubungi kami di nomor  yang tertera
                                                        di bawah ini.
                                                        Kami harap Anda puas dengan layanan kami dan kami berharap dapat
                                                        melayani Anda kembali di masa mendatang.
                                                    </small>

                                                    <h6 class="text-red mt-4">Kontak Kami .</h6>
                                                    <small>
                                                        {{ $data->Store->phone }}<br />
                                                        {{ $data->Store->email }}<br />
                                                    </small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Row end -->

                        <!-- Row start -->
                        <div class="row gx-3">
                            <div class="col-sm-12 col-12">
                                <div class="text-end">
                                    <button wire:click="print({{ $data->id }})" class="btn btn-outline-light ms-1">
                                        Print
                                    </button>
                                    <button class="btn btn-outline-danger ms-1">
                                        Print Thermal
                                    </button>
                                    @if ($data->payment_status == 'unpaid')
                                    <button wire:click="updatePaymentStatus({{ $data->id }})"
                                        class="btn btn-success ms-1">Bayar</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Row end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->

    </div>
    <!-- App body ends -->
</div>
