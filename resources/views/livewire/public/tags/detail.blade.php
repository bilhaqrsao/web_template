<div>
    <div class="page-content project-list-page">
        <!-- HEADING PAGE-->
        <section class="heading-page heading-services-detail-1" style="background: url(&quot;img/2.png&quot;) center center no-repeat;">
            <div class="container">
                <ul class="au-breadcrumb">
                    <li class="au-breadcrumb-item">
                        <a href="{{ route('public.index') }}">Home</a>
                    </li>
                    <li class="au-breadcrumb-item active">
                        {{-- <a href="#">{{ $tag->name }}</a> --}}
                    </li>
                </ul>
            </div>
        </section>
        <!-- END HEADING PAGE-->

        <!-- PROJECT LIST-->
        <section class="projects-layout">
            <div class="container">
                <div class="row">
                    <!-- Articles -->
                    <div class="col-md-4">
                        <!-- BLOG LIST-->
                        <div class="blog-list-wrapper">
                            @forelse ($tags as $article)
                            <div class="blog-item">
                                <div class="blog-image">
                                    <img class="img-responsive" src="{{ asset('storage/article/'.$article->getArticles->thumbnail) }}" alt="Article Thumbnail" />
                                </div>
                                <div class="blog-main">
                                    <div class="blog-title">
                                        <a href="{{ route('public.articles.detail', $article->getArticles->slug) }}">{{ Str::limit($article->getArticles->title, 50) }}</a>
                                    </div>
                                    <div class="blog-subtitle">
                                        <div class="blog-topic">
                                            <a href="#"><i class="fa fa-eye"></i> {{ $article->getArticles->view_count }}</a>
                                        </div>
                                        <div class="blog-date">
                                            <span>Posted by: {{ $article->getArticles->author->username }} | {{ $article->getArticles->created_at->diffForHumans() }}, {{ $article->getArticles->created_at->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        <p>{{ Str::limit($article->getArticles->description, 90) }}</p>
                                    </div>
                                    <div class="blog-link">
                                        <a href="{{ route('public.articles.detail', $article->getArticles->slug) }}">Baca Selengkapnya</a>
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

                            {{-- {{ $articles->links('vendor.pagination.public') }} --}}
                        </div>
                        <!-- END BLOG LIST-->
                    </div>

                    <!-- Pengumumans -->
                    <div class="col-md-6">
                        <!-- BLOG LIST-->
                        <div class="blog-list-wrapper">
                            @forelse ($tagsPengumuman as $pengumuman)
                            <div class="blog-item">
                                <div class="blog-image">
                                    <img class="img-responsive" src="{{ asset('storage/pengumuman/'.$pengumuman->getPengumumans->image) }}" alt="Pengumuman Thumbnail" />
                                </div>
                                <div class="blog-main">
                                    <div class="blog-title">
                                        <a href="{{ route('public.pengumumans.detail', $pengumuman->getPengumumans->slug) }}">{{ Str::limit($pengumuman->getPengumumans->title, 50) }}</a>
                                    </div>
                                    <div class="blog-subtitle">
                                        <div class="blog-topic">
                                            <a href="#"><i class="fa fa-eye"></i> {{ $pengumuman->getPengumumans->view_count }}</a>
                                        </div>
                                        <div class="blog-date">
                                            <span>Posted by: {{ $pengumuman->getPengumumans->author->username }} | {{ $pengumuman->getPengumumans->created_at->diffForHumans() }}, {{ $pengumuman->getPengumumans->created_at->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="blog-content">
                                        <p>{{ Str::limit($pengumuman->getPengumumans->description, 90) }}</p>
                                    </div>
                                    <div class="blog-link">
                                        <a href="{{ route('public.pengumumans.detail', $pengumuman->getPengumumans->slug) }}">Baca Selengkapnya</a>
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

                            {{-- {{ $tagsPengumuman->links('vendor.pagination.public') }} --}}
                        </div>
                        <!-- END BLOG LIST-->
                    </div>
                </div>
            </div>
        </section>
        <!-- END PROJECT LIST-->
    </div>
    <style>
        footer{
            display: none;
        }
    </style>
</div>
