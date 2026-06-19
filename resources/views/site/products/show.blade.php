@extends('site.layouts.main')

@section('title', gt($product, 'meta_title') ?: gt($product, 'title'))
@section('meta_description', gt($product, 'meta_description') ?: Str::limit(gt($product, 'short_description'), 160))

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
  <style>
    /* Zoom-in cursor on hover over the main carousel images */
    .product-gallery img {
      cursor: zoom-in;
      transition: opacity 0.2s ease-in-out;
    }
    .product-gallery img:hover {
      opacity: 0.95;
    }
    .product-gallery a.glightbox {
      display: block;
      width: 100%;
      height: 100%;
    }
  </style>
@endpush

@section('content')
  <!-- Breadcrumb -->
  <div style="background:var(--white);border-bottom:1px solid var(--border);padding:0.75rem 0">
    <div class="container">
      <nav aria-label="Breadcrumb">
        <ol class="breadcrumb mb-0" style="font-size:0.85rem">
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}" style="color:var(--text-muted)">{{ __('site.breadcrumb_home') }}</a>
          </li>
          @if($product->category)
            <li class="breadcrumb-item">
              <a href="{{ route('categories.show', $product->category->slug) }}"
                style="color:var(--text-muted)">{{ gt($product->category, 'name') }}</a>
            </li>
          @endif
          <li class="breadcrumb-item active" style="color:var(--primary)">
            {{ gt($product, 'title') }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- ===================================
       Ürün Ana Bölümü
       =================================== -->
  <main class="py-6" data-testid="product-main">
    <div class="container">
      <div class="row g-5">

        <!-- Sol: Ürün Görselleri -->
        <div class="col-lg-6" data-testid="product-gallery-section">
          @php
            $gallery = $product->images->count() ? $product->images : null;
            $coverUrl = $product->cover_image ? asset('storage/' . $product->cover_image) : 'https://placehold.co/700x500/eeeeee/999999?text=Görsel+Yok';
          @endphp

          <!-- Ana Carousel -->
          <div id="productCarousel" class="carousel slide product-gallery" data-bs-ride="false" data-bs-interval="false">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <a href="{{ $coverUrl }}" class="glightbox" data-gallery="product-gallery">
                  <img src="{{ $coverUrl }}" alt="{{ gt($product, 'title') }}" loading="eager"
                    style="aspect-ratio: 4/3; object-fit: cover; width: 100%;">
                </a>
              </div>
              @if($gallery)
                @foreach($gallery as $img)
                  <div class="carousel-item">
                    <a href="{{ asset('storage/' . $img->image_path) }}" class="glightbox" data-gallery="product-gallery">
                      <img src="{{ asset('storage/' . $img->image_path) }}"
                        alt="{{ $img->alt_text ?? gt($product, 'title') }}" loading="lazy"
                        style="aspect-ratio: 4/3; object-fit: cover; width: 100%;">
                    </a>
                  </div>
                @endforeach
              @endif
            </div>
            @if($gallery && $gallery->count() > 0)
              <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev"
                aria-label="{{ __('site.slider_prev') }}">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next"
                aria-label="{{ __('site.slider_next') }}">
                <span class="carousel-control-next-icon"></span>
              </button>
            @endif
          </div>

          <!-- Thumbnails -->
          @if($gallery && $gallery->count() > 0)
            <div class="product-thumbs" data-testid="product-thumbnails">
              <div class="product-thumb active" data-testid="thumb-0"
                onclick="bootstrap.Carousel.getInstance(document.getElementById('productCarousel')).to(0)">
                <img src="{{ $coverUrl }}" alt="{{ __('site.thumb_cover') }}" style="aspect-ratio: 4/3; object-fit: cover;">
              </div>
              @foreach($gallery as $idx => $img)
                <div class="product-thumb" data-testid="thumb-{{ $idx + 1 }}"
                  onclick="bootstrap.Carousel.getInstance(document.getElementById('productCarousel')).to({{ $idx + 1 }})">
                  <img src="{{ asset('storage/' . $img->image_path) }}" alt="Görsel {{ $idx + 1 }}"
                    style="aspect-ratio: 4/3; object-fit: cover;">
                </div>
              @endforeach
            </div>
          @endif

          <!-- Paylaş -->
          <div class="d-flex align-items-center gap-2 mt-3">
            <span style="font-size:0.82rem;color:var(--text-muted)">{{ __('site.product_share') }}</span>
            <a href="https://api.whatsapp.com/send?text={{ urlencode(route('products.show', $product->slug)) }}"
              class="detail-link" aria-label="WhatsApp" onclick="return!window.open(this.href)"><i class="bi bi-whatsapp"
                style="color:var(--green)"></i></a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('products.show', $product->slug)) }}"
              class="detail-link" aria-label="Facebook" onclick="return!window.open(this.href)"><i class="bi bi-facebook"></i></a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('products.show', $product->slug)) }}"
              class="detail-link" aria-label="LinkedIn" onclick="return!window.open(this.href)"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <!-- Sağ: Ürün Bilgileri -->
        <div class="col-lg-6" data-testid="product-info-section">

          <div class="d-flex align-items-center gap-2 mb-2">
            @if($product->category)
              <a href="{{ route('categories.show', $product->category->slug) }}" class="product-category-tag"
                style="font-size:0.82rem">
                <i
                  class="{{ $product->category->icon ?? 'bi bi-tag' }} me-1"></i>{{ gt($product->category, 'name') }}
              </a>
            @endif
            @if($product->badge)
              <span class="product-badge badge-new" style="position:static">{{ $product->badge }}</span>
            @endif
          </div>

          <h1 class="product-detail-title" data-testid="product-title" style="margin-bottom:0.5rem;">
            {{ gt($product, 'title') }}</h1>

          @if($product->price)
            <div class="product-detail-price mb-3" style="font-family: 'Outfit', sans-serif;">
              <span class="price-amount" style="font-size: 2rem; font-weight: 800; color: var(--turquoise);">
                {{ app()->getLocale() === 'tr' ? '₺' . number_format($product->price, 2, ',', '.') : '₺' . number_format($product->price, 2, '.', ',') }}
              </span>
            </div>
          @endif

          <div class="product-meta">
            @if($product->code)
              <div class="product-meta-item">
                <i class="bi bi-tag"></i><span>{{ __('site.product_code') }}: {{ $product->code }}</span>
              </div>
            @endif
            @if($product->material)
              <div class="product-meta-item">
                <i class="bi bi-layers"></i><span>{{ $product->material }}</span>
              </div>
            @endif
            @if($product->age_range)
              <div class="product-meta-item">
                <i class="bi bi-person-fill"></i><span>{{ $product->age_range }}</span>
              </div>
            @endif
            @if($product->certification)
              <div class="product-meta-item">
                <i class="bi bi-shield-check" style="color:var(--green)"></i><span>{{ $product->certification }}</span>
              </div>
            @endif
          </div>

          <p class="product-short-desc" data-testid="product-short-desc">
            {{ gt($product, 'short_description') }}
          </p>

          @if($product->features->count())
            <ul class="product-features" data-testid="product-features">
              @foreach($product->features as $feature)
                <li><i class="bi bi-check-circle-fill"></i> {{ gt($feature, 'feature_text') }}
                </li>
              @endforeach
            </ul>
          @endif

          <!-- Sipariş / WhatsApp Kutusu -->
          <div class="product-cta-box" data-testid="product-cta-box">
            <p>
              <i class="bi bi-info-circle-fill me-1" style="color:var(--turquoise)"></i>
              {!! __('site.product_custom_info') !!}
            </p>
            <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(__('site.whatsapp_product_offer_msg', ['product' => gt($product, 'title') . ($product->code ? ' (' . $product->code . ')' : '')])) }}"
              class="btn-whatsapp w-100 justify-content-center" onclick="return!window.open(this.href)" style="display:flex"
              data-testid="product-whatsapp-order-btn">
              <i class="bi bi-whatsapp"></i> {{ __('site.product_whatsapp_order') }}
            </a>
            <div class="custom-order-note">
              <i class="bi bi-rulers"></i>
              <p>{{ __('site.product_custom_note') }}</p>
            </div>
          </div>

          <!-- Güvence satırı -->
          <div class="d-flex flex-wrap gap-3 mt-3">
            <div class="d-flex align-items-center gap-2" style="font-size:0.82rem;color:var(--text-muted)">
              <i class="bi bi-shield-fill-check" style="color:var(--green)"></i> {{ __('site.product_quality') }}
            </div>
            <div class="d-flex align-items-center gap-2" style="font-size:0.82rem;color:var(--text-muted)">
              <i class="bi bi-truck" style="color:var(--turquoise)"></i> {{ __('site.product_turnkey') }}
            </div>
            @if($product->certification)
              <div class="d-flex align-items-center gap-2" style="font-size:0.82rem;color:var(--text-muted)">
                <i class="bi bi-award" style="color:var(--orange)"></i> {{ $product->certification }}
              </div>
            @endif
            <div class="d-flex align-items-center gap-2" style="font-size:0.82rem;color:var(--text-muted)">
              <i class="bi bi-chat-dots" style="color:var(--primary)"></i> {{ __('site.product_consulting') }}
            </div>
          </div>

        </div>
      </div><!-- /.row -->

      <!-- ===================================
           Ürün Sekmeleri
           =================================== -->

      {{-- ── Bootstrap Toast: Yorum başarı / hata bildirimi (sekme dışında, sabit konum) ── --}}
      @if(session('review_success') || $errors->has('rate_limit') || $errors->has('recaptcha'))
      <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1090">
        <div id="reviewToast" class="toast align-items-center border-0 shadow-lg
          {{ session('review_success') ? 'text-bg-success' : 'text-bg-danger' }}"
          role="alert" aria-live="assertive" aria-atomic="true"
          data-bs-delay="{{ session('review_success') ? 7000 : 0 }}"
          data-bs-autohide="{{ session('review_success') ? 'true' : 'false' }}">
          <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
              @if(session('review_success'))
                <i class="bi bi-check-circle-fill fs-5"></i>
                <span>{{ session('review_success') }}</span>
              @else
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <span>{{ $errors->first('rate_limit') ?: $errors->first('recaptcha') }}</span>
              @endif
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Kapat"></button>
          </div>
        </div>
      </div>
      @endif

      <div class="mt-6" data-testid="product-tabs-section">

        <ul class="nav product-tabs border-bottom-0 border" id="productTabs" role="tablist"
          style="border-radius:var(--radius-md) var(--radius-md) 0 0;overflow:hidden;background:var(--white)">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button"
              role="tab" aria-controls="desc" aria-selected="true" data-testid="tab-description">
              <i class="bi bi-file-text me-2"></i>{{ __('site.tab_description') }}
            </button>
          </li>
          @if($product->specs->count())
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab"
                aria-controls="specs" aria-selected="false" data-testid="tab-specs">
                <i class="bi bi-list-check me-2"></i>{{ __('site.tab_specs') }}
              </button>
            </li>
          @endif
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button"
              role="tab" aria-controls="reviews" aria-selected="false" data-testid="tab-reviews">
              <i class="bi bi-star me-2"></i>{{ __('site.tab_reviews') }}
              <span
                style="background:var(--turquoise);color:var(--white);border-radius:50px;font-size:0.7rem;padding:0.1rem 0.5rem;margin-left:0.3rem">{{ $product->approvedReviews->count() }}</span>
            </button>
          </li>
        </ul>

        <div class="tab-content" id="productTabsContent">

          <!-- =====================
               AÇIKLAMA
               ===================== -->
          <div class="tab-pane fade show active tab-content-area bg-white p-4 border border-top-0 rounded-bottom"
            id="desc" role="tabpanel" aria-labelledby="desc-tab" data-testid="tab-desc-content">
            <div class="row g-4">
              <div class="col-lg-8">
                <h4 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:1.1rem;margin-bottom:1rem">{{ __('site.product_about') }}</h4>
                <div class="product-description-content"
                  style="color:var(--text-muted);line-height:1.8;font-size:0.95rem">
                  {!! gt($product, 'description') !!}
                </div>
              </div>
              <div class="col-lg-4">
                <div style="background:var(--bg);border-radius:var(--radius-md);padding:1.5rem">
                  <h5 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:0.95rem;margin-bottom:1rem">{{ __('site.product_quick_info') }}</h5>
                  <div class="d-flex flex-column gap-2">
                    @if($product->code)
                      <div class="d-flex align-items-center gap-2 py-2" style="border-bottom:1px solid var(--border)">
                        <i class="bi bi-box" style="color:var(--turquoise)"></i>
                        <div>
                          <div style="font-size:0.75rem;color:var(--text-muted)">{{ __('site.product_code_label') }}</div>
                          <div style="font-size:0.88rem;font-weight:600">{{ $product->code }}</div>
                        </div>
                      </div>
                    @endif
                    @if($product->material)
                      <div class="d-flex align-items-center gap-2 py-2" style="border-bottom:1px solid var(--border)">
                        <i class="bi bi-layers" style="color:var(--turquoise)"></i>
                        <div>
                          <div style="font-size:0.75rem;color:var(--text-muted)">{{ __('site.product_material_label') }}</div>
                          <div style="font-size:0.88rem;font-weight:600">{{ $product->material }}</div>
                        </div>
                      </div>
                    @endif
                    @if($product->production_time)
                      <div class="d-flex align-items-center gap-2 py-2" style="border-bottom:1px solid var(--border)">
                        <i class="bi bi-clock" style="color:var(--orange)"></i>
                        <div>
                          <div style="font-size:0.75rem;color:var(--text-muted)">{{ __('site.product_prod_time') }}</div>
                          <div style="font-size:0.88rem;font-weight:600">{{ $product->production_time }}</div>
                        </div>
                      </div>
                    @endif
                    <div class="d-flex align-items-center gap-2 py-2">
                      <i class="bi bi-geo-alt" style="color:var(--green)"></i>
                      <div>
                        <div style="font-size:0.75rem;color:var(--text-muted)">{{ __('site.product_installation') }}</div>
                        <div style="font-size:0.88rem;font-weight:600">{{ __('site.product_by_our_team') }}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- =====================
               TEKNİK ÖZELLİKLER
               ===================== -->
          @if($product->specs->count())
            <div class="tab-pane fade tab-content-area bg-white p-4 border border-top-0 rounded-bottom" id="specs"
              role="tabpanel" aria-labelledby="specs-tab" data-testid="tab-specs-content">
              <h4 style="font-family:'Outfit',sans-serif;font-weight:700;font-size:1.1rem;margin-bottom:1.5rem">{{ __('site.specs_title') }}</h4>
              <div class="row g-4">
                @php
                  $half = ceil($product->specs->count() / 2);
                  $specsLeft = $product->specs->take($half);
                  $specsRight = $product->specs->skip($half);
                @endphp
                <div class="col-lg-6">
                  <table class="specs-table w-100">
                    <tbody>
                      @foreach($specsLeft as $spec)
                        <tr>
                          <td style="padding:0.75rem;border-bottom:1px solid var(--border)">
                            {{ gt($spec, 'spec_key') }}</td>
                          <td style="padding:0.75rem;border-bottom:1px solid var(--border);font-weight:600">
                            {{ gt($spec, 'spec_value') }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-lg-6">
                  <table class="specs-table w-100">
                    <tbody>
                      @foreach($specsRight as $spec)
                        <tr>
                          <td style="padding:0.75rem;border-bottom:1px solid var(--border)">
                            {{ gt($spec, 'spec_key') }}</td>
                          <td style="padding:0.75rem;border-bottom:1px solid var(--border);font-weight:600">
                            {{ gt($spec, 'spec_value') }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="mt-4 p-3 info-note-box">
                <p class="info-note-text">
                  <i class="bi bi-exclamation-triangle-fill me-1 info-note-icon-orange"></i>
                  {!! __('site.specs_note') !!}
                </p>
              </div>
            </div>
          @endif

          <!-- =====================
               YORUMLAR
               ===================== -->
          <div class="tab-pane fade tab-content-area bg-white p-4 border border-top-0 rounded-bottom" id="reviews"
            role="tabpanel" aria-labelledby="reviews-tab" data-testid="tab-reviews-content">


            <!-- Mevcut Yorumlar -->
            <h4 class="reviews-section-title">{{ __('site.reviews_title') }}</h4>

            @forelse($product->approvedReviews as $review)
              <div class="review-card mb-4 p-3 review-item-card"
                data-testid="review-{{ $review->id }}">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <div>
                    <div class="reviewer-name review-author-name">{{ $review->reviewer_name }}</div>
                    @if($review->reviewer_org)
                      <div class="reviewer-org review-author-org">{{ $review->reviewer_org }}
                      </div>
                    @endif
                  </div>
                  <div>
                    <div class="review-stars review-stars-container">
                      @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                          <i class="bi bi-star-fill"></i>
                        @else
                          <i class="bi bi-star"></i>
                        @endif
                      @endfor
                    </div>
                    <div class="review-date-text">
                      {{ $review->reviewed_at?->translatedFormat('F Y') ?? $review->created_at->translatedFormat('F Y') }}
                    </div>
                  </div>
                </div>
                <p class="review-text mb-0 review-body-text">{{ $review->review_text }}</p>
              </div>
            @empty
              <div class="alert alert-light text-center py-4 text-muted border">
                <i class="bi bi-chat-square-text" style="font-size:2rem"></i>
                <p class="mt-2 mb-0">{{ __('site.reviews_empty') }}</p>
              </div>
            @endforelse

            <!-- =====================
                 YORUM YAP FORMU
                 ===================== -->
            <div class="review-form-wrap mt-5 pt-4 border-top" data-testid="review-form-section">
              <h5 class="reviews-section-title"><i class="bi bi-pencil-square me-2 text-turquoise"></i>{{ __('site.review_form_title') }}</h5>
              <p class="text-muted form-desc-custom" style="margin-bottom:1.25rem">{{ __('site.review_form_subtitle') }}</p>

              <form id="reviewForm" action="{{ route('reviews.store', $product->id) }}" method="POST" novalidate
                data-testid="review-form">
                @csrf
                <div class="row g-3">
                  <!-- Ad Soyad -->
                  <div class="col-sm-6">
                    <label for="reviewer_name" class="form-label-bold">
                      {{ __('site.review_name') }} <span class="text-orange">*</span>
                    </label>
                    <input type="text" name="reviewer_name" id="reviewer_name"
                      class="form-control @error('reviewer_name') is-invalid @enderror"
                      value="{{ old('reviewer_name') }}"
                      placeholder="{{ __('site.review_name') }}" required>
                    @error('reviewer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <!-- Kurum -->
                  <div class="col-sm-6">
                    <label for="reviewer_org" class="form-label-bold">
                      {{ __('site.review_org') }}
                    </label>
                    <input type="text" name="reviewer_org" id="reviewer_org"
                      class="form-control"
                      value="{{ old('reviewer_org') }}"
                      placeholder="{{ __('site.review_org_ph') }}">
                  </div>

                  <!-- E-posta -->
                  <div class="col-sm-6">
                    <label for="reviewer_email" class="form-label-bold">
                      {{ __('site.review_email') }} <span class="text-orange">*</span>
                      <span class="form-info-note">({{ __('site.review_email_note') }})</span>
                    </label>
                    <input type="email" name="reviewer_email" id="reviewer_email"
                      class="form-control @error('reviewer_email') is-invalid @enderror"
                      value="{{ old('reviewer_email') }}"
                      placeholder="example@email.com" required>
                    @error('reviewer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  <!-- Puan - Saf CSS Yıldız Seçici -->
                  <div class="col-sm-6">
                    <label class="form-label-badge">
                      {{ __('site.review_rating') }} <span class="text-orange">*</span>
                    </label>
                    {{-- Yıldızlar ters sırada (5→1) render edilir, CSS flex-direction:row-reverse ile soldan sağa görünür --}}
                    <div class="css-star-rating" id="starRatingWrap">
                      @for($s = 5; $s >= 1; $s--)
                        <input type="radio" name="rating" id="rating{{ $s }}" value="{{ $s }}"
                          {{ old('rating') == $s ? 'checked' : '' }} required>
                        <label for="rating{{ $s }}">&#9733;</label>
                      @endfor
                    </div>
                    @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                  </div>

                  <!-- Yorum Metni -->
                  <div class="col-12">
                    <label for="review_text" class="form-label-bold">
                      {{ __('site.review_text') }} <span class="text-orange">*</span>
                    </label>
                    <textarea name="review_text" id="review_text"
                      class="form-control @error('review_text') is-invalid @enderror textarea-resize-vertical"
                      rows="4"
                      placeholder="{{ __('site.review_text_ph') }}"
                      required>{{ old('review_text') }}</textarea>
                    @error('review_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>

                  @if(env('RECAPTCHA_SITE_KEY'))
                    <input type="hidden" name="g-recaptcha-response" id="recaptchaToken">
                  @endif

                  <!-- Gönder -->
                  <div class="col-12 d-flex align-items-center gap-3 flex-wrap">
                    <button type="submit" class="btn btn-primary" id="reviewSubmitBtn" data-testid="review-submit-btn">
                      <i class="bi bi-send-fill me-1"></i> {{ __('site.review_submit') }}
                    </button>
                    <span class="form-info-note">
                      <i class="bi bi-shield-check me-1 text-green"></i>
                      {{ __('site.review_approval_note') }}
                      @if(env('RECAPTCHA_SITE_KEY'))
                        <br><span class="legal-notice-small">{{ __('site.review_recaptcha') }}</span>
                      @endif
                    </span>
                  </div>
                </div>
              </form>
            </div>

          </div><!-- /#reviews tab-pane -->

        </div><!-- /.tab-content -->
      </div><!-- /.mt-6 -->

      @php
        $faqs = $product->activeFaqs;
        if ($faqs->isEmpty()) {
            $faqs = $generalFaqs;
        }
      @endphp

      @if($faqs->isNotEmpty())
        <!-- ===================================
             Sıkça Sorulan Sorular (FAQ - SGE / GEO)
             =================================== -->
        <section class="mt-6" data-testid="product-faq-section">
          <h2 class="section-title mb-4" style="font-size:1.6rem">
            {{ __('site.faq_title') }}
          </h2>
          <div class="accordion" id="productFaqAccordion" style="border: 1px solid var(--border); border-radius: var(--radius-md); overflow: hidden; background: var(--white); box-shadow: var(--shadow-sm);">
            @foreach($faqs as $fIndex => $faq)
              <div class="accordion-item" style="border: none; {{ !$loop->last ? 'border-bottom: 1px solid var(--border);' : '' }}">
                <h3 class="accordion-header" id="faqHeading{{ $faq->id }}">
                  <button class="accordion-button {{ $fIndex > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $faq->id }}" aria-expanded="{{ $fIndex === 0 ? 'true' : 'false' }}" aria-controls="faqCollapse{{ $faq->id }}" style="font-family:'Outfit',sans-serif; font-weight:600; color:var(--text-dark); background:transparent; box-shadow:none; padding:1.25rem 1.5rem;">
                    {{ str_replace('{product}', gt($product, 'title'), gt($faq, 'question')) }}
                  </button>
                </h3>
                <div id="faqCollapse{{ $faq->id }}" class="accordion-collapse collapse {{ $fIndex === 0 ? 'show' : '' }}" aria-labelledby="faqHeading{{ $faq->id }}" data-bs-parent="#productFaqAccordion">
                  <div class="accordion-body" style="color:var(--text-muted); font-size:0.95rem; line-height:1.7; padding:0 1.5rem 1.5rem;">
                    {!! nl2br(e(str_replace('{product}', gt($product, 'title'), gt($faq, 'answer')))) !!}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </section>
      @endif

      @if($related->count())
        <!-- ===================================
             İlgili Ürünler
             =================================== -->
        <section class="mt-6" data-testid="related-products">
          <h2 class="section-title mb-4" style="font-size:1.6rem">
            {{ __('site.related_title') }}
          </h2>
          <div class="row g-4">
            @foreach($related as $relProduct)
              <div class="col-sm-6 col-lg-3">
                <article class="product-card h-100">
                  <div class="product-card-img-wrap">
                    <img
                      src="{{ $relProduct->cover_image ? asset('storage/' . $relProduct->cover_image) : 'https://placehold.co/400x400/eeeeee/999999?text=Görsel+Yok' }}"
                      alt="{{ gt($relProduct, 'title') }}" loading="lazy"
                      style="aspect-ratio: 1/1; object-fit: cover;">
                  </div>
                  <div class="product-card-body">
                    <span
                      class="product-category-tag">{{ gt($relProduct->category, 'name') }}</span>
                    <h3 class="product-card-title">{{ gt($relProduct, 'title') }}</h3>
                    @if($relProduct->price)
                      <div class="product-card-price mb-2" style="font-family: 'Outfit', sans-serif; font-weight: 700; color: var(--turquoise); font-size: 1.15rem;">
                        {{ app()->getLocale() === 'tr' ? '₺' . number_format($relProduct->price, 2, ',', '.') : '₺' . number_format($relProduct->price, 2, '.', ',') }}
                      </div>
                    @endif
                  </div>
                  <div class="product-card-footer mt-auto">
                    <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(gt($relProduct, 'title') . ' ' . __('site.order_btn')) }}"
                      class="whatsapp-link" onclick="return!window.open(this.href)"><i class="bi bi-whatsapp"></i> {{ __('site.order_btn') }}</a>
                    <a href="{{ route('products.show', $relProduct->slug) }}" class="detail-link"><i class="bi bi-eye"></i>
                      {{ __('site.detail_btn') }}</a>
                  </div>
                </article>
              </div>
            @endforeach
          </div>
        </section>
      @endif

    </div><!-- /.container -->
  </main>
@endsection

@push('scripts')
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org/",
    "@@type": "Product",
    "name": "{{ gt($product, 'title') }}",
    "image": [
      "{{ $product->cover_image ? asset('storage/' . $product->cover_image) : 'https://placehold.co/700x500/eeeeee/999999?text=Görsel+Yok' }}"
    ],
    "description": "{{ Str::limit(strip_tags(gt($product, 'short_description')), 160) }}",
    "sku": "{{ $product->code ?: 'MATIXO-' . $product->id }}",
    "mpn": "{{ $product->code ?: 'MATIXO-' . $product->id }}",
    "brand": {
      "@@type": "Brand",
      "name": "MATIXO"
    },
    @if($product->approvedReviews->count() > 0)
    "aggregateRating": {
      "@@type": "AggregateRating",
      "ratingValue": "{{ $product->approvedReviews->avg('rating') }}",
      "reviewCount": "{{ $product->approvedReviews->count() }}"
    },
    "review": [
      @foreach($product->approvedReviews as $review)
      {
        "@@type": "Review",
        "author": {
          "@@type": "Person",
          "name": "{{ $review->reviewer_name }}"
        },
        "datePublished": "{{ $review->created_at->format('Y-m-d') }}",
        "reviewBody": "{{ $review->comment }}",
        "reviewRating": {
          "@@type": "Rating",
          "ratingValue": "{{ $review->rating }}"
        }
      }{{ !$loop->last ? ',' : '' }}
      @endforeach
    ],
    @endif
    "offers": {
      "@@type": "AggregateOffer",
      "priceCurrency": "TRY",
      "price": "0",
      "valueAddedTaxIncluded": "true",
      "priceSpecification": {
        "@@type": "PriceSpecification",
        "description": "{{ strip_tags(__('site.product_custom_info')) }}"
      },
      "url": "{{ url()->current() }}",
      "availability": "https://schema.org/PreOrder"
    },
    "additionalProperty": [
      @php $properties = []; @endphp
      @if($product->material)
        @php $properties[] = '{"@@type": "PropertyValue", "name": "Malzeme", "value": "' . e($product->material) . '"}'; @endphp
      @endif
      @if($product->age_range)
        @php $properties[] = '{"@@type": "PropertyValue", "name": "Yaş Grubu", "value": "' . e($product->age_range) . '"}'; @endphp
      @endif
      @if($product->certification)
        @php $properties[] = '{"@@type": "PropertyValue", "name": "Sertifikasyon", "value": "' . e($product->certification) . '"}'; @endphp
      @endif
      {!! implode(',', $properties) !!}
    ]
  }
  </script>

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
      }
      @if($product->category)
      ,{
        "@@type": "ListItem",
        "position": 2,
        "name": "{{ gt($product->category, 'name') }}",
        "item": "{{ route('categories.show', $product->category->slug) }}"
      },
      {
        "@@type": "ListItem",
        "position": 3,
        "name": "{{ gt($product, 'title') }}",
        "item": "{{ url()->current() }}"
      }
      @else
      ,{
        "@@type": "ListItem",
        "position": 2,
        "name": "{{ gt($product, 'title') }}",
        "item": "{{ url()->current() }}"
      }
      @endif
    ]
  }
  </script>

  @if($faqs->isNotEmpty())
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
      @foreach($faqs as $faq)
      {
        "@@type": "Question",
        "name": {!! json_encode(str_replace('{product}', gt($product, 'title'), gt($faq, 'question')), JSON_UNESCAPED_UNICODE) !!},
        "acceptedAnswer": {
          "@@type": "Answer",
          "text": {!! json_encode(str_replace('{product}', gt($product, 'title'), gt($faq, 'answer')), JSON_UNESCAPED_UNICODE) !!}
        }
      }{{ !$loop->last ? ',' : '' }}
      @endforeach
    ]
  }
  </script>
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', function () {

      // ── Thumbnail carousel sync ─────────────────────────
      const productTabs = document.querySelectorAll('.product-thumbs .product-thumb');
      const myCarousel = document.getElementById('productCarousel');
      if (myCarousel) {
        myCarousel.addEventListener('slide.bs.carousel', event => {
          productTabs.forEach(t => t.classList.remove('active'));
          if (productTabs[event.to]) productTabs[event.to].classList.add('active');
        });
      }

      // Yıldız seçici artık saf CSS ile çalışıyor — JS gerekmez.

      // ── Toast göster + Yorumlar tabına geç ───────────────
      (function () {
        var toastEl = document.getElementById('reviewToast');
        var reviewsTabBtn = document.querySelector('[data-bs-target="#reviews"]');

        function switchToReviews() {
          if (reviewsTabBtn) new bootstrap.Tab(reviewsTabBtn).show();
        }

        @if(session('review_success'))
          // Başarı: toast + Yorumlar tabına geç
          switchToReviews();
          if (toastEl) new bootstrap.Toast(toastEl).show();
        @elseif($errors->has('rate_limit') || $errors->has('recaptcha'))
          // Rate limit / reCAPTCHA hatası: toast + Yorumlar tabına geç
          switchToReviews();
          if (toastEl) new bootstrap.Toast(toastEl).show();
        @elseif($errors->any())
          // Diğer validation hataları: Yorumlar tabına geç + forma scroll
          switchToReviews();
          setTimeout(function () {
            var formWrap = document.querySelector('.review-form-wrap');
            if (formWrap) formWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }, 350);
        @endif
      }());

    });
  </script>

  @if(env('RECAPTCHA_SITE_KEY'))
  <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
  <script>
    document.getElementById('reviewForm')?.addEventListener('submit', function(e) {
      e.preventDefault();
      const form = this;
      const btn  = document.getElementById('reviewSubmitBtn');
      if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> {{ __('site.review_sending') }}'; }
      grecaptcha.ready(function() {
        grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', { action: 'submit_review' }).then(function(token) {
          document.getElementById('recaptchaToken').value = token;
          form.submit();
        });
      });
    });
  </script>
  @endif

  <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const lightbox = GLightbox({
        selector: '.glightbox',
        loop: true,
        zoomable: true,
        draggable: true,
        openEffect: 'zoom',
        closeEffect: 'zoom'
      });
    });
  </script>

@endpush