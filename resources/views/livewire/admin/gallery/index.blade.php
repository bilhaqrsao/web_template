<div>
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">
        <div class="search-container d-lg-flex d-none">
            <input type="text" wire:model.live="search" class="form-control" id="searchData" placeholder="Search">
            <i class="bi bi-search" ></i>
        </div>
        <div class="d-flex align-items-center ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                <i class="bi bi-plus"></i>
                Tambah Galeri
            </button>
        </div>
    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">
        <!-- Row start -->
        <div class="row gx-3">
            @forelse($datas as $data)
                <div class="col-sm-4 col-12">
                    <div class="card mb-3">
                        <div class="card-img">
                            <div id="carouselExampleIndicators{{ $data->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach(json_decode($data->images) as $key => $image)
                                        <button type="button" data-bs-target="#carouselExampleIndicators{{ $data->id }}" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner">
                                    @foreach(json_decode($data->images) as $key => $image)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/gallery/' . $image) }}" class="d-block w-100" alt="Gallery Image {{ $key + 1 }}" style="width: auto; height: 300px">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators{{ $data->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators{{ $data->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="mb-3">{{ $data->title }}</h4>
                            <h6 class="mb-3">Uploaded By: {{ $data->Author->username }}</h6>
                            <p class="lh-base mb-4">{{ $data->description }}</p>
                            <div class="d-flex">
                                <a wire:click="delete({{ $data->id }})" href="javascript:;" class="me-4">
                                    <i class="bi bi-trash fs-5"></i>
                                </a>
                                <a wire:click="edit({{ $data->id }})" href="javascript:;" class="me-4" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                    <i class="bi bi-pencil fs-5"></i>
                                </a>
                                @if ($data->status == 'Publish')
                                    <a wire:click="status({{ $data->id }})" href="javascript:;" class="me-4">
                                        <i class="bi bi-eye fs-5"></i>
                                    </a>
                                @else
                                    <a wire:click="status({{ $data->id }})" href="javascript:;" class="me-4">
                                        <i class="bi bi-eye-slash fs-5"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        <div class="text-black">
                            Data tidak ditemukan
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- Row end -->
    </div>
    <!-- App body ends -->

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">@if($updateMode == false)Tambah Galeri @else Edit Galeri @endif</h5>
                    <button wire:click="resetInput()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @if ($updateMode == false) wire:submit.prevent="store" @else wire:submit.prevent="update" @endif>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" wire:model="title">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" wire:model="description"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control d-none" id="images" wire:model="images" multiple accept="image/*">
                            @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror

                            <!-- Spinner Loading saat mengunggah -->
                            <div wire:loading wire:target="images" class="mt-2">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span class="ms-2">Uploading...</span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                @foreach($existingImages as $index => $image)
                                    <div class="col-md-3 mb-3 position-relative">
                                        <img src="{{ asset('storage/gallery/' . $image) }}" class="img-fluid rounded">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" wire:click="removeImage({{ $index }}, true)">x</button>
                                    </div>
                                @endforeach

                                @foreach($images as $index => $image)
                                    <div class="col-md-3 mb-3 position-relative">
                                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" wire:click="removeImage({{ $index }})">x</button>
                                    </div>
                                @endforeach

                                <div class="col-md-3 mb-3 d-flex align-items-center justify-content-center">
                                    <label for="images" class="btn btn-secondary m-0">Add Image</label>
                                </div>
                            </div>
                        </div>
                        <button wire:click="resetInput()" type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
