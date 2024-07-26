<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">

        <div class="search-container d-lg-flex d-none">
            <input type="text" wire:model="search" class="form-control" id="searchData" placeholder="Search">
            <i class="bi bi-search"></i>
        </div>
        {{-- make button tambah di ujung kanan --}}
        <div class="d-flex align-items-center ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                <i class="bi bi-plus"></i>
                Tambah Menu
            </button>
        </div>

    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">

        <!-- Row start -->
        <div class="row gx-3">
            @foreach($nestedMenus as $menu)
            <div class="col-xl-6 col-sm-6 col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-row">
                            <div class="ms-1">
                                <h5>{{ $menu->title }}</h5>
                            </div>
                            <div class="ms-auto d-flex gap-2">
                                <button class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle">
                                    <i class="bi bi-pencil lh-1"></i>
                                </button>
                                @if ($menu->status == 'Draft')
                                <button wire:click="status({{ $menu->id }})" class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle">
                                    <i class="bi bi-eye-slash lh-1"></i>
                                </button>
                                @else
                                <button wire:click="status({{ $menu->id }})" class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle">
                                    <i class="bi bi-eye lh-1"></i>
                                </button>
                                @endif
                                <button class="icon-box sm bg-danger bg-opacity-10 text-danger rounded-circle">
                                    <i class="bi bi-trash lh-1"></i>
                                </button>
                                @if($menu->children)
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#menu-{{ $menu->id }}" aria-expanded="false"
                                    aria-controls="menu-{{ $menu->id }}">
                                    <i class="bi-chevron-compact-down"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                        @if($menu->children)
                        <div id="menu-{{ $menu->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading-{{ $menu->id }}" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                @foreach($menu->children as $child)
                                <div class="d-flex align-items-center flex-row">
                                    <div class="ms-3">
                                        <p class="m-0 text-muted text-truncate">{{ $child->title }}</p>
                                    </div>
                                    <div class="ms-auto d-flex gap-2 mt-3">
                                        <button class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle">
                                            <i class="bi bi-pencil lh-1"></i>
                                        </button>
                                        @if ($child->status == 'Draft')
                                        <button wire:click="status({{ $child->id }})" class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle">
                                            <i class="bi bi-eye-slash lh-1"></i>
                                        </button>
                                        @else
                                        <button wire:click="status({{ $child->id }})" class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle">
                                            <i class="bi bi-eye lh-1"></i>
                                        </button>
                                        @endif
                                        <button
                                            class="icon-box sm bg-danger bg-opacity-10 text-danger rounded-circle">
                                            <i class="bi bi-trash lh-1"></i>
                                        </button>
                                        @if($child->children)
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#child-{{ $child->id }}"
                                            aria-expanded="false" aria-controls="child-{{ $child->id }}">
                                            <i class="bi-chevron-compact-down"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @if($child->children)
                                <div id="child-{{ $child->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="headingChild-{{ $child->id }}" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        @foreach($child->children as $grandChild)
                                        <div class="d-flex align-items-center flex-row">
                                            <div class="ms-5">
                                                <p class="m-0 text-muted text-truncate">{{ $grandChild->title }}</p>
                                            </div>
                                            <div class="ms-auto d-flex gap-2 mt-3">
                                                <button
                                                    class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle">
                                                    <i class="bi bi-pencil lh-1"></i>
                                                </button>
                                                @if ($grandChild->status == 'Draft')
                                                <button wire:click="status({{ $grandChild->id }})"
                                                    class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle">
                                                    <i class="bi bi-eye-slash lh-1"></i>
                                                </button>
                                                @else
                                                <button wire:click="status({{ $grandChild->id }})"
                                                    class="icon-box sm bg-info bg-opacity-10 text-info rounded-circle">
                                                    <i class="bi bi-eye lh-1"></i>
                                                </button>
                                                @endif
                                                <button
                                                    class="icon-box sm bg-danger bg-opacity-10 text-danger rounded-circle">
                                                    <i class="bi bi-trash lh-1"></i>
                                                </button>
                                                @if($grandChild->children)
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#grandchild-{{ $grandChild->id }}"
                                                    aria-expanded="false"
                                                    aria-controls="grandchild-{{ $grandChild->id }}">
                                                    <i class="bi-chevron-compact-down"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Row end -->

    </div>
    <!-- App body ends -->

    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        @if ($updateMode == true) Edit Menu @else Tambah Menu @endif
                    </h5>
                    <button type="button" wire:click="resetInput()" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @if($updateMode==true) wire:submit.prevent="update" @else wire:submit.prevent="store" @endif>
                        <div class="mb-3">
                            <label class="form-label">Nama Menu</label>
                            <input type="text" wire:model="title"
                                class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent</label>
                            <select class="form-control" wire:model="parent_id">
                                <option value="">Pilih Parent</option>
                                <option value="0">Root</option>
                                @foreach($nestedMenus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                @if($menu->children)
                                @foreach($menu->children as $child)
                                <option value="{{ $child->id }}">-- {{ $child->title }}</option>
                                @if($child->children)
                                @foreach($child->children as $grandChild)
                                <option value="{{ $grandChild->id }}">---- {{ $grandChild->title }}</option>
                                @endforeach
                                @endif
                                @endforeach
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilih Tipe</label>
                            <select class="form-control" wire:model.live="type">
                                <option value="">Pilih Tipe</option>
                                <option value="url">URL</option>
                                <option value="page">Halaman</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">@if ($type == 'page') Pilih Halaman @elseif ($type == 'url')
                                Masukan URL @else @endif</label>
                            @if($type == 'page')
                            <select wire:model="page_id" class="form-select @error('page_id') is-invalid @enderror">
                                <option value="">Pilih Halaman</option>
                                @foreach($pages as $page)
                                <option value="{{ $page->id }}">{{ $page->title }}</option>
                                @endforeach
                            </select>
                            @error('page_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            @endif
                            @if($type == 'url')
                            <input type="text" wire:model="url" class="form-control @error('url') is-invalid @enderror">
                            @error('url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Urut</label>
                            <input type="number" wire:model="sort"
                                class="form-control @error('sort') is-invalid @enderror">
                            @error('sort')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- button save --}}
                        <div class="modal-footer">
                            <button type="button" wire:click="resetInput()" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
                                @if ($updateMode == true) Update @else Save @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
