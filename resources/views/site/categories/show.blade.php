@extends("site.layouts.main")

@section('title', gt($category, 'meta_title') ?: gt($category, 'name'))
@section('meta_description', gt($category, 'meta_description') ?: Str::limit(gt($category, 'description'), 160))

@section("content")
    <!-- Sayfa Hero / Breadcrumb -->
    <div class="page-hero" data-testid="page-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="hero-icon-box">
                            <i class="{{ $category->icon ?? 'bi bi-tree' }}"></i>
                        </div>
                        <span class="hero-label">{{ __('site.category_label') }}</span>
                    </div>
                    <h1>{{ gt($category, 'name') }}</h1>
                    <p class="hero-desc">
                        {{ gt($category, 'description') }}
                    </p>
                </div>
                <div class="col-lg-4 d-none d-lg-flex justify-content-end align-items-center">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.breadcrumb_home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('site.breadcrumb_categories') }}</a></li>
                            @foreach($breadcrumbs as $crumb)
                                @if($loop->last)
                                    <li class="breadcrumb-item active">{{ gt($crumb, 'name') }}</li>
                                @else
                                    <li class="breadcrumb-item"><a href="{{ route('categories.show', $crumb->slug) }}">{{ gt($crumb, 'name') }}</a></li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Ana İçerik -->
    <main class="py-6" data-testid="category-main">
        <div class="container">
            <div class="row g-4">

                <!-- Filtre Sidebar -->
                <div class="col-lg-3" data-testid="filter-sidebar">
                    <aside class="filter-sidebar">
                        <p class="filter-title"><i class="bi bi-funnel-fill me-2"></i>{{ __('site.filter_title') }}</p>

                        <!-- Hızlı Filtre Butonları -->
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-sm btn-filter-active"
                                data-testid="filter-all">{{ __('site.filter_all') }}</a>
                        </div>

                        <!-- Kategori Filtresi -->
                        <div class="accordion accordion-flush" id="filterAccordion">
                            @if($category->children->count())
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
                                            @foreach($category->children as $child)
                                                <div class="filter-check form-check mb-2">
                                                    <label class="form-check-label w-100 cursor-pointer">
                                                        <a href="{{ route('categories.show', $child->slug) }}" class="d-flex justify-content-between text-decoration-none text-inherit">
                                                            <span>{{ gt($child, 'name') }}</span>
                                                            <span class="filter-count">{{ $child->products_count ?? 0 }}</span>
                                                        </a>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- WhatsApp Yönlendirme Kutusu -->
                        <div class="mt-4 p-3 whatsapp-sidebar-box">
                            <p class="whatsapp-sidebar-text">
                                <i class="bi bi-lightbulb-fill me-1 text-orange"></i>
                                {{ __('site.product_not_found') }}
                            </p>
                            <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(__('site.product_not_found') . ' ' . gt($category, 'name')) }}"
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
                    <div class="product-grid-header" data-testid="product-grid-header">
                        <p class="grid-header-text">
                            <strong class="text-dark-custom">{{ $products->total() }}</strong> {{ __('site.product_count_found', ['count' => '']) }}
                        </p>
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
                                        <span class="product-category-tag">{{ gt($category, 'name') }}</span>
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

                    <!-- Kategori Detaylı Açıklama (SEO) -->
                    @if(gt($category, 'description'))
                        <div class="mt-5 p-4 bg-white border rounded shadow-sm seo-category-description" data-testid="category-seo-description" style="border-left: 4px solid var(--primary) !important;">
                            <h2 class="h5 mb-3 text-dark-custom">{{ gt($category, 'name') }}</h2>
                            <div class="text-muted leading-relaxed" style="font-size:0.92rem; line-height: 1.6;">
                                {!! nl2br(e(gt($category, 'description'))) !!}
                            </div>
                        </div>
                    @endif

                </div><!-- /.col-lg-9 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </main>
@endsection

@push('scripts')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@@type": "ListItem",
      "position": 1,
      "name": "{{ __('site.breadcrumb_home') }}",
      "item": "{{ route('home') }}"
    },
    {
      "@@type": "ListItem",
      "position": 2,
      "name": "{{ __('site.breadcrumb_categories') }}",
      "item": "{{ route('categories.index') }}"
    }
    @foreach($breadcrumbs as $idx => $crumb)
    ,{
      "@@type": "ListItem",
      "position": {{ $idx + 3 }},
      "name": "{{ gt($crumb, 'name') }}",
      "item": "{{ route('categories.show', $crumb->slug) }}"
    }
    @endforeach
  ]
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ItemList",
  "numberOfItems": "{{ $products->total() }}",
  "itemListElement": [
    @foreach($products as $idx => $product)
    {
      "@@type": "ListItem",
      "position": {{ $idx + 1 }},
      "url": "{{ route('products.show', $product->slug) }}",
      "name": "{{ gt($product, 'title') }}"
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endpush