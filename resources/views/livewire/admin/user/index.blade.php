<div>
    {{-- Do your work, then step back. --}}
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Pengguna</h5>
                    <div class="card-toolbar mt-3">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-plus me-1"></i>Tambah Pengguna
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-outer">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <td>Nama</td>
                                        <td>Role</td>
                                        <td>Email</td>
                                        <td>Phone</td>
                                        <td>Status</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $data)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="@if ($data->photo == null) {{ asset('admin_assets/images/user3.png') }} @else {{ asset('storage/user/' . $data->photo) }} @endif"
                                                    class="img-3xx rounded-5 me-3" alt="Bootstrap Gallery" />
                                                <p class="m-0">{{ $data->name }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($data->HasRole('admin'))
                                            <span class="badge bg-primary">Admin</span>
                                            @elseif ($data->HasRole('developer'))
                                            <span class="badge bg-success">Developer</span>
                                            @elseif($data->HasRole('user'))
                                            <span class="badge bg-secondary">User</span>
                                            @elseif($data->HasRole('super-admin'))
                                            <span class="badge bg-info">Super Admin</span>
                                            @else
                                            <span class="badge bg-warning">No Role</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $data->email }}
                                        </td>
                                        <td>
                                            {{ $data->phone }}
                                        </td>
                                        <td>
                                            @if ($data->status == 'Active')
                                            <span class="badge bg-success">Active</span>
                                            @else
                                            <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="edit({{ $data->id }})" class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-secondary"
                                                wire:click="changeStatus({{ $data->id }})">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" wire:click="destroy({{ $data->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            @if (auth()->user()->hasRole('developer'))
                                            <button class="btn btn-sm btn-warning"
                                                wire:click="impersonate({{ $data->id }})">
                                                {{-- icon in dor --}}
                                                <i class="bi-box-arrow-in-left"></i>
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No data found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- paginate -->
                        {{ $users->links('pagination::one') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @if ($updateMode == false)
                        Tambah Pengguna
                        @else
                        Edit Pengguna
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @if ($updateMode==false) wire:submit.prevent="store" @else wire:submit.prevent="update"
                        @endif>
                        @if ($updateMode == false)
                        @if ($photo == null)
                        <div class="text-center">
                            <img src="{{ asset('admin_assets/images/user3.png') }}" class="img-3xx rounded-5 me-3"
                                alt="Bootstrap Gallery" />
                        </div>
                        @elseif ($photo)
                        <div class="text-center">
                            <img src="{{ $photo->temporaryUrl() }}" class="img-3xx rounded-5 me-3"
                                alt="Bootstrap Gallery" />
                        </div>
                        @endif
                        @elseif ($updateMode == true)
                        @if ($photo)
                        <div class="text-center">
                            <img src="{{ $photo->temporaryUrl() }}" class="img-3xx rounded-5 me-3"
                                alt="Bootstrap Gallery" />
                        </div>
                        @else
                        <div class="text-center">
                            <img src="{{ asset('storage/user/'.$prevPhoto) }}" class="img-3xx rounded-5 me-3"
                                alt="Bootstrap Gallery" />
                        </div>
                        @endif
                        @endif
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>

                            <input class="form-control" type="file" id="formFile" wire:model="photo"
                                accept="image/x-png,image/gif,image/jpeg" />
                            <small class="text-muted">Max 2MB</small>
                            @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" class="form-control" wire:model="username">
                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" wire:model="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" wire:model="phone">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" wire:model="password">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Store</label>
                            <select class="form-select" wire:model="store_id">
                                <option value="">Pilih Store</option>
                                @foreach ($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                            @error('store_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" wire:model="role">
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            @if ($updateMode == false)
                            Simpan
                            @else
                            Update
                            @endif
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInput">
                            Close
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
