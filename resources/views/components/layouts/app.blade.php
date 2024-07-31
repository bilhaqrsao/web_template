<?php
use App\Models\Utility\IdentityWeb;
use App\Models\Core\Article;
use App\Models\Core\Page;

$identitas = IdentityWeb::first();
$detailArticle = Article::where('slug', request()->segment(2))->first();
$detailPage = Page::where('slug', request()->segment(1))->first();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>{{ $title . ' |' ?? '' }} {{ env('APP_NAME') }}</title>
    <meta name="referrer" content="no-referrer">
    @if (Route::currentRouteName() == 'public.articles.detail')
    <meta name="description" content="{{ $detailArticle->meta_description }}" />
    @elseif (Route::currentRouteName() == 'public.articles.detail')
    <meta name="description" content="{{ $detailPage->meta_title }}" />
    @else
    <meta name="description" content="{{ $identitas->name }}" />
    @endif
    <meta name="keywords" content="Kesbangpol Kabupaten Ogan Ilir">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('storage/identitas/'.$identitas->favicon) }}" type="image/gif" sizes="16x16">
    <!--Styles-->
    <link href="{{ asset('assets/vendor/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/jQuery.mmenu/dist/css/jquery.mmenu.all.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/owl.carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/owl.carousel/dist/assets/owl.theme.default.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/revolution/css/layers.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/revolution/css/navigation.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/revolution/css/settings.css')}}" rel="stylesheet">
    <!-- Fonts-->
    <link href="{{ asset('assets/fonts/open-sans/css/open-sans.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fonts/Linearicons-Free-v1.0.0/style.css')}}">
    <!--Theme style-->
    <link href="{{ asset('assets/css/main.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Header main-->
    @livewire('public.components.header')
    <!-- End header main-->
    {{ $slot }}
    <!-- FOOTER-->
    @livewire('public.components.footer')
    <!-- END FOOTER-->
    <!--Scripts-->
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/jQuery.mmenu/dist/js/jquery.mmenu.min.umd.js')}}"></script>
    <script src="{{ asset('assets/js/mmenu-function.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
    <script src="{{ asset('assets/js/gmap.js')}}"></script>
    <script src="{{ asset('assets/vendor/owl.carousel/dist/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/js/owl-custom.js')}}"></script>
    <script src="{{ asset('assets/vendor/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>
    <script src="{{ asset('assets/js/revo-custom.js')}}"></script>
    <script src="{{ asset('assets/vendor/matchHeight/dist/jquery.matchHeight-min.js')}}"></script>
    <script src="{{ asset('assets/js/match-height-custom.js')}}"></script>
    <script src="{{ asset('assets/js/custom.js')}}"></script>
    <script type="text/javascript" src="https://widget.kominfo.go.id/gpr-widget-kominfo.min.js"></script>
    <!--End script-->
</body>

</html>
