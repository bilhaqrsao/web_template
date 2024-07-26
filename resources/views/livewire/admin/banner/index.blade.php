<div>
    {{-- Stop trying to control. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">

        <div class="search-container d-lg-flex d-none">
            <input type="text" wire:model.live="search" class="form-control" id="searchData" placeholder="Search">
            <i class="bi bi-search"></i>
        </div>
        <div class="d-flex align-items-center ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                <i class="bi bi-plus"></i>
                Tambah Banner
            </button>
        </div>

    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">

        <!-- Row start -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @forelse ($datas as $data)
                                <div class="carousel-item active">
                                    <img src="{{ asset('storage/banner/'.$data->images) }}" class="d-block w-100" alt="Banner Image" style="width: 1219px; height: 523px"/>
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-btn" wire:click="delete({{ $data->id }})">
                                        <i class="bi-trash-fill"></i>
                                    </button>
                                </div>
                                @empty
                                <div class="carousel-item active">
                                    <img src="{{ asset('admin_assets/images/flowers/img7.jpg') }}" class="d-block w-100" alt="Default Image" />
                                </div>
                                @endforelse
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->

    </div>
    <!-- App body ends -->

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Banner</h5>
                    <button wire:click="resetInput()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="mb-3">
                            <label for="link" class="form-label">Title</label>
                            <input type="text" wire:model="title" class="form-control" id="link">
                            @error('link') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            @if ($images)
                            <img src="{{ $images->temporaryUrl() }}" class="d-block w-100" alt="Preview Image" />
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Gambar</label>
                            <input type="file" wire:model="images" class="form-control" id="images" accept="image/*">
                            @error('images') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button wire:click="resetInput" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .delete-btn {
            z-index: 10;
            margin-top: 10px; /* Adjust as necessary */
            margin-right: 10px; /* Adjust as necessary */
        }
        .carousel-control-prev, .carousel-control-next {
            z-index: 5;
        }
    </style>
</div>
