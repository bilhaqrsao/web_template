<div class="col-md-3">
    <!-- SIDEBAR, STYLE 3-->
    <div class="sidebar sidebar-style-3">
        <div class="sidebar-cate sidebar-element">
            <div class="sidebar-heading">
                <h3>Ketegori</h3>
            </div>
            <div class="sidebar-cate-list">
                <ul>
                    @forelse ($tags as $tag)
                    <li>
                        <a href="{{ route('public.tags.detail',$tag->slug) }}">
                            <i class="fa fa-angle-right"></i>{{ $tag->name }}</a>
                    </li>
                    @empty

                    @endforelse
                </ul>
            </div>
        </div>
        <div class="sidebar-element sidebar-banner">
            @forelse ($pengumumans as $pengumuman)
            <a href="{{ route('public.pengumumans.detail',$pengumuman->slug) }}">
                <img class="img-responsive" src="{{ asset('storage/pengumuman/'.$pengumuman->image) }}" alt="Banner" />
            </a>
            @empty

            @endforelse
        </div>
        <div class="sidebar-archive sidebar-element">
            <div class="sidebar-heading">
                <h3>Berita Lainnya</h3>
            </div>
            <div class="sidebar-archive-list">
                <ul>
                    @forelse ($beritas as $berita)
                    <li>
                        <a href="#">
                            <i class="fa fa-angle-right"></i>{{ Str::limit($berita->title, 50) }}</a>
                        <span class="post-total">{{ Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}</span>
                    </li>
                    @empty
                    <p>Belum ada berita</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <!-- END SIDEBAR, STYLE 3-->
</div>
