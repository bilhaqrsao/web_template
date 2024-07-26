<?php
  use Carbon\Carbon;
?>
<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">

        <!-- Breadcrumb start -->
        <div class="search-container d-lg-flex d-none">
            <input type="text" wire:model.live="search" class="form-control" id="searchData" placeholder="Search">
            <i class="bi bi-search"></i>
        </div>
        {{-- make button tambah di ujung kanan --}}
        <div class="d-flex align-items-center ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
                <i class="bi bi-plus"></i>
                Tambah Berkas
            </button>
        </div>
        <!-- Filter end -->

    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">

        <!-- Row start -->
        <div class="row gx-3">
            <div class="col-xxl-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-outer">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th width="80px">No</th>
                                            <th width="800px">Nama</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>*</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($datas as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->title }}</td>
                                            <td>{{ Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM Y') }}</td>
                                            <td>
                                                @if ($data->status == 'Publish')
                                                <button wire:click="ubahStatus({{ $data->id }})" class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @else
                                                <button wire:click="ubahStatus({{ $data->id }})" class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                                @endif
                                            </td>
                                            <td>
                                                <button wire:click="delete({{ $data->id }})" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <a href="{{ $url.$data->file }}" target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="bi-folder-symlink"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- App body ends -->

    {{-- modal --}}
    <div wire:ignore.self class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormLabel">Tambah Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <label for="title" class="form-label">Nama</label>
                            <input type="text" wire:model="title" class="form-control" id="title" placeholder="Nama">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Tanggal Berkas</label>
                            <input type="date" wire:model="created_at" class="form-control" id="date">
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="file" wire:model="file" class="form-control" id="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.rar,.zip">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
