<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="page-content project-list-page">
        <!-- HEADING PAGE-->
        <section class="heading-page heading-services-detail-1"
            style="background: url(&quot;img/2.png&quot;) center center no-repeat;">
            <div class="container">
                <ul class="au-breadcrumb">
                    <li class="au-breadcrumb-item">
                        <a href="{{ route('public.index') }}">Home</a>
                    </li>
                    <li class="au-breadcrumb-item active">
                        <a href="#">Berita</a>
                    </li>
                </ul>
                <div class="heading-title">
                    <h1>Daftar Berita Badan Kesbangpol Kab. Ogan Ilir</h1>
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
                            @forelse ($datas as $data)
                            <div class="blog-item">
                                <div class="blog-image">
                                    <img class="img-responsive" src="{{ asset('storage/article/'.$data->thumbnail) }}"
                                        alt="Life Insurance Charges" />
                                </div>
                                <div class="blog-main">
                                    <div class="blog-title">
                                        <a href="{{ route('public.articles.detail',$data->slug) }}">{{ Str::limit($data->title, 50) }}</a>
                                    </div>
                                    <div class="blog-subtitle">
                                        <div class="blog-topic">
                                            <a href="#"><i class="fa fa-eye"></i> {{ $data->view_count }}</a>
                                        </div>
                                        <div class="blog-date">
                                            <span>Posted by: {{ $data->Author->username }} | {{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}, {{ Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        <p>{{ Str::limit($data->description, 90) }}</p>
                                    </div>
                                    <div class="blog-link">
                                        <a href="{{ route('public.articles.detail',$data->slug) }}">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="blog-item">
                                <div class="blog-main">
                                    <div class="blog-title">
                                        <a href="#">Data tidak ditemukan</a>
                                    </div>
                                </div>
                            </div>
                            @endforelse

                            {{ $datas->links('vendor.pagination.public') }}
                        </div>
                        <!-- END BLOG LIST-->
                    </div>
                    @livewire('public.components.sidebar')
                </div>
            </div>
        </section>
        <!-- END PROJECT LIST-->
    </div>
</div>
