<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="page-content project-list-page">
        <!-- HEADING PAGE-->
        <section class="heading-page heading-services-detail-1"
            style="background: url(&quot;{{ asset('assets/img/2.png') }}&quot;) center center no-repeat;">
            <div class="container">
                <ul class="au-breadcrumb">
                    <li class="au-breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="au-breadcrumb-item active">
                        <a href="#">Galeri Video</a>
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
                    <div class="col-md-12 col-sm-12 col-xs-12 isotope-item Retirement">
                        <div class="project-item match-item">
                            <div class="project-item-img">
                                <iframe src="https://www.youtube.com/embed/{{ $data->yt_id }}"
                                    title="YouTube video player" frameborder="0" style="width: 100%; height: 700px"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END PROJECT LIST-->
    </div>
</div>
