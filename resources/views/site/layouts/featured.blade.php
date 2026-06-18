<section class="py-7" style="background:var(--white)" id="urunler" data-testid="featured-products">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap gap-3">
            <div class="reveal">
                <span class="section-badge">{{ __('site.featured_badge') }}</span>
                <h2 class="section-title">{{ __('site.featured_title') }} <span style="color:var(--turquoise)">{{ __('site.products') }}</span></h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn-outline-custom reveal" data-testid="view-all-products-btn">
                <i class="bi bi-arrow-right"></i> {{ __('site.featured_view_all') }}
            </a>
        </div>

        <div class="row g-4">
            @foreach ($featured as $f)
                <div class="col-sm-6 col-lg-3 reveal delay-1">
                    <article class="product-card h-100" data-testid="product-card-1">
                        <div class="product-card-img-wrap">
                            <img src="{{ $f->cover_image ? asset("storage/" . $f->cover_image) : 'https://placehold.co/400x400/eeeeee/999999?text=Görsel+Yok' }}" alt="{{ gt($f, 'title') }}" loading="lazy">
                            @if($f->badge)
                                <span class="product-badge badge-new">{{ $f->badge }}</span>
                            @endif
                        </div>
                        <div class="product-card-body">
                            @if($f->category)
                                <span class="product-category-tag">{{ gt($f->category, 'name') }}</span>
                            @endif
                            <h3 class="product-card-title">{{ gt($f, 'title') }}</h3>
                            <p class="product-card-desc">{{ gt($f, 'short_description') }}</p>
                        </div>
                        <div class="product-card-footer">
                            <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(gt($f, 'title') . ' ' . __('site.order_btn')) }}"
                                class="whatsapp-link" onclick="return!window.open(this.href)" data-testid="whatsapp-link-1">
                                <i class="bi bi-whatsapp"></i> {{ __('site.featured_order') }}
                            </a>
                            <a href="{{ route('products.show', $f->slug) }}" class="detail-link" data-testid="detail-link-1">
                                <i class="bi bi-eye"></i> {{ __('site.featured_detail') }}
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach

        </div>
    </div>
</section>