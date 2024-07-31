<?php
  use Carbon\Carbon;
  use Illuminate\Support\Facades\Storage;
?>
<div>
    {{-- In work, do what you enjoy. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">
        <!-- Breadcrumb end -->
        <div class="search-container d-lg-flex d-none">
            <input type="text" wire:model.live="search" class="form-control" id="searchData" placeholder="Search">
            <i class="bi bi-search"></i>
        </div>
        {{-- make button tambah di ujung kanan --}}
        <div class="d-flex align-items-center ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                <i class="bi bi-plus"></i>
                Tambah Link Terkait
            </button>
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
                            <img src="{{ asset('storage/link-terkait/'.$data->icon) }}" alt="Bootstrap Themes"
                                class="rounded-circle img-3x" />
                            <div class="ms-3">
                                <h5>{{ Str::limit($data->title, 30) }}</h5>
                                <p class="m-0 text-muted text-truncate">
                                    {{ Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM Y') }}
                                </p>
                            </div>
                            <div class="ms-auto d-flex gap-2">
                                <button wire:click="delete({{ $data->id }})"
                                    class="icon-box sm bg-danger bg-opacity-10 text-danger rounded-circle"><i
                                        class="bi bi-trash lh-1"></i></button>
                                <button wire:click="edit({{ $data->id }})" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                                    class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle"><i
                                        class="bi bi-pencil lh-1"></i></button>
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
        <div class="d-flex justify-content-center">
            {{ $datas->links('vendor.pagination.bootstrap-5') }}
        </div>

        <!-- Row end -->
    </div>
    <!-- App body ends -->
    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">@if ($updateMode == false) Tambah Link Terkait
                        @else Edit Link Terkait @endif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @if ($updateMode == false) wire:submit.prevent="store" @else wire:submit.prevent="update" @endif>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" wire:model="title" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" wire:model="url" class="form-control" id="url" required>
                        </div>
                        <div class="mb-3">
                            <div class="col-md-3 mb-3 position-relative">
                                @if ($icon)
                                <img src="{{ $icon->temporaryUrl() }}" class="img-fluid rounded">
                                @elseif ($prevIcon)
                                <img src="{{ asset('storage/link-terkait/'.$prevIcon) }}" class="img-fluid rounded">
                                @endif
                            </div>
                            <label for="icon" class="form-label">Icon</label>
                            <input type="file" wire:model="icon" class="form-control" id="icon" required accept="image/*">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
