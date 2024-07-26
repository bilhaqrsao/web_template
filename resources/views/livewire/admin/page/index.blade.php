<?php
  use Carbon\Carbon;
  use Illuminate\Support\Facades\Storage;
?>
<div>
    {{-- Be like water. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">
        <!-- Breadcrumb end -->
        <div class="search-container d-lg-flex d-none">
            <input type="text" wire:model="search" class="form-control" id="searchData" placeholder="Search">
            <i class="bi bi-search"></i>
        </div>
        {{-- make button tambah di ujung kanan --}}
        <div class="d-flex align-items-center ms-auto">
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                <i class="bi bi-plus"></i>
                Tambah Halaman
            </a>
        </div>
    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">
        <!-- Row start -->
        <div class="row gx-3">
            @forelse ($datas as $data)
            <div class="col-xl-4 col-sm-6 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-row">
                            <img src="{{ asset('storage/page/'.$data->thumbnail) }}" alt="Bootstrap Themes" class="rounded-circle img-3x"/>
                            <div class="ms-3">
                                <h5>{{ Str::limit($data->title, 30) }}</h5>
                                <p class="m-0 text-muted text-truncate">
                                    {{ Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM Y') }}
                                </p>
                            </div>
                            <div class="ms-auto d-flex gap-2">
                                <button wire:click="delete({{ $data->id }})" class="icon-box sm bg-danger bg-opacity-10 text-danger rounded-circle"><i
                                        class="bi bi-trash lh-1"></i></button>
                                <a href="{{ route('admin.pages.edit', $data->id) }}" class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle"><i
                                        class="bi bi-pencil lh-1"></i></a>
                                @if ($data->status == 'Draft')
                                <button wire:click="changeStatus({{ $data->id }})" class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle"><i
                                    class="bi bi-eye-slash lh-1"></i></button>
                                @else
                                <button wire:click="changeStatus({{ $data->id }})" class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle"><i
                                    class="bi bi-eye lh-1"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <div class="text-black">
                        <strong>Sorry!</strong> No data found.
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Row end -->
    </div>
    <!-- App body ends -->
</div>
