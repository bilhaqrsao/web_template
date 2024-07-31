<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">

        <!-- Breadcrumb end -->
        <div class="search-container d-lg-flex d-none">
            <input type="text" wire:model="search" class="form-control" id="searchData" placeholder="Search">
            <i class="bi bi-search"></i>
        </div>
        {{-- make button tambah di ujung kanan --}}
        <div class="d-flex align-items-center ms-auto">
            <a href="{{ route('admin.pengumumans.create') }}" class="btn app-btn-primary">
                <i class="bi bi-plus"></i>
                Tambah Pengumuman
            </a>
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
                        <img src="{{ asset('storage/pengumuman/'.$data->image) }}" class="card-img-top img-fluid" alt="{{ $data->title }}" style="object-fit: cover; height: 300px;">
                    </div>
                    <div class="card-body">
                        <h4 class="mb-3">{{ $data->title }}</h4>
                        <div class="d-flex">
                            <a wire:click="delete({{ $data->id }})" href="javascript:;" class="me-4">
                                <i class="bi bi-trash fs-5"></i>
                            </a>
                            <a href="{{ route('admin.pengumumans.edit',$data->id) }}" class="me-4">
                                <i class="bi bi-pencil fs-5"></i>
                            </a>
                            @if ($data->status == 'Publish')
                            <a wire:click="ubahStatus({{ $data->id }})" href="javascript:;" class="me-4">
                                <i class="bi bi-eye fs-5"></i>
                            </a>
                            @else
                            <a wire:click="ubahStatus({{ $data->id }})" href="javascript:;" class="me-4">
                                <i class="bi bi-eye-slash fs-5"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    Data tidak ditemukan
                </div>
            </div>
            @endforelse
        </div>
        <!-- Row end -->
    </div>
    <!-- App body ends -->
</div>
