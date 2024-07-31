<div class="page-content project-list-page">
    <!-- HEADING PAGE-->
    <section class="heading-page heading-services-detail-1"
        style="background: url(&quot;{{ asset('assets/img/2.png')}}&quot;) center center no-repeat;">
        <div class="container">
            <ul class="au-breadcrumb">
                <li class="au-breadcrumb-item">
                    <a href="{{ route('public.index') }}">Home</a>
                </li>
                <li class="au-breadcrumb-item active">
                    <a href="#">Halaman</a>
                </li>
            </ul>
            <div class="heading-title">
                <h1>{{ $page->title }}</h1>
            </div>
        </div>
    </section>
    <!-- END HEADING PAGE-->
    <!-- PROJECT LIST-->
    <section class="projects-layout">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <!-- BLOG LIST-->
                    <div class="blog-list-wrapper">
                        <div class="blog-item">
                            @if ($page->thumbnail != null)
                            <div class="col-sm-12">
                                <div class="gallery-item">
                                    <a class="popup-gallery-item" href="{{ asset('storage/page/'.$page->thumbnail) }}">
                                        <img src="{{ asset('storage/page/'.$page->thumbnail) }}" alt="gallery img">
                                    </a>
                                </div><!-- /.gallery-item -->
                            </div><!-- /.col-sm-6 -->
                            @endif
                            <div class="row mx-md-n5">
                                <div class="col px-md-5">
                                    <div class="p-3 border bg-light mt-5">
                                        <p>{!! $page->content !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END BLOG LIST-->
                </div>
                @livewire('public.components.sidebar')
            </div>
        </div>
    </section>
    <!-- END PROJECT LIST-->
</div>
