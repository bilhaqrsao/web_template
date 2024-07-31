<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="page-content project-list-page">
        <!-- HEADING PAGE-->
        <section class="heading-page heading-services-detail-1"
            style="background: url(&quot;{{ asset('assets/img/2.png') }}&quot;) center center no-repeat;">
            <div class="container">
                <ul class="au-breadcrumb">
                    <li class="au-breadcrumb-item">
                        <a href="{{ route('public.index') }}">Home</a>
                    </li>
                    <li class="au-breadcrumb-item">
                        <a href="{{ route('public.galleries') }}">Galeri Foto</a>
                    </li>
                    <li class="au-breadcrumb-item active">
                        <a href="#">Detail Galeri Foto</a>
                    </li>
                </ul>
                <div class="heading-title">
                    <h1>{{ $data->title }}</h1>
                </div>
            </div>
        </section>
        <!-- END HEADING PAGE-->
        <!-- PROJECT LIST-->
        <section class="projects-layout">
            <div class="container">
                <div class="row isotope-grid">
                    @foreach(json_decode($data->images) as $key => $image)
                    <div class="col-md-4 col-sm-6 col-xs-12 isotope-item Retirement">
                        <div class="project-item match-item">
                            <div class="project-item-img">
                                <img class="img-responsive" src="{{ asset('storage/gallery/' . $image) }}" alt="project-1.jpg" />
                            </div>
                            <div class="project-item-subjects">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- END PROJECT LIST-->
    </div>
    <style>
        footer {
            display: none;
        }
    </style>
</div>
