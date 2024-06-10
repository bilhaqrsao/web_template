<div>
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">

        <!-- Breadcrumb start -->
        <ol class="breadcrumb d-none d-lg-flex">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1"></i>
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                Produk
            </li>
        </ol>
        <!-- Breadcrumb end -->

        <!-- Filter start -->
        <div class="ms-auto d-flex flex-row gap-1 day-filters">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                <i class="bi bi-plus"></i>
                Add Product
            </button>
        </div>
        <!-- Filter end -->

    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">

        <!-- Row start -->
        <div class="row gx-3">
            @forelse ($datas as $data)
            <div class="col-sm-4 col-12">
                <div class="card mb-3">
                    <div id="carousel{{$data->id}}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach(json_decode($data->image) as $key => $img)
                            <button type="button" data-bs-target="#carousel{{$data->id}}" data-bs-slide-to="{{$key}}"
                                class="{{$key == 0 ? 'active' : ''}}" aria-current="true"
                                aria-label="Slide {{$key+1}}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach(json_decode($data->image) as $key => $img)
                            <div class="carousel-item {{$key == 0 ? 'active' : ''}}">
                                <img src="{{ asset('storage/product/' . $img) }}" class="d-block w-100"
                                    alt="Product Image" style="height: 300px">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{$data->id}}"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{$data->id}}"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <h5 class="mb-4">{{ $data->name }}</h5>
                        <p>
                            {{ $data->description }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <h5 class="text-primary">Rp. {{ number_format($data->price, 0, ',', '.') }}</h5>
                            <span class="badge bg-primary rounded-pill">{{ $data->stock }} Tersedia</span>
                        </div>

                        <button wire:click="edit({{ $data->id }})" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button wire:click="destroy({{ $data->id }})" class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <div class="text-center text-bg-primary">No data found!</div>
                </div>
            </div>
            @endforelse
        </div>
        <!-- Row end -->

        <!-- Pagination start -->
        <div class="d-flex justify-content-center">
            {{ $datas->links('pagination::one') }}
        </div>

    </div>
    <!-- App body ends -->

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        @if ($updateMode == false)
                        Tambah Produk
                        @elseif ($updateMode == true)
                        Edit Produk
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @if ($updateMode==false) wire:submit.prevent="store" @elseif ($updateMode==true)
                        wire:submit.prevent="update" @endif>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <input type="file" wire:model="image"
                                class="form-control @error('image.*') is-invalid @enderror" id="image" multiple
                                accept="image/jpg, image/jpeg, image/png">
                            @error('image.*') <span class="text-danger">{{ $message }}</span> @enderror
                            <!-- Image preview section -->
                            <div class="mt-2" wire:loading.remove wire:target="image">
                                @if ($prevImage)
                                <h6>Gambar Sebelumnya</h6>
                                <div class="d-flex flex-wrap">
                                    @foreach ($prevImage as $key => $img)
                                    <div class="d-flex flex-column align-items-center me-3 mb-3">
                                        <img src="{{ asset('storage/product/' . $img) }}" alt="Preview Image"
                                            class="img-thumbnail mb-2" style="max-width: 100px; height:100px">
                                        <button type="button" wire:click="removePrevImage({{ $key }})"
                                            class="btn btn-sm btn-danger">Hapus</button>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                @if ($image)
                                <h6>Gambar Baru</h6>
                                <div class="d-flex flex-wrap">
                                    @foreach ($image as $key => $img)
                                    <div class="d-flex flex-column align-items-center me-3 mb-3">
                                        <img src="{{ $img->temporaryUrl() }}" alt="Preview Image"
                                            class="img-thumbnail mb-2" style="max-width: 100px;">
                                        <button type="button" wire:click="removeImage({{ $key }})"
                                            class="btn btn-sm btn-danger">Hapus</button>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <!-- Loading spinner during image upload -->
                            <div wire:loading wire:target="image" class="mt-2">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="productName" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="productName" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="price" wire:model="price">
                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control" id="productDescription" rows="3"
                                wire:model="description"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" wire:model="stock">
                            @error('stock') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- category -->
                        <!-- category -->
                        <div class="mb-3" wire:ignore>
                            <label for="category" class="form-label">Kategori</label>
                            <select id="category" class="form-select rounded-4" wire:model="category_id">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- sub category -->
                        <div class="mb-3" wire:ignore>
                            <label for="sub_category" class="form-label">Sub Kategori</label>
                            <select id="sub_category" class="form-select" wire:model="sub_category_id">
                                <option value="">Pilih Sub Kategori</option>
                                @foreach ($subcategories as $sub_category)
                                <option value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
                                @endforeach
                            </select>
                            @error('sub_category_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        {{-- button submit --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Close</button>
                            <button type="submit" class="btn btn-primary">
                                @if ($updateMode == false)
                                Tambah
                                @elseif ($updateMode == true)
                                Edit
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
