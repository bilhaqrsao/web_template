<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('admin_assets/dist/images/logo.svg')}}">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2"
                class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <div class="scrollable">
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle"
                class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        <ul class="scrollable__content py-2">
            @foreach($menus as $index => $menu)
            @if(empty($menu['child']))
            <li>
                <a href="{{ route($menu['route']) }}" class="menu {{ $menu['active'] ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-lucide="{{ $menu['icon'] }}"></i> </div>
                    <div class="menu__title"> {{ $menu['name'] }} </div>
                </a>
            </li>
            @else
            <li>
                <a href="javascript:;.html" class="menu {{ $menu['active'] ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-lucide="{{ $menu['icon'] }}"></i> </div>
                    <div class="menu__title"> {{ $menu['name'] }} <i data-lucide="chevron-down"></i> </div>
                </a>
                <ul class="{{ $menu['active'] ? 'menu__sub-open' : 'menu__sub' }}">
                    @foreach($menu['child'] as $child)
                    @php
                    $hasChildRole = false;
                    foreach(explode(',', $child['hasRole']) as $role) {
                    if(in_array($role, $userRoles)) {
                    $hasChildRole = true;
                    break;
                    }
                    }
                    @endphp
                    @if($hasChildRole)
                    <li>
                        <a href="{{ route($child['link']) }}" class="menu {{ $child['active'] ? 'menu--active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="{{ $child['icon'] }}"></i> </div>
                            <div class="menu__title"> {{ $child['name'] }} </div>
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </li>
            @endif
            @endforeach


        </ul>
    </div>
</div>
