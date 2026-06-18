<section class="hero-carousel" aria-label="{{ __('site.slider_label') }}" data-testid="hero-carousel">
    <div id="heroCarousel" class="carousel carousel-fade slide h-100" data-bs-ride="carousel" data-bs-interval="5000">

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"
                aria-label="{{ __('site.slider_slide_label', ['count' => 1]) }}" aria-current="true"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="{{ __('site.slider_slide_label', ['count' => 2]) }}"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="{{ __('site.slider_slide_label', ['count' => 3]) }}"></button>
        </div>

        <div class="carousel-inner h-100">

            @foreach ($sliders as $s)
                <div class="carousel-item @if ($loop->first)active @endif"
                    style="background-image:url('{{ asset("storage/" . $s->image) }}')">
                    <div class="hero-overlay"></div>
                    <div class="hero-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-7">
                                    <span class="hero-badge hero-animate-1">{{ gt($s, 'badge_text') }}</span>
                                    @if ($loop->first)
                                        <h1 class="hero-animate-2">{{ gt($s, 'title') }}</h1>
                                    @else
                                        <h2 class="hero-animate-2">{{ gt($s, 'title') }}</h2>
                                    @endif
                                    <p class="hero-animate-3">{{ gt($s, 'subtitle') }}</p>
                                    <div class="d-flex flex-wrap gap-3 hero-animate-4">
                                        <a href="{{$s->link_url}}" class="btn-primary-custom"
                                            data-testid="hero-cta-categories">
                                            <i class="bi bi-grid-3x3-gap-fill"></i> {{ gt($s, 'button_text') }}
                                        </a>
                                        <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(__('site.slider_get_offer')) }}"
                                            onclick="return!window.open(this.href)" class="btn-whatsapp"
                                            data-testid="hero-cta-whatsapp">
                                            <i class="bi bi-whatsapp"></i> {{ __('site.slider_get_offer') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div><!-- /.carousel-inner -->

        <!-- Prev/Next -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"
            aria-label="{{ __('site.slider_prev') }}">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"
            aria-label="{{ __('site.slider_next') }}">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</section>