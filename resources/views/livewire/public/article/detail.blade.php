<div>
    <div class="page-content project-list-page">
        <!-- HEADING PAGE -->
        <section class="heading-page heading-services-detail-1" style="background: url('{{ asset('img/2.png') }}') center center no-repeat;">
            <div class="container">
                <ul class="au-breadcrumb">
                    <li class="au-breadcrumb-item">
                        <a href="{{ url('/') }}">Home</a>
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
        <!-- END HEADING PAGE -->

        <!-- PROJECT LIST -->
        <section class="blog-single">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <!-- BLOG DETAIL -->
                        <section class="blog-single">
                            <div class="post-title">
                                <h1>{{ $data->title }}</h1>
                            </div>
                            <div class="post-info">
                                <div class="post-topic">
                                    <i class="fa fa-eye"></i> {{ $data->view_count }} view
                                </div>
                                <div class="post-date">
                                    <span>Posted by: {{ $data->author->username }} | {{ Carbon\Carbon::parse($data->created_at)->diffForHumans() }}, {{ Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</span>
                                </div>
                            </div>
                            <div class="post-image">
                                <img class="img-responsive" src="{{ asset('storage/article/'.$data->thumbnail) }}" alt="Blog Single" />
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
                                    @foreach($tags as $tag)
                                        <a href="{{ route('public.tags.detail', $tag->getTags->slug) }}" target="_blank">{{ $tag->getTags->name }}</a>,
                                    @endforeach
                                </div>
                                <div class="post-share">
                                    <span>Bagikan Berita:</span>
                                    <a href="#" wire:click.prevent="share('facebook')">Facebook</a>,
                                    <a href="#" wire:click.prevent="share('twitter')">Twitter</a>,
                                    <a href="#" wire:click.prevent="share('google_plus')">Google+</a>,
                                    <a href="#" wire:click.prevent="share('whatsapp')">WhatsApp</a>,
                                    <a href="#" wire:click.prevent="share('instagram')">Instagram</a>
                                    <span style="margin-left: 10px;">{{ $shareCount }} shares</span>
                                </div>
                            </div>

                            <!-- Like/Unlike Section -->
                            <div class="post-actions" style="margin-top: 20px; display: flex; align-items: center;">
                                <button wire:click="{{ $hasLiked ? 'unlike' : 'like' }}" class="btn" style="background: none; border: none; padding: 0;">
                                    <i class="fa fa-heart" style="color: {{ $hasLiked ? 'red' : 'grey' }}; font-size: 24px;"></i>
                                </button>
                                <span style="margin-left: 10px;">{{ $likeCount }} likes</span>
                            </div>

                            <div class="post-more-link">
                                @if($prevArticle)
                                    <div class="post-prev">
                                        <div class="link">
                                            <a href="{{ route('public.articles.detail', $prevArticle->slug) }}" wire:click.prevent="prevArticle">
                                                <i class="fa fa-angle-double-left"></i> Preview
                                            </a>
                                        </div>
                                        <div class="title">
                                            <h4>{{ Str::limit($prevArticle->title, 30) }}</h4>
                                        </div>
                                    </div>
                                @endif
                                @if($nextArticle)
                                    <div class="post-next">
                                        <div class="link">
                                            <a href="{{ route('public.articles.detail', $nextArticle->slug) }}" wire:click.prevent="nextArticle">Next
                                                <i class="fa fa-angle-double-right"></i>
                                            </a>
                                        </div>
                                        <div class="title">
                                            <h4>{{ Str::limit($nextArticle->title, 30) }}</h4>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                        <!-- END BLOG DETAIL -->
                    </div>
                    @livewire('public.components.sidebar')
                </div>
            </div>
        </section>
        <!-- END PROJECT LIST -->
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('openNewTab', url => {
                window.open(url, '_blank');
            });
        });
    </script>
</div>
