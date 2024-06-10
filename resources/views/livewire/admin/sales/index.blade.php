<?php use Carbon\Carbon; ?>

<div>
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">
        <!-- Breadcrumb start -->
        <ol class="breadcrumb d-none d-lg-flex">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1"></i>
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">List Transaksi</li>
        </ol>
        <!-- Breadcrumb end -->
    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">
        <!-- Row start -->
        <div class="row gx-3">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="dropdown ms-auto">
                                <a href="{{ route('admin.sales.create') }}" class="btn btn-light" type="button">
                                    <i class="bi bi-plus"></i> Transaksi
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Kasir</th>
                                        <th>Nomer Invoice</th>
                                        <th>Produk</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Tanggal Invoice</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($datas as $data)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/user/'.$data->User->photo) }}" class="img-3xx rounded-5 me-3"
                                                        alt="{{ $data->User->name }}" />
                                                    <p class="m-0">{{ $data->User->name }}</p>
                                                </div>
                                            </td>
                                            <td>{{ $data->invoice_number }}</td>
                                            <td>
                                                @forelse ($data->SalesItems as $item)
                                                    {{ $item->Product->name }} ({{ $item->quantity }})
                                                    <br>
                                                @empty
                                                    Data tidak ditemukan
                                                @endforelse
                                            </td>
                                            <td>Rp. {{ number_format($data->total_amount, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge bg-success">Paid</span>
                                            </td>
                                            <td>
                                                Tanggal: {{ \Carbon\Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM YYYY') }} <br>
                                                Waktu: {{ \Carbon\Carbon::parse($data->created_at)->format('H:i') }} WIB
                                            </td>
                                            <td>
                                                @if (auth()->user()->hasRole('admin'))
                                                    <a href="{{ route('admin.sales.edit', $data->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button wire:click="destroy({{ $data->id }})" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $datas->links('pagination::one') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- App body ends -->
</div>
