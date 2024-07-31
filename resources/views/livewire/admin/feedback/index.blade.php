<div>
    {{-- In work, do what you enjoy. --}}
    <!-- App hero header starts -->
    <div class="app-hero-header d-flex align-items-start">

        <!-- Breadcrumb start -->
        <div class="search-container d-lg-flex d-none">
            <input type="text" wire:model.live="search" class="form-control" id="searchData" placeholder="Search">
            <i class="bi bi-search"></i>
        </div>
    </div>
    <!-- App Hero header ends -->

    <!-- App body starts -->
    <div class="app-body">

        <!-- Row start -->
        <div class="row gx-3">
            <div class="col-xxl-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-outer">
                                <table class="table align-middle table-hover m-0">
                                    <thead>
                                        <tr>
                                            <th width="80px">No</th>
                                            <th width="400px">Nama</th>
                                            <th>telephone</th>
                                            <th>email</th>
                                            <th>alamat</th>
                                            <th>Tanggal</th>
                                            <th>*</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($datas as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->telephone }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->alamat }}</td>
                                            <td>{{ Carbon\Carbon::parse($data->created_at)->IsoFormat('dddd, D MMMM Y') }}</td>
                                            <td>
                                                @if ($data->status == 'Publish')
                                                <button wire:click="changeStatus({{ $data->id }})"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @else
                                                <button wire:click="changeStatus({{ $data->id }})"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                                @endif
                                                <button wire:click="modalMessage({{ $data->id }})" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalMessage">
                                                    <i class="bi bi-chat-left-text"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- App body ends -->

    {{-- modal message --}}
    <div class="modal fade" id="modalMessage" tabindex="-1" aria-labelledby="modalMessageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMessageLabel">Pesan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- text area disable messages --}}
                    <textarea class="form-control" id="message" rows="10" disabled>{{ $pesan }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
