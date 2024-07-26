<div>
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">
        <!-- Breadcrumb start -->
        <ol class="breadcrumb d-none d-lg-flex">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1"></i>
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Buat Artikel</li>
        </ol>
    </div>

    <!-- App body starts -->
    <div class="app-body">
        <!-- Row starts -->
        <div class="row gx-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Buat Artikel</h5>
                    </div>
                    <div class="card-body">
                        <!-- Row starts -->
                        <div class="row gx-3">
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="mb-5">
                                    <div class="position-relative d-flex justify-content-center">
                                        <div wire:loading wire:target="thumbnail"
                                            class="position-absolute w-100 h-100 top-0 left-0"
                                            style="width:150px; height:150px;">
                                            <div class="loading d-flex w-100 h-100 justify-content-center align-items-center gap-2 rounded"
                                                style="background:rgba(0,0,0,.9)">
                                                <div class="spinner-border text-light" style="width:20px; height:20px;"
                                                    role="status">
                                                </div>
                                                Uploading
                                            </div>
                                        </div>
                                        <input type="file" wire:model="thumbnail"
                                            class="position-absolute w-100 h-100 top-0 left-0"
                                            style="cursor: pointer; opacity:0;" title="Change thumbnail"
                                            accept="image/*" />
                                        @if ($thumbnail)
                                        <img class="img img-thumbnail"
                                            style="width:150px; height:150px;object-fit:contain;"
                                            src="{{ $thumbnail->temporaryUrl() }}">
                                        @else
                                        <div class="border rounded d-flex justify-content-center align-items-center"
                                            style="width:150px; height:150px;object-fit:contain;">
                                            <h3 class="text-center p-2">Thumbnail</h3>
                                        </div>
                                        @endif
                                    </div>
                                    @error('thumbnail')
                                    <span class="invalid-feedback d-block">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 col-sm-4 col-12">
                                <div class="mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" wire:model.lazy="title"
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        placeholder="Masukan Title Halaman">
                                    @error('title')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="url">URL</label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text">{{ route('public.index') }}/berita/</span>
                                                <input type="text" wire:model="url" class="form-control" id="url"
                                                    placeholder="URL" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta_title">Meta Title</label>
                                            <div class="input-group">
                                                <input type="text" wire:model="meta_title"
                                                    class="form-control @error('meta_title') is-invalid @enderror"
                                                    id="meta_title" placeholder="Meta Title" disabled>
                                                @error('meta_title')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="description">Deskripsi</label>
                                            <div class="input-group">
                                                <textarea type="text" wire:model="description"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    id="description" placeholder="description" />
                                                </textarea>
                                                @error('description')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="created_at">Pilih Tanggal Publikasi</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="bi bi-calendar4"></i>
                                                </span>
                                                <input type="date" wire:model.defer="created_at" id="created_at"
                                                    class="form-control datepicker-time-24 @error('created_at') is-invalid @enderror" />
                                                @error('created_at')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="created_at">Pilih Draft / Publikasi</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault" wire:model="isPublished" />
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckDefault">Publish</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3" wire:ignore>
                                            <label class="form-label" for="tags">Tags</label>
                                            <select id="tags" class="form-control" multiple="multiple"
                                                wire:model="tags">
                                                @foreach($existingTags as $tag)
                                                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('tags') <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="mb-3" wire:ignore>
                                    <label class="form-label" for="content">Konten</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                        id="summernote" wire:model.defer="content"></textarea>
                                    @error('content')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-outline-secondary">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-primary" wire:click="store">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $("#summernote").summernote({
            placeholder: 'Masukan konten disini',
            height: 300,
            toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
                ['insert', ['link', 'picture', 'video', 'hr']],
                ['view', ['codeview', 'help']],
                ['misc', ['undo', 'redo']]
            ],
            dialogsInBody: true,
            callbacks: {
                onBlur: function (contents, $editable) {
                    var value = $(this).val();
                    @this.set('content', value);
                },
                onBlurCodeview: function (contents, $editable) {
                    var value = $(this).val();
                    @this.set('content', value);
                },
            }
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('#tags').select2({
            tags: true,
            tokenSeparators: [',', ' ']
        }).on('change', function (e) {
            @this.set('tags', $(this).val());
        });
    });

</script>
@endpush
