<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="page-content project-list-page">
        <!-- HEADING PAGE-->
        <section class="heading-page heading-services-detail-1"
            style="background: url(&quot;img/2.png&quot;) center center no-repeat;">
            <div class="container">
                <ul class="au-breadcrumb">
                    <li class="au-breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="au-breadcrumb-item active">
                        <a href="#">Berita</a>
                    </li>
                </ul>
                <div class="heading-title">
                    <h1>Detail Berita</h1>
                </div>
            </div>
        </section>
        <!-- END HEADING PAGE-->
        <!-- PROJECT LIST-->
        <section class="blog-single">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <!-- BLOG LIST-->
                        <div class="blog-list-wrapper">
                            @forelse ($pengumumans as $pengumuman)
                            <div class="blog-item">
                                <div class="blog-image">
                                    <img class="img-responsive" src="{{ asset('storage/pengumuman/'.$pengumuman->image) }}"
                                        alt="Life Insurance Charges" />
                                </div>
                                <div class="blog-main">
                                    <div class="blog-title">
                                        <a href="{{ route('public.pengumumans.detail',$pengumuman->slug) }}">{{ $pengumuman->title }}</a>
                                    </div>
                                    <div class="blog-subtitle">
                                        <div class="blog-date">
                                            <span>Posted by: {{ $pengumuman->Author->username }} | {{ Carbon\Carbon::parse($pengumuman->created_at)->diffForHumans() }}, {{ Carbon\Carbon::parse($pengumuman->created_at)->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        <p>{!! Str::limit($pengumuman->content, 50) !!}</p>
                                    </div>
                                    <div class="blog-link">
                                        <a href="{{ route('public.pengumumans.detail',$pengumuman->slug) }}">Baca Selengkapnya</a>
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

                            {{ $pengumumans->links('vendor.pagination.public') }}
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
