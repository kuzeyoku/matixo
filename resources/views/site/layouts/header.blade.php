<header class="main-header" data-testid="main-header">
    <nav class="navbar navbar-expand-lg" aria-label="{{ __('site.aria_main_nav') }}">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand" href="{{ url('/') }}" data-testid="logo-link" aria-label="{{ __('site.aria_home') }}">
                <span class="logo-text">MATI<span style="color:var(--turquoise)">X</span>O</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler ms-auto me-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="{{ __('site.menu_open') }}"
                data-testid="navbar-toggle">
                <i class="bi bi-list" style="font-size:1.4rem;color:var(--primary)"></i>
            </button>

            <!-- Search Toggle (mobile) -->
            <div class="position-relative d-lg-none">
                <button class="search-btn" id="searchToggleMobile" aria-label="{{ __('site.search') }}">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <!-- Nav Links -->
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto gap-1">
                    @foreach($headerMenus as $menu)
                        @if($menu->has_children)
                            {{-- Dropdown menü --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-testid="nav-{{ Str::slug(gt($menu, 'title')) }}">
                                    @if($menu->icon)<i class="{{ $menu->icon }} me-1"></i>@endif
                                    {{ gt($menu, 'title') }}
                                </a>
                                <ul class="dropdown-menu border-0 shadow-lg"
                                    style="border-radius:var(--radius-md);min-width:260px">
                                    @foreach($menu->children as $child)
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ $child->resolved_url }}"
                                                @if($child->link_target === '_blank') onclick="return!window.open(this.href)" @endif>
                                                @if($child->icon)<i class="{{ $child->icon }} me-2 text-muted"></i>@endif
                                                {{ gt($child, 'title') }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            {{-- Tekil menü --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $menu->resolved_url }}" @if($menu->link_target === '_blank') onclick="return!window.open(this.href)" @endif
                                    data-testid="nav-{{ Str::slug(gt($menu, 'title')) }}">
                                    @if($menu->icon)<i class="{{ $menu->icon }} me-1"></i>@endif
                                    {{ gt($menu, 'title') }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <!-- Right Side -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Language Switcher -->
                    <div class="dropdown lang-dropdown me-1">
                        <button class="btn dropdown-toggle d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-testid="lang-switcher">
                            <i class="bi bi-globe2"></i>
                            <span class="text-uppercase">{{ app()->getLocale() }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                            @foreach(active_languages() as $lang)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between @if(app()->getLocale() === $lang->code) active @endif" href="{{ route('lang.switch', $lang->code) }}">
                                        <span>{{ $lang->name }}</span>
                                        <span class="text-muted small text-uppercase ms-2">{{ $lang->code }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="position-relative d-none d-lg-block">
                        <button class="search-btn" id="searchToggle" aria-label="{{ __('site.search') }}" data-testid="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                        <div class="search-form" id="searchPanel">
                            <form action="{{ route('products.index') }}" method="GET">
                                <input type="text" name="q" placeholder="{{ __('site.search_placeholder') }}" aria-label="{{ __('site.search') }}">
                                <button type="submit" class="btn btn-sm btn-primary-custom mt-2 w-100">
                                    <i class="bi bi-search me-2"></i>{{ __('site.search_btn') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route("contact") }}" rel="noopener"
                        class="btn-primary-custom d-none d-lg-inline-flex" data-testid="header-whatsapp-btn">
                        <i class="bi bi-send-fill"></i> {{ __('site.contact') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>