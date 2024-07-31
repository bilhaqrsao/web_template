<?php
  use Carbon\Carbon;
?>
<div>
    <div class="page-content home-page-1">
        <!-- START REVOLUTION SLIDER 5.0-->
        <div class="rev_slider_wrapper slider-primary">
            <div class="rev_slider" id="rev_slider_1" style="display:none;">
                <ul>
                    @foreach ($banners as $banner)
                    <li class="slider-item-1" data-transition="slidevertical">
                        <!-- MAIN IMAGE-->
                        <img class="rev-slidebg" src="{{ asset('storage/banner/'.$banner->images) }}" alt="#" />
                    </li>
                    @endforeach
                </ul>
                <!-- END REVOLUTION SLIDER-->
            </div>
        </div>
        <!-- END OF SLIDER WRAPPER-->
        <!-- PRODUCT, STYLE 4-->
        {{-- <section class="product product-layout style-3">
            <div class="container">
                <div class="heading">
                    <h3 class="heading-section" style="margin-bottom: 20px;">Layanan</h3>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item style-2 match-item">
                            <div class="icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="title">
                                <a href="berita-detail.html">Layanan I</a>
                            </div>
                            <div class="content">
                                <p>Insurance fraud puts an extra $70 on the price of every annual car insurance premium.
                                </p>
                            </div>
                            <div class="view-more">
                                <a href="berita-detail.html">View more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item style-2 match-item">
                            <div class="icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="title">
                                <a href="berita-detail.html">Layanan II</a>
                            </div>
                            <div class="content">
                                <p>If you have a partner and children, then the two of you should think about life
                                    insurance</p>
                            </div>
                            <div class="view-more">
                                <a href="berita-detail.html">View more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="product-item style-2 match-item">
                            <div class="icon">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="title">
                                <a href="services-detail-3.html">Layanan III</a>
                            </div>
                            <div class="content">
                                <p>We'll rebuild or repair your home if it's damaged or destroyed.</p>
                            </div>
                            <div class="view-more">
                                <a href="services-detail-3.html">View more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- END PRODUCT, STYLE 4-->

        <div class="page-content services-detail-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 20px; margin-top: 20px;">
                            <h3 style="margin-top: 0px;">Berita Terbaru</h3>
                            <a href="{{ route('public.articles') }}">Berita Lainnya</a>
                        </div>
                        <!-- SLIDER, STYLE 2-->
                        <div class="slider slider-medium-layout style-1 style-2">
                            <div class="slider-item">
                                <div class="owl-carousel" data-dots=".slider-dots">
                                    @forelse ($randomArticles as $rndmArticle)
                                    <div class="owl-item">
                                        <div class="slider-image">
                                            <img class="img-responsive" src="{{ asset('storage/article/'.$rndmArticle->thumbnail) }}"
                                                alt="Compare life insurance policies from leading providers" />
                                        </div>
                                        <div class="slider-text-holder animated">
                                            <div class="slider-title">
                                                <a>{{ Str::limit($rndmArticle->title,50) }}</a>
                                            </div>
                                            <div class="slider-btn">
                                                <a href="{{ route('public.articles.detail',$rndmArticle->slug) }}" target="_blank" class="au-btn au-btn-orange au-btn-sm">Lihat Selengkapnya</a>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <p>Belum ada berita terbaru</p>
                                    @endforelse
                                </div>
                                <ul class="slider-dots owl-dots">
                                    <li class="owl-dot active"></li>
                                    <li class="owl-dot"></li>
                                    <li class="owl-dot"></li>
                                </ul>
                                <div class="slider-arrow">
                                    <div class="prev">
                                        <i class="fa fa-chevron-left"></i>
                                    </div>
                                    <div class="next">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END SLIDER, STYLE 1-->
                        <!-- PRODUCT, STYLE 1-->
                        <div class="row" style="margin-top: 30px;">
                            @forelse ($articles as $berita)
                            <div class="col-md-4 col-sm-6">
                                <div class="product-item style-1 match-item">
                                    <a class="image" href="{{ asset('storage/article/'.$berita->thumbnail) }}" target="_blank" >
                                        <img class="img-responsive" src="{{ asset('storage/article/'.$berita->thumbnail) }}" style="width: auto; height: 150px;"
                                            alt="Car Insurance" />
                                    </a>
                                    <div class="title">
                                        <a href="{{ route('public.articles.detail',$berita->slug) }}">{{ Str::limit($berita->title,30) }}</a>
                                    </div>
                                    <div class="content">
                                        <p>{{ Str::limit($berita->description, 100) }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p>Belum ada berita terbaru</p>
                            @endforelse
                        </div>
                        <!-- END PRODUCT, STYLE 1-->
                    </div>
                    <div class="col-md-4">
                        <!-- SIDEBAR, STYLE 2-->
                        <div class="sidebar sidebar-style-1 sidebar-style-2">
                            <div id="gpr-kominfo-widget-container" style="margin-top: 20px; margin-bottom: 40px;"></div>
                            @forelse ($pengumumans as $pengumuman)
                            <div class="banner">
                                <a href="{{ route('public.pengumumans.detail',$pengumuman->slug) }}" target="_blank">
                                    <img class="img-responsive" src="{{ asset('storage/pengumuman/'.$pengumuman->image) }}" width="400" alt="banner" />
                                </a>
                            </div>
                            @empty
                            <p>Belum ada pengumuman</p>
                            @endforelse
                        </div>
                        <!-- END SIDEBAR, STYLE 2-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
