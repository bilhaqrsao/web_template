<?php
    use App\Models\Utility\IdentityWeb;
    $identitas = IdentityWeb::first();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? '' }} - {{ env('APP_NAME') }}</title>

    <!-- Meta -->
    <meta name="description" content="Marketplace for Bootstrap Admin Dashboards" />
    <meta name="author" content="Bootstrap Gallery" />
    <link rel="canonical" href="https://www.bootstrap.gallery/">
    <meta property="og:url" content="https://www.bootstrap.gallery">
    <meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
    <meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:type" content="Website">
    <meta property="og:site_name" content="Bootstrap Gallery">
    <link rel="shortcut icon" href="{{ asset('storage/identitas/'.$identitas->favicon) }}" />

    <!-- *************
			************ CSS Files *************
		************* -->
    <link rel="stylesheet" href="{{ asset('admin_assets/fonts/bootstrap/bootstrap-icons.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/main.min.css')}}" />

    <!-- *************
			************ Vendor Css Files *************
		************ -->

    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="{{ asset('admin_assets/vendor/overlay-scroll/OverlayScrollbars.min.css')}}" />

    <!-- Toastify CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('admin_assets/vendor/toastify/toastify.css')}}" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.css">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendor/daterange/daterange.css') }}" />
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.1/ckeditor5.css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    @livewireStyles
    @stack('styles')
</head>

<body>
    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Main container start -->
        <div class="main-container">

            <!-- Sidebar wrapper start -->
            @livewire('admin.components.sidebar')
            <!-- Sidebar wrapper end -->

            <!-- App container starts -->
            <div class="app-container">

                <!-- App header starts -->
                @livewire('admin.components.header')
                <!-- App header ends -->

                {{ $slot }}

                <!-- App footer start -->
                @livewire('admin.components.footer')
                <!-- App footer end -->

            </div>
            <!-- App container ends -->

        </div>
        <!-- Main container end -->

    </div>
    <!-- Page wrapper end -->

    <!-- *************
			************ JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="{{ asset('admin_assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('admin_assets/js/bootstrap.bundle.min.js')}}"></script>

    <!-- *************
			************ Vendor Js Files *************
		************* -->

    <!-- Overlay Scroll JS -->
    <script src="{{ asset('admin_assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/overlay-scroll/custom-scrollbar.js')}}"></script>

    <!-- Toastify JS -->
    {{-- <script src="{{ asset('admin_assets/vendor/toastify/toastify.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/toastify/custom.js')}}"></script> --}}

    <!-- Apex Charts -->
    <script src="{{ asset('admin_assets/vendor/apex/apexcharts.min.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/apex/custom/dash1/visitors.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/apex/custom/dash1/sales.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/apex/custom/dash1/orders.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/apex/custom/dash1/sparkline.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/apex/custom/dash1/tasks.js')}}"></script>

    <!-- Vector Maps -->
    <script src="{{ asset('admin_assets/vendor/jvectormap/jquery-jvectormap-2.0.5.min.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/jvectormap/gdp-data.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/jvectormap/us_aea.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/jvectormap/usa.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/jvectormap/custom/map-usa4.js')}}"></script>

    <!-- Custom JS files -->
    <script src="{{ asset('admin_assets/js/custom.js')}}"></script>

    <!-- Date Range JS -->
    <script src="{{ asset('admin_assets/vendor/daterange/daterange.js')}}"></script>
    <script src="{{ asset('admin_assets/vendor/daterange/custom-daterange.js')}}"></script>

    <!-- Additional -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

    </script>
    <script>
        window.addEventListener('closeModal', event => {
            $('#exampleModalCenter').modal('hide');
            $('.modal-backdrop').remove();
        });
    </script>
    <script>
         window.addEventListener('closeModal', event => {
            $('.modal').modal('hide');
            $('.modal-backdrop').remove();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
