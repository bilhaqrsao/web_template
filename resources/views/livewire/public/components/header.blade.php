<div>
    <header>
        {{-- <div id="loading">
            <div class="image-load">
                <img src="{{ asset('assets/img/icons/Marty.gif') }}" alt="loader" />
            </div>
        </div> --}}
        <nav id="mmenu">
            <ul>
                @foreach($menus as $menu)
                    <li>
                        <a wire:navigate href="{{ $menu->url }}">{{ $menu->title }}</a>
                        @if($menu->children->count() > 0)
                            <ul>
                                @foreach($menu->children as $child)
                                    <li>
                                        <a wire:navigate href="{{ $child->url }}">{{ $child->title }}</a>
                                        @if($child->children->count() > 0)
                                            <ul>
                                                @foreach($child->children as $grandChild)
                                                    <li>
                                                        <a wire:navigate href="{{ $grandChild->url }}">{{ $grandChild->title }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="top-bar">
            <div class="container">
                <p class="greeting">Website Resmi {{ $identitas->name }}</p>
                <div class="quick-link">
                    <a href="#">Media Sosial Kami :</a>
                    <a href="{{ $identitas->facebook }}" target="_blank">Facebook</a>|
                    <a href="{{ $identitas->instagram }}" target="_blank">Instagram</a>|
                    <a href="{{ $identitas->youtube }}" target="_blank">Youtube</a>
                </div>
            </div>
        </div>
        <div class="header-main">
            <div class="container">
                <div class="logo">
                    <a href="{{ route('public.index') }}">
                        <img width="250" src="{{ asset('storage/identitas/'.$identitas->logo) }}" alt="Logo" />
                    </a>
                </div>
                <div class="contact-widget">
                    <div class="contact-list hidden-lg-tablet">
                        <div class="item">
                            <i class="lnr lnr-phone-handset"></i>
                            <div class="text">
                                <p class="top">Layanan Telepon</p>
                                <p class="bot">{{ $identitas->whatsapp }}</p>
                            </div>
                        </div>
                        <div class="item">
                            <i class="lnr lnr-map-marker"></i>
                            <div class="text">
                                <p class="top">Alamat Kantor</p>
                                <p class="bot">{{ $identitas->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-main">
            <div class="container">
                <div class="navbar-holder">
                    <a class="navbar-toggle collapsed" href="#mmenu">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <nav class="navbar-menu">
                        <ul class="menu">
                            @foreach($menus as $menu)
                                <li class="dropdown">
                                    <a href="{{ $menu->url }}">{{ $menu->title }}</a>
                                    @if ($menu->children->count() > 0)
                                        <ul class="dropdown-menu">
                                            @foreach($menu->children as $child)
                                                <li class="dropdown-child">
                                                    <a href="{{ $child->url }}">{{ $child->title }}</a>
                                                    @if ($child->children->count() > 0)
                                                        <ul class="dropdown-menu-child">
                                                            @foreach($child->children as $grandChild)
                                                                <li>
                                                                    <a href="{{ $grandChild->url }}">{{ $grandChild->title }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                    <div class="search">
                        <form>
                            <input class="search-input" type="text" placeholder="Search" />
                            <input class="search-submit" type="button" value="search" />
                            <span class="search-icon"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
