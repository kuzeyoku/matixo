@extends("site.layouts.main")

@section('title', request('q') ? __('site.search_results_for', ['query' => request('q')]) : __('site.products'))

@section("content")
    <!-- Sayfa Hero / Breadcrumb -->
    <div class="page-hero" data-testid="page-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="hero-icon-box">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <span class="hero-label">{{ __('site.products_label') }}</span>
                    </div>
                    <h1>
                        @if(request('q'))
                            "{{ request('q') }}"
                        @else
                            {{ __('site.products') }}
                        @endif
                    </h1>
                    <p class="hero-desc">
                        @if(request('q'))
                            {{ __('site.search_results_for', ['query' => request('q')]) }}
                        @else
                            {{ __('site.cat_section_subtitle') }}
                        @endif
                    </p>
                </div>
                <div class="col-lg-4 d-none d-lg-flex justify-content-end align-items-center">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.breadcrumb_home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('site.products') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Ana İçerik -->
    <main class="py-6" data-testid="products-main">
        <div class="container">
            <div class="row g-4">

                <!-- Filtre Sidebar -->
                <div class="col-lg-3" data-testid="filter-sidebar">
                    <aside class="filter-sidebar">
                        <p class="filter-title"><i class="bi bi-funnel-fill me-2"></i>{{ __('site.filter_title') }}</p>

                        <!-- Hızlı Filtre Butonları -->
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <a href="{{ route('products.index', ['q' => request('q')]) }}" class="btn btn-sm {{ !request('category') ? 'btn-filter-active' : 'btn-filter' }}"
                                data-testid="filter-all">{{ __('site.filter_all') }}</a>
                        </div>

                        <!-- Kategori Filtresi -->
                        <div class="accordion accordion-flush" id="filterAccordion">
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button filter-sidebar" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#catFilter" aria-expanded="true" aria-controls="catFilter">
                                        {{ __('site.filter_sub_cats') }}
                                    </button>
                                </h2>
                                <div id="catFilter" class="accordion-collapse collapse show"
                                    data-bs-parent="#filterAccordion">
                                    <div class="accordion-body px-0">
                                        @foreach($categories as $cat)
                                            <div class="filter-check form-check mb-2">
                                                <label class="form-check-label w-100 cursor-pointer">
                                                    <a href="{{ route('products.index', ['category' => $cat->slug, 'q' => request('q')]) }}" class="d-flex justify-content-between text-decoration-none text-inherit {{ request('category') === $cat->slug ? 'fw-bold text-primary' : '' }}">
                                                        <span>{{ gt($cat, 'name') }}</span>
                                                    </a>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp Yönlendirme Kutusu -->
                        <div class="mt-4 p-3 whatsapp-sidebar-box">
                            <p class="whatsapp-sidebar-text">
                                <i class="bi bi-lightbulb-fill me-1 text-orange"></i>
                                {{ __('site.product_not_found') }}
                            </p>
                            <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(__('site.product_not_found')) }}"
                                class="btn-whatsapp w-100 justify-content-center btn-whatsapp-custom" onclick="return!window.open(this.href)"
                                data-testid="sidebar-whatsapp-btn">
                                <i class="bi bi-whatsapp"></i> {{ __('site.sidebar_whatsapp') }}
                            </a>
                        </div>
                    </aside>
                </div>

                <!-- Ürün Grid -->
                <div class="col-lg-9">

                    <!-- Grid Header -->
                    <div class="product-grid-header d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4" data-testid="product-grid-header">
                        <p class="grid-header-text mb-0">
                            <strong class="text-dark-custom">{{ $products->total() }}</strong> {{ __('site.product_count_found') }}
                        </p>
                        <div class="d-flex align-items-center gap-2">
                            <label for="sortSelect" class="small text-muted fw-semibold mb-0" style="white-space: nowrap;">{{ __('site.sort_by') }}:</label>
                            <select id="sortSelect" class="form-select form-select-sm border-0 shadow-sm" style="width: auto; border-radius: var(--radius-sm);" onchange="location = this.value;">
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'default']) }}" @selected($sort === 'default')>{{ __('site.sort_default') }}</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" @selected($sort === 'newest')>{{ __('site.sort_newest') }}</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'name-asc']) }}" @selected($sort === 'name-asc')>{{ __('site.sort_name_asc') }}</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'name-desc']) }}" @selected($sort === 'name-desc')>{{ __('site.sort_name_desc') }}</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" @selected($sort === 'popular')>{{ __('site.sort_popular') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ürün Grid -->
                    <div class="row g-4" data-testid="product-grid">

                        @forelse($products as $product)
                            <div class="col-sm-6 col-xl-4 reveal delay-{{ $loop->iteration > 4 ? 1 : $loop->iteration }}">
                                <article class="product-card h-100" data-testid="product-grid-card-{{ $product->id }}">
                                    <div class="product-card-img-wrap">
                                        <img src="{{ $product->cover_image ? asset('storage/' . $product->cover_image) : 'https://placehold.co/500x500/eeeeee/999999?text=Görsel+Yok' }}"
                                            alt="{{ gt($product, 'title') }}" loading="lazy" class="product-card-img-fit">
                                        @if($product->badge)
                                            <span class="product-badge badge-new">{{ $product->badge }}</span>
                                        @endif
                                    </div>
                                    <div class="product-card-body">
                                        @if($product->category)
                                            <span class="product-category-tag">{{ gt($product->category, 'name') }}</span>
                                        @endif
                                        <h3 class="product-card-title">{{ gt($product, 'title') }}</h3>
                                        <p class="product-card-desc">{{ Str::limit(gt($product, 'short_description'), 100) }}</p>
                                    </div>
                                    <div class="product-card-footer">
                                        <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(gt($product, 'title') . ' ' . __('site.order_btn')) }}"
                                            class="whatsapp-link" onclick="return!window.open(this.href)"
                                            data-testid="product-whatsapp-{{ $product->id }}">
                                            <i class="bi bi-whatsapp"></i> {{ __('site.order_btn') }}
                                        </a>
                                        <a href="{{ route('products.show', $product->slug) }}" class="detail-link" data-testid="product-detail-{{ $product->id }}">
                                            <i class="bi bi-eye"></i> {{ __('site.detail_btn') }}
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="bi bi-box-seam text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-3 text-muted">{{ __('site.empty_category') }}</p>
                            </div>
                        @endforelse

                    </div><!-- /.row -->

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-5 d-flex justify-content-center" data-testid="pagination">
                            {{ $products->links() }}
                        </div>
                    @endif

                </div><!-- /.col-lg-9 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </main>
@endsection
