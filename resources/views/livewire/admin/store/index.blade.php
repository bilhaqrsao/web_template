<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="app-hero-header d-flex align-items-start">

        <!-- Breadcrumb start -->
        <ol class="breadcrumb d-none d-lg-flex">
            <li class="breadcrumb-item">
                <i class="bi bi-house lh-1"></i>
                <a href="index.html" class="text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                {{-- jika ada kata toko maka tidak perlu ada tulisan toko --}}
                {{ $data->name }}
            </li>
        </ol>
        <!-- Breadcrumb end -->

    </div>
    <div class="app-body">

        <!-- Row start -->
        <div class="row justify-content-center">
            <div class="col-xxl-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Row start -->
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="{{ asset('storage/store/logo/'.$data->logo ?? 'default.jpg') }}" class="img-5xx rounded-circle"
                                    alt="Bootstrap Gallery" />
                            </div>
                            <div class="col">
                                {{-- <h6 class="text-primary">UX Designer</h6> --}}
                                <h4 class="m-0">{{ $data->name ?? '' }}</h4>
                            </div>
                            <div class="col-12 col-md-auto">
                               {{-- telephone --}}
                                <a href="tel:{{ $data->telephone ?? '' }}" target="_blank" class="btn btn-primary">
                                    <i class="bi bi-telephone"></i> Call
                                </a>
                                {{-- whatsapp --}}
                                <a href="https://wa.me/{{ $data->telephone ?? '' }}" target="_blank" class="btn btn-success">
                                    <i class="bi bi-whatsapp"></i> Whatsapp
                                </a>
                                {{-- email --}}
                                <a href="mailto:{{ $data->email ?? '' }}" target="_blank" class="btn btn-danger">
                                    <i class="bi bi-envelope"></i> Email
                                </a>
                            </div>
                        </div>
                        <!-- Row end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->

        <!-- Row start -->
        <div class="row gx-3">
            <div class="col-xxl-3 col-sm-6 col-12 order-xxl-1 order-xl-2 order-lg-2 order-md-2 order-sm-2">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">About</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="d-flex align-items-center mb-3">
                            <i class="bi bi-house fs-2 me-2"></i>
                            <span> {{ $data->address ?? '' }}</span>
                        </h6>
                        <h6 class="d-flex align-items-center mb-3">
                            <i class="bi bi-building fs-2 me-2"></i>
                            <span>{{ $data->city ?? '' }}</span>
                        </h6>
                        <h6 class="d-flex align-items-center mb-3">
                            <i class="bi bi-globe-americas fs-2 me-2"></i>
                            <a href="{{ $data->website ?? '' }}" target="_blank">
                                {{ $data->website ?? '' }}
                            </a>
                        </h6>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Earnings</h5>
                    </div>
                    <div class="card-body">
                        <div id="sales"></div>
                        <div class="text-center my-4">
                            <h1 class="fw-bold">
                                865
                                <i class="bi bi-arrow-up-right-circle-fill text-success"></i>
                            </h1>
                            <p class="fw-light m-0">21% higher than last month</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-sm-12 col-12 order-xxl-2 order-xl-1 order-lg-1 order-md-1 order-sm-1">
                <div class="card mb-3">
                    <div class="card-img">
                        <img src="{{ asset('storage/store/banner/'.$data->banner ?? 'default.jpg') }}" class="card-img-top img-fluid"
                            alt="Bootstrap Dashboards" />
                    </div>
                    <div class="card-body">
                        <p class="mb-3">
                            {{ $data->description ?? '' }}
                        </p>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('admin_assets/images/user.png') }}" class="rounded-circle me-3 img-4x"
                                alt="Bootstrap Admin" />
                            <h6 class="m-0">Ilyana Maesi</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6 col-12 order-xxl-3 order-xl-3 order-lg-3 order-md-3 order-sm-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Gallery</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 row-cols-3">
                            @forelse ($products as $item)
                                <div class="col">
                                    <img src="{{ asset('storage/product/'.$item->image ?? 'default.jpg') }}" class="img-fluid rounded-2"
                                        alt="" />
                                </div>
                            @empty
                            {{-- belum ada product --}}
                                <div class="col">
                                    <div class="text-center">
                                        <div class="text-center">
                                            <h6 class="m-0">No Product</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="scroll350">
                            <div class="my-2">
                                @forelse ($activities as $log)
                                <div class="activity-block d-flex position-relative">
                                    <img src="assets/images/user2.png" class="img-4x me-3 rounded-circle activity-user"
                                        alt="Admin Dashboard" />
                                    <div class="mb-3">
                                        <h5>Sophie Michiels</h5>
                                        <p class="m-0">3 day ago</p>
                                        <p>Paid invoice ref. #26788</p>
                                        <span class="badge bg-info">Sent</span>
                                    </div>
                                </div>
                                @empty
                                {{-- tidak ada aktifitas --}}
                                <div class="text-center">
                                    <h6 class="m-0">Tidak ada aktifitas</h6>
                                </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->

    </div>
</div>
