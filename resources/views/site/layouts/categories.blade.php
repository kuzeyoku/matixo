<section class="categories-section" id="kategoriler" data-testid="categories-section">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="section-badge">{{ __('site.cat_section_badge') }}</span>
            <h2 class="section-title">{{ __('site.all_categories') }} <span style="color:var(--turquoise)">{{ __('site.categories') }}</span></h2>
            <p class="section-subtitle mt-2">{{ __('site.cat_section_subtitle') }}</p>
        </div>
        <div class="row g-3 mb-3">
            @foreach($categories as $c)
                <div class="@if($loop->first) col-md-8 @else col-md-4 @endif reveal delay-{{ $loop->iteration }}">
                    <a href="{{route("categories.show", $c->slug)}}" class="category-card bento-lg d-block"
                        data-testid="cat-bilim-parklari" aria-label="{{ gt($c, 'name') }}">
                        <img src="{{ asset("storage/" . $c->image) }}"
                            alt="{{ gt($c, 'name') }}" loading="lazy">
                        <div class="category-card-overlay"></div>
                        <div class="category-card-body">
                            <div class="category-card-icon"><i class="bi {{$c->icon}}"></i></div>
                            <h3 class="category-card-title">{{ gt($c, 'name') }}</h3>
                            <p class="category-card-count">{{$c->products_count ?? 0}} {{ __('site.products') }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>