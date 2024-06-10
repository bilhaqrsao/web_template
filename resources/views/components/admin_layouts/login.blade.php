<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>

    <!-- Meta -->
    <meta name="description" content="Marketplace for Bootstrap Admin Dashboards" />
    <meta name="author" content="Bootstrap Gallery" />
    <link rel="canonical" href="https://www.bootstrap.gallery/">
    <meta property="og:url" content="https://www.bootstrap.gallery">
    <meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
    <meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:type" content="Website">
    <meta property="og:site_name" content="Bootstrap Gallery">
    <link rel="shortcut icon" href="{{ asset('images/logo.png')}}" />

    <!-- *************
			************ CSS Files *************
		************* -->
    <link rel="stylesheet" href="{{ asset('admin_assets/fonts/bootstrap/bootstrap-icons.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/main.min.css')}}" />

</head>

<body>

    <!-- Page wrapper starts -->
    <div class="page-wrapper">

        <!-- Auth container starts -->
        <div class="auth-container">

            {{ $slot }}

        </div>
        <!-- Auth container ends -->

    </div>
    <!-- Page wrapper ends -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <!-- BEGIN: Livewire-->
    @livewireScripts
</body>

</html>
