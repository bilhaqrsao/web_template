<div>
    <!-- Row start -->
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body">

                    <!-- Custom tabs start -->
                    <div class="custom-tabs-container">

                        <!-- Nav tabs start -->
                        <ul class="nav nav-tabs" id="customTab2" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab"
                                    aria-controls="oneA" aria-selected="true">
                                    <i class="bi bi-person me-2"></i> Personal Details
                                </a>
                            </li>
                        </ul>
                        <!-- Nav tabs end -->

                        <!-- Tab content start -->
                        <div class="tab-content mt-3">
                            <div class="tab-pane fade show active" id="oneA" role="tabpanel">

                                <!-- Form start -->
                                <form wire:submit.prevent="update">
                                    <div class="row gx-3">
                                        <div class="col-xl-4">
                                            <div class="mb-5">
                                                <label for="favicon" class="form-label">Kepala OPD</label>
                                                <div class="position-relative d-flex justify-content-center">
                                                    <div wire:loading wire:target="favicon"
                                                        class="position-absolute w-100 h-100 top-0 left-0"
                                                        style="width:150px; height:150px;">
                                                        <div class="loading d-flex w-100 h-100 justify-content-center align-items-center gap-2 rounded"
                                                            style="background:rgba(0,0,0,.9)">
                                                            <div class="spinner-border text-light"
                                                                style="width:20px; height:20px;" role="status">
                                                            </div>
                                                            Uploading
                                                        </div>
                                                    </div>
                                                    <input type="file" wire:model="heads_photo"
                                                        class="position-absolute w-100 h-100 top-0 left-0"
                                                        style="cursor: pointer; opacity:0;" title="Change heads_photo"
                                                        accept="image/*" />
                                                    @if ($heads_photo)
                                                    <img class="img img-thumbnail"
                                                        style="width:150px; height:150px;object-fit:contain;"
                                                        src="{{ $heads_photo->temporaryUrl() }}">
                                                    @elseif ($prevHeadsPhoto)
                                                    <img class="img img-thumbnail"
                                                        style="width:150px; height:150px;object-fit:contain;"
                                                        src="{{ asset('storage/identitas/' . $prevHeadsPhoto) }}">
                                                    @else
                                                    <div class="border rounded d-flex justify-content-center align-items-center"
                                                        style="width:150px; height:150px;object-fit:contain;">
                                                        <h3 class="text-center p-2">Kepala OPD</h3>
                                                    </div>
                                                    @endif
                                                </div>
                                                @error('heads_photo')
                                                <span class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-5">
                                                <label for="favicon" class="form-label">Favicon</label>
                                                <div class="position-relative d-flex justify-content-center">
                                                    <div wire:loading wire:target="favicon"
                                                        class="position-absolute w-100 h-100 top-0 left-0"
                                                        style="width:150px; height:150px;">
                                                        <div class="loading d-flex w-100 h-100 justify-content-center align-items-center gap-2 rounded"
                                                            style="background:rgba(0,0,0,.9)">
                                                            <div class="spinner-border text-light"
                                                                style="width:20px; height:20px;" role="status">
                                                            </div>
                                                            Uploading
                                                        </div>
                                                    </div>
                                                    <input type="file" wire:model="favicon"
                                                        class="position-absolute w-100 h-100 top-0 left-0"
                                                        style="cursor: pointer; opacity:0;" title="Change Favicon"
                                                        accept="image/*" />
                                                    @if ($favicon)
                                                    <img class="img img-thumbnail"
                                                        style="width:150px; height:150px;object-fit:contain;"
                                                        src="{{ $favicon->temporaryUrl() }}">
                                                    @elseif ($prevFav)
                                                    <img class="img img-thumbnail"
                                                        style="width:150px; height:150px;object-fit:contain;"
                                                        src="{{ asset('storage/identitas/' . $prevFav) }}">
                                                    @else
                                                    <div class="border rounded d-flex justify-content-center align-items-center"
                                                        style="width:150px; height:150px;object-fit:contain;">
                                                        <h3 class="text-center p-2">Upload Favicon</h3>
                                                    </div>
                                                    @endif
                                                </div>
                                                @error('favicon')
                                                <span class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-5">
                                                <label for="logo" class="form-label">Logo</label>
                                                <div class="position-relative d-flex justify-content-center">
                                                    <div wire:loading wire:target="logo"
                                                        class="position-absolute w-100 h-100 top-0 left-0"
                                                        style="width:150px; height:150px;">
                                                        <div class="loading d-flex w-100 h-100 justify-content-center align-items-center gap-2 rounded"
                                                            style="background:rgba(0,0,0,.9)">
                                                            <div class="spinner-border text-light"
                                                                style="width:20px; height:20px;" role="status">
                                                            </div>
                                                            Uploading
                                                        </div>
                                                    </div>
                                                    <input type="file" wire:model="logo"
                                                        class="position-absolute w-100 h-100 top-0 left-0"
                                                        style="cursor: pointer; opacity:0;" title="Change Logo"
                                                        accept="image/*" />
                                                    @if ($logo)
                                                    <img class="img img-thumbnail"
                                                        style="width:150px; height:150px;object-fit:contain;"
                                                        src="{{ $logo->temporaryUrl() }}">
                                                    @elseif ($prevLogo)
                                                    <img class="img img-thumbnail"
                                                        style="width:150px; height:150px;object-fit:contain;"
                                                        src="{{ asset('storage/identitas/' . $prevLogo) }}">
                                                    @else
                                                    <div class="border rounded d-flex justify-content-center align-items-center"
                                                        style="width:150px; height:150px;object-fit:contain;">
                                                        <h3 class="text-center p-2">Upload Logo</h3>
                                                    </div>
                                                    @endif
                                                </div>
                                                @error('logo')
                                                <span class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <!-- Form field end -->
                                            </div>
                                        </div>
                                        <!-- Row starts -->
                                        <div class="col-xl-6">
                                            <div class="mb-3">
                                                <label for="name_website" class="form-label">Website Name</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-building"></i>
                                                    </span>
                                                    <input type="text" class="form-control @error('name_website') is-invalid @enderror"
                                                        id="name_website" placeholder="Website name" wire:model.defer="name_website">
                                                        @error('name_website')
                                                        <span class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </span>
                                                        @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="heads_name" class="form-label">Kepala Dinas</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-person"></i>
                                                    </span>
                                                    <input type="text" class="form-control @error('heads_name') is-invalid @enderror" id="heads_name"
                                                        placeholder="Kepala Dinas" wire:model.defer="heads_name">
                                                        @error('heads_name')
                                                        <span class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </span>
                                                        @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-envelope"></i>
                                                            </span>
                                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                                                placeholder="Email" wire:model.defer="email">
                                                                @error('email')
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </span>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="mb-3">
                                                        <label for="phone" class="form-label">Phone</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-phone"></i>
                                                            </span>
                                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                                                placeholder="Phone number" wire:model.defer="phone">
                                                                @error('phone')
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </span>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="mb-3">
                                                        <label for="whatsapp" class="form-label">WhatsApp</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-whatsapp"></i>
                                                            </span>
                                                            <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp"
                                                                placeholder="WhatsApp number" wire:model.defer="whatsapp">
                                                                @error('whatsapp')
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </span>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="facebook" class="form-label">Facebook</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-facebook"></i>
                                                            </span>
                                                            <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook"
                                                                placeholder="Facebook URL" wire:model.defer="facebook">
                                                                @error('facebook')
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </span>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="instagram" class="form-label">Instagram</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-instagram"></i>
                                                            </span>
                                                            <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="instagram"
                                                                placeholder="Instagram URL" wire:model.defer="instagram">
                                                                @error('instagram')
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </span>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="twitter" class="form-label">Twitter</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-twitter"></i>
                                                            </span>
                                                            <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="twitter"
                                                                placeholder="Twitter URL" wire:model.defer="twitter">
                                                                @error('twitter')
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </span>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="youtube" class="form-label">YouTube</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">
                                                                <i class="bi bi-youtube"></i>
                                                            </span>
                                                            <input type="text" class="form-control @error('youtube') is-invalid @enderror" id="youtube"
                                                                placeholder="YouTube URL" wire:model.defer="youtube">
                                                                @error('youtube')
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $message }}
                                                                </span>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="map" class="form-label">Map</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-map"></i>
                                                    </span>
                                                    <input type="text" class="form-control @error('map') is-invalid @enderror" id="map"
                                                        placeholder="Google Maps URL" wire:model.defer="map">
                                                        @error('map')
                                                        <span class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </span>
                                                        @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Alamat</label>
                                                <textarea class="form-control @error('address') is-invalid @enderror" id="description" rows="4"
                                                    wire:model.defer="address"></textarea>
                                                    @error('address')
                                                    <span class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="4"
                                                    wire:model.defer="description"></textarea>
                                                    @error('description')
                                                    <span class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <!-- Row ends -->

                                        <!-- Buttons start -->
                                        <div class="d-flex gap-2 justify-content-end mt-4">
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                        </div>
                                        <!-- Buttons end -->
                                </form>
                                <!-- Form end -->

                            </div>
                        </div>
                        <!-- Tab content end -->

                    </div>
                    <!-- Custom tabs end -->

                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->
</div>
