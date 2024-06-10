<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="app-body mt-2">
        <div class="row gx-3">
            <div class="card">
                <div class="card-header">
                    {{-- if permission user developer and super-admin --}}
                    @if ($user->hasRole('developer') || $user->hasRole('super-admin'))
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahStore">
                        <i class="bi bi-plus-lg"></i> Add Store
                    </button>
                    @endif
                </div>
            </div>
            @forelse ($datas as $data)
            <div class="col-sm-4 col-12 mt-2">
                <div class="card mb-3">
                    <div class="card-img">
                        <img src="{{ asset('storage/store/banner/'.$data->banner) }}" class="card-img-top img-fluid"
                            alt="{{ $data->name }}" />
                    </div>
                    <div class="card-body">
                        <h4 class="mb-3">{{ $data->name }}</h4>
                        <h5 class="mb-3">{{ $data->address }}</h5>
                        <p class="lh-base mb-4">
                            {{ $data->description }}
                        </p>
                        <div class="d-flex justify-content-center mt-3">
                            <a href="{{ $data->facebook }}" class="me-4" target="_blank">
                                <i class="bi bi-facebook fs-5"></i>
                            </a>
                            <a href="{{ $data->twitter }}" class="me-4" target="_blank">
                                <i class="bi bi-twitter fs-5"></i>
                            </a>
                            <a href="{{ $data->instagram }}" class="me-4" target="_blank">
                                <i class="bi bi-instagram fs-5"></i>
                            </a>
                            <a href="{{ $data->whatsapp }}" class="me-4" target="_blank">
                                <i class="bi bi-whatsapp fs-5"></i>
                            </a>
                            <a href="{{ $data->website }}" class="me-4" target="_blank">
                                <i class="bi bi-globe fs-5"></i>
                            </a>
                        </div>
                        @if ($user->hasRole('developer') || $user->hasRole('super-admin'))
                        <div class="d-flex justify-content-center mt-3">
                            <button wire:click="edit({{ $data->id }})" type="button" class="btn btn-primary me-2"
                                data-bs-toggle="modal" data-bs-target="#tambahStore">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-danger" wire:click="destroy('{{ $data->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        @endif
                        {{-- macrd end card --}}

                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <strong>Sorry!</strong> No data found.
                </div>
            </div>
            @endforelse
        </div>
    </div>

    @if ($user->hasRole('developer') || $user->hasRole('super-admin'))
    <div wire:ignore.self class="modal fade" id="tambahStore" tabindex="-1" aria-labelledby="tambahStoreTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahStoreTitle">
                        @if ($updateMode == false)
                        Tambah Store
                        @else
                        Edit Store
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @if ($updateMode==false) wire:submit.prevent="store" @else wire:submit.prevent="update"
                        @endif>
                        <div class="mb-3">
                            <label for="banner" class="form-label">Banner</label>
                            @if ($updateMode == false)
                                @if ($banner == null)
                                <div class="card-img">
                                    <img src="{{ asset('admin_assets/images/flowers/img9.jpg') }}" class="card-img-top img-fluid" />
                                </div>
                                @elseif ($banner)
                                <div class="card-img">
                                    <img src="{{ $banner->temporaryUrl() }}" class="card-img-top img-fluid" />
                                </div>
                                @endif
                            @elseif ($updateMode == true)
                                @if ($banner)
                                <div class="card-img">
                                    <img src="{{ $banner->temporaryUrl() }}" class="card-img-top img-fluid" />
                                </div>
                                @else
                                <div class="card-img">
                                    <img src="{{ asset('storage/store/banner/' . $prevBanner) }}" class="card-img-top img-fluid" />
                                </div>
                                @endif
                            @enderror
                            <input type="file" class="form-control mt-2 @error('banner') is-invalid @enderror"
                                wire:model="banner" accept="image/jpeg,image/png,image/jpg">
                            @error('banner')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="banner" class="form-label">Logo</label>
                            <div class="card-img text-center">
                                @if ($updateMode == false)
                                    @if ($logo == null)
                                    <img src="{{ asset('admin_assets/images/flowers/img9.jpg') }}" class="rounded-circle img-8x" style="width: 150px; height:150px" />
                                    @elseif ($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="rounded-circle img-8x" style="width: 150px; height:150px" />
                                    @endif
                                @elseif ($updateMode == true)
                                    @if ($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="rounded-circle img-8x" style="width: 150px; height:150px" />
                                    @else
                                    <img src="{{ asset('storage/store/logo/' . $prevLogo) }}" class="rounded-circle img-8x" style="width: 150px; height:150px" />
                                    @endif
                                @endif
                            </div>
                            <input type="file" class="form-control mt-2 @error('logo') is-invalid @enderror"
                                wire:model="logo" accept="image/jpeg,image/png,image/jpg">
                            @error('logo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                wire:model="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No Telephone</label>
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                wire:model="phone">
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                wire:model="email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                wire:model="address">
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">City</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="city"
                                wire:model="city">
                            @error('city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                wire:model="description"></textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="facebook" class="form-label">Facebook</label>
                            {{-- facebook tidak boleh ada spasi --}}
                            <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook"
                                wire:model="facebook">
                            @error('facebook')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="twitter"
                                wire:model="twitter">
                            @error('twitter')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                id="instagram" wire:model="instagram">
                            @error('instagram')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="text" class="form-control @error('website') is-invalid @enderror" id="website"
                                wire:model="website">
                            @error('website')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            @if ($updateMode == false)
                            Save
                            @else
                            Update
                            @endif
                        </button>
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
