<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
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
                        <a href="#">Galeri Foto</a>
                    </li>
                </ul>
                <div class="heading-title">
                    <h1>Galeri Foto Badan Kesbangpol Kab. Ogan Ilir</h1>
                </div>
            </div>
        </section>
        <!-- END HEADING PAGE-->
        <!-- PROJECT LIST-->
        <section class="projects-layout">
            <div class="container">
                <div class="row isotope-grid">
                    @forelse ($datas as $data)
                    @php
                    $images = json_decode($data->images, true);
                    $randomImage = $images[array_rand($images)];
                    @endphp
                    <div class="col-md-4 col-sm-6 col-xs-12 isotope-item Retirement">
                        <div class="project-item match-item">
                            <div class="project-item-img">
                                <img class="img-responsive" src="{{ asset('storage/gallery/'.$randomImage) }}" alt="project-1.jpg" />
                            </div>
                            <div class="project-item-title">
                                <a href="{{ route('public.galleries.detail',$data->slug) }}">{{ Str::limit($data->title, 30) }}</a>
                            </div>
                            <div class="project-item-subjects">
                                <p>{{ Str::limit($data->description, 50) }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- strong gallery tidak ada --}}
                    <div class="col-md-12 col-sm-12 col-xs-12 isotope-item Retirement">
                        <strong>Galeri tidak ada</strong>
                    </div>
                    @endforelse
                </div>
                {{ $datas->links('vendor.pagination.public') }}
            </div>
        </section>
        <!-- END PROJECT LIST-->
    </div>
</div>
