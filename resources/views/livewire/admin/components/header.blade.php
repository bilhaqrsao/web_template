<div class="app-header">

    <!-- Toggle buttons start -->
    <div class="d-flex">
        <button class="btn btn-outline-info btn-sm me-3 toggle-sidebar" id="toggle-sidebar">
            <i class="bi bi-list fs-5"></i>
        </button>
        <button class="btn btn-outline-info btn-sm me-3 pin-sidebar" id="pin-sidebar">
            <i class="bi bi-list fs-5"></i>
        </button>
    </div>
    <!-- Toggle buttons end -->

    <!-- App brand start -->
    <div class="app-brand-sm">
        <a href="index.html" class="d-lg-none d-md-block">
            <img src="{{ asset('images/logo-bilhaq.png') }}" class="logo" alt="Bootstrap Gallery">
        </a>
    </div>
    <!-- App brand end -->

    <!-- App header actions start -->
    <div class="header-actions gap-3">

        <!-- Search container starts -->
        {{-- <div class="search-container d-lg-flex d-none">
            <input type="text" class="form-control" id="searchData" placeholder="Search">
            <i class="bi bi-search"></i>
        </div> --}}
        <!-- Search container ends -->

        <!-- Header settings starts -->
        <div class="dropdown">
            <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none" href="#!"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="icon-box md bg-info text-white rounded-5">{{ $user->username }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item d-flex align-items-center" href="#!"><i
                        class="bi bi-person fs-4 me-2"></i>Profile</a>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('public.logout') }}"><i
                        class="bi bi-escape fs-4 me-2"></i>Logout</a>
                @if (session('impersonated_by'))
                <a class="dropdown-item d-flex align-items-center" wire:click="leaveImpersonation()" href="#!"><i
                        class="bi-box-arrow-in-right fs-4 me-2"></i>Impersonate</a>
                @endif
            </div>
        </div>
        <!-- Header settings starts -->

    </div>
    <!-- App header actions end -->

</div>
