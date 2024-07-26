<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">

        <div class="search-container d-lg-flex d-none">
            <input type="text" wire:model.live="search" class="form-control" id="searchData"
                placeholder="Search">
            <i class="bi bi-search"></i>
        </div>
        <div class="d-flex align-items-center ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                <i class="bi bi-plus"></i>
                Tambah Video
            </button>
        </div>

    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">
        <!-- Row start -->
        <div class="row gx-3">
            @forelse ($datas as $data)
            <div class="col-sm-4 col-12">
                <div class="card mb-3">
                    <div class="card-img">
                        <img src="https://i.ytimg.com/vi/{{ $data->yt_id }}/hq720.jpg" class="card-img-top img-fluid"
                            alt="Google Admin" />
                    </div>
                    <div class="card-body">
                        <h4 class="mb-3">{{ $data->title }}</h4>
                        <p class="lh-base mb-4">
                            {{ $data->description }}
                        </p>
                        <div class="d-flex">
                            <a wire:click="delete({{ $data->id }})" href="javascript:;" class="me-4">
                                <i class="bi bi-trash fs-5"></i>
                            </a>
                            <a wire:click="edit({{ $data->id }})" href="javascript:;" class="me-4"
                                data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
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
                    Data tidak ditemukan
                </div>
            </div>
            @endforelse
        </div>
        <!-- Row end -->
    </div>
    <!-- App body ends -->

    {{-- modal --}}
    <div wire:ignore.self class="modal fade" id="exampleModalCenter" tabindex="-1"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        @if($updateMode == false) Tambah @else Edit @endif Video
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @if($updateMode==false) wire:submit.prevent="store" @else wire:submit.prevent="update" @endif>
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" wire:model="title" class="form-control" id="title" placeholder="Judul">
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" wire:model="linkYoutube" class="form-control" id="url" placeholder="URL">
                            @error('url') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea wire:model="description" class="form-control" id="description"
                                rows="3"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
