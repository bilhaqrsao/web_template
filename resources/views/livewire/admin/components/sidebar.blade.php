<nav id="sidebar" class="sidebar-wrapper">

    <!-- App brand starts -->
    <div class="app-brand px-3 py-2 d-flex align-items-center">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('storage/identitas/'.$identitas->logo) }}" class="logo" alt="{{ $user->name }}" />
        </a>
    </div>
    <!-- App brand ends -->

    <!-- Sidebar profile starts -->
    <div class="sidebar-profile">
        <img src="@if ($user->photo == null) {{ asset('admin_assets/images/user3.png') }} @else {{ asset('storage/user/' . $user->photo) }} @endif"
            class="img-3x me-3 rounded-3" alt="{{ $user->name }}" />
        <div class="m-0">
            <p class="m-0">Hello &#128075;</p>
            <h6 class="m-0 text-nowrap">{{ $user->name }}</h6>
        </div>
    </div>
    <!-- Sidebar profile ends -->

    <!-- Sidebar menu starts -->
    <div class="sidebarMenuScroll">
        <ul class="sidebar-menu">
            @foreach($menus as $menu)
            @if(empty($menu['child']))
            <li class="{{ $menu['active'] ? 'active current-page' : '' }}">
                <a href="{{ route($menu['route']) }}" wire:navigate>
                    <i class="{{ $menu['icon'] }}"></i>
                    <span class="menu-text">{{ $menu['name'] }}</span>
                </a>
            </li>
            @else
            <li class="treeview {{ $menu['active'] ? 'active current-page' : '' }}">
                <a href="javascript:void(0);">
                    <i class="{{ $menu['icon'] }}"></i>
                    <span class="menu-text">{{ $menu['name'] }}</span>
                </a>
                <ul class="treeview-menu">
                    @foreach($menu['child'] as $child)
                    @php
                    // Memeriksa apakah pengguna memiliki peran yang sesuai untuk menu child
                    $hasChildRole = false;
                    foreach(explode(',', $child['hasRole']) as $role) {
                    if(in_array($role, $userRoles)) {
                    $hasChildRole = true;
                    break;
                    }
                    }
                    @endphp
                    @if($hasChildRole)
                    <li class="{{ $child['active'] ? 'active-sub' : '' }}">
                        <a href="{{ route($child['link']) }}" wire:navigate>{{ $child['name'] }}</a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </li>
            @endif
            @endforeach
        </ul>
    </div>
    <!-- Sidebar menu ends -->

</nav>
