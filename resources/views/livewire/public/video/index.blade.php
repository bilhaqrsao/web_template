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
                    <h1>Galeri Video {{ $identitas->name_website }}</h1>
                </div>
            </div>
        </section>
        <!-- END HEADING PAGE-->
        <!-- PROJECT LIST-->
        <section class="projects-layout">
            <div class="container">
                <div class="row isotope-grid">
                    @forelse ($datas as $data)
                    <div class="col-md-4 col-sm-6 col-xs-12 isotope-item Retirement">
                        <div class="project-item match-item">
                            <div class="project-item-img">
                               <img src="https://i.ytimg.com/vi/{{ $data->yt_id }}/hq720.jpg" alt="" style="width: auto; height: 250px">
                            </div>
                            <div class="project-item-title">
                                <a href="{{ route('public.videos.detail',$data->slug) }}">{{ $data->title }}</a>
                            </div>
                            <div class="project-item-subjects">
                                <p>{{ $data->description }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-md-12">
                        <div class="alert alert-warning" role="alert">
                            <strong>Informasi!</strong> Belum ada data yang tersedia.
                        </div>
                    </div>
                    @endforelse
                    {{ $datas->links('vendor.pagination.public') }}
                </div>
            </div>
        </section>
        <!-- END PROJECT LIST-->
    </div>
</div>
