<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
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
                        <!-- BLOG DETAIL-->
                        <section class="blog-single">
                            <div class="post-title">
                                <h1>{{ $data->title }}</h1>
                            </div>
                            <div class="post-info">
                                <div class="post-date">
                                    <span>Posted by: {{ $data->Author->username }} |
                                        {{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }},
                                        {{ Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</span>
                                </div>
                            </div>
                            <div class="post-image">
                                <img class="img-responsive" src="{{ asset('storage/pengumuman/'.$data->image) }}" alt="Blog Single" />
                            </div>
                            <div class="post-paragraph">
                                <div class="post-content" style="margin-top: 20px;">
                                    <p>
                                        {!! $data->content !!}
                                    </p>
                                </div>
                            </div>
                            <div class="post-footer">
                                <div class="post-tags">
                                    <span>Tags:</span>
                                    @forelse ($tags as $tag)
                                    <a href="{{ route('public.tags.detail',$tag->getTags->slug) }}" target="_blank">{{ $tag->getTags->name }}</a>,
                                    @empty

                                    @endforelse
                                </div>
                                <div class="post-share">
                                    <span>Bagikan Berita:</span>
                                    <a href="#">Facebook</a>,
                                    <a href="#">Twitter</a>,
                                    <a href="#">Google+</a>
                                </div>
                            </div>
                            <div class="post-more-link">
                                <div class="post-prev">
                                    <div class="link">
                                        <a href="#">
                                            <i class="fa fa-angle-double-left"></i>Preview</a>
                                    </div>
                                    <div class="title">
                                        <h4>Judul Berita Sebelumnya</h4>
                                    </div>
                                </div>
                                <div class="post-next">
                                    <div class="link">
                                        <a href="#">Next
                                            <i class="fa fa-angle-double-right"></i>
                                        </a>
                                    </div>
                                    <div class="title">
                                        <h4>Judul Berita Selanjutnya</h4>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- END BLOG DETAIL-->
                    </div>
                    @livewire('public.components.sidebar')
                </div>
            </div>
        </section>
        <!-- END PROJECT LIST-->
    </div>
</div>
