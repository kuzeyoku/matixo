@extends('site.layouts.main')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('title', __('site.contact_page_title') . ' | ' . setting('site_name', 'MATIXO'))
@section('meta_description', setting('seo_meta_description'))

@section('content')

<!-- Sayfa Hero -->
<div class="page-hero" data-testid="page-hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <div class="d-flex align-items-center gap-2 mb-2">
          <div class="hero-icon-box">
            <i class="bi bi-chat-dots-fill"></i>
          </div>
        </div>
        <h1>{{ __('site.contact_hero_title') }}</h1>
        <p class="hero-desc">
          {{ __('site.contact_hero_subtitle') }}
        </p>
      </div>
      <div class="col-lg-4 d-none d-lg-flex justify-content-end">
        <nav aria-label="Breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.breadcrumb_home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('site.contact_page_title') }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- ===================================
     İletişim Ana Bölümü
     =================================== -->
<main class="py-7" data-testid="contact-main">
  <div class="container">
    <div class="row g-5">

      <!-- Sol: İletişim Bilgileri -->
      <div class="col-lg-4 reveal-left" data-testid="contact-info">
        <div class="contact-info-card">
          <h3><i class="bi bi-geo-alt-fill me-2 text-turquoise"></i>{{ __('site.contact_reach_us') }}</h3>

          @if(setting('contact_phone'))
          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-telephone-fill"></i></div>
            <div class="contact-info-text">
              <strong>{{ __('site.contact_phone') }}</strong>
              <span><a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('contact_phone')) }}" class="contact-info-link">{{ setting('contact_phone') }}</a></span>
            </div>
          </div>
          @endif

          @if(setting('contact_whatsapp'))
          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-whatsapp"></i></div>
            <div class="contact-info-text">
              <strong>{{ __('site.contact_whatsapp') }}</strong>
              <span><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('contact_whatsapp')) }}" onclick="return!window.open(this.href)" class="contact-info-link">+{{ setting('contact_phone') ?: setting('contact_whatsapp') }}</a></span>
            </div>
          </div>
          @endif

          @if(setting('contact_email'))
          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-envelope-fill"></i></div>
            <div class="contact-info-text">
              <strong>{{ __('site.contact_email') }}</strong>
              <span><a href="mailto:{{ setting('contact_email') }}" class="contact-info-link">{{ setting('contact_email') }}</a></span>
            </div>
          </div>
          @endif

          @if(setting('contact_address'))
          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-geo-alt-fill"></i></div>
            <div class="contact-info-text">
              <strong>{{ __('site.contact_address') }}</strong>
              <span>{!! nl2br(e(setting('contact_address'))) !!}</span>
            </div>
          </div>
          @endif

          @if(setting('working_hours'))
          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="bi bi-clock-fill"></i></div>
            <div class="contact-info-text">
              <strong>{{ __('site.contact_hours') }}</strong>
              <span>{!! nl2br(e(setting('working_hours'))) !!}</span>
            </div>
          </div>
          @endif

          <!-- Sosyal Medya -->
          <div class="mt-4 pt-3 contact-social-border">
            <p class="contact-social-title">{{ __('site.contact_social') }}</p>
            <div class="d-flex gap-2">
              @if(setting('social_instagram'))
              <a href="{{ setting('social_instagram') }}" onclick="return!window.open(this.href)" aria-label="Instagram">
                <span class="contact-social-btn">
                  <i class="bi bi-instagram"></i>
                </span>
              </a>
              @endif
              @if(setting('social_linkedin'))
              <a href="{{ setting('social_linkedin') }}" onclick="return!window.open(this.href)" aria-label="LinkedIn">
                <span class="contact-social-btn">
                  <i class="bi bi-linkedin"></i>
                </span>
              </a>
              @endif
              @if(setting('social_youtube'))
              <a href="{{ setting('social_youtube') }}" onclick="return!window.open(this.href)" aria-label="YouTube">
                <span class="contact-social-btn">
                  <i class="bi bi-youtube"></i>
                </span>
              </a>
              @endif
              @if(setting('contact_whatsapp'))
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('contact_whatsapp')) }}" onclick="return!window.open(this.href)" aria-label="WhatsApp">
                <span class="contact-social-btn">
                  <i class="bi bi-whatsapp"></i>
                </span>
              </a>
              @endif
            </div>
          </div>

        </div>
      </div>

      <!-- Sağ: İletişim Formu -->
      <div class="col-lg-8 reveal-right" data-testid="contact-form-section">
        <div class="contact-form-wrap">
          <h3 class="form-title-custom">{{ __('site.contact_send_msg') }}</h3>
          <p class="form-desc-custom">
            {{ __('site.contact_form_subtitle') }}
          </p>


          <form action="{{ route('contact.store') }}" method="POST" id="contactForm" novalidate data-testid="contact-form">
            @csrf
            <!-- reCAPTCHA Token -->
            <input type="hidden" name="g-recaptcha-response" id="recaptchaToken">
            <div class="row g-3">

              <!-- Ad Soyad -->
              <div class="col-sm-6">
                <div class="form-floating">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('site.contact_name') }}" required data-testid="input-name">
                  <label for="name"><i class="bi bi-person me-1"></i>{{ __('site.contact_name') }}</label>
                  <div class="invalid-feedback">{{ __('site.contact_name_error') }}</div>
                </div>
              </div>

              <!-- E-posta -->
              <div class="col-sm-6">
                <div class="form-floating">
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('site.contact_email_label') }}" required data-testid="input-email">
                  <label for="email"><i class="bi bi-envelope me-1"></i>{{ __('site.contact_email_label') }}</label>
                  <div class="invalid-feedback">{{ __('site.contact_email_error') }}</div>
                </div>
              </div>

              <!-- Telefon -->
              <div class="col-sm-12">
                <div class="form-floating">
                  <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="{{ __('site.contact_phone_label') }}" data-testid="input-phone">
                  <label for="phone"><i class="bi bi-telephone me-1"></i>{{ __('site.contact_phone_label') }}</label>
                </div>
              </div>

              <!-- Konu -->
              <div class="col-12">
                <div class="form-floating">
                  <select class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" required data-testid="input-subject" style="height:auto;padding-top:1.5rem">
                    <option value="" disabled {{ old('subject') ? '' : 'selected' }}>{{ __('site.contact_subject_select') }}</option>
                    <option value="Açık Hava Bilim Parkı" {{ old('subject') === 'Açık Hava Bilim Parkı' ? 'selected' : '' }}>{{ __('site.subject_science_park') }}</option>
                    <option value="Açık Hava Matematik Parkı" {{ old('subject') === 'Açık Hava Matematik Parkı' ? 'selected' : '' }}>{{ __('site.subject_math_park') }}</option>
                    <option value="Montessöri Materyalleri" {{ old('subject') === 'Montessöri Materyalleri' ? 'selected' : '' }}>{{ __('site.subject_montessori') }}</option>
                    <option value="Kent Ekipmanları" {{ old('subject') === 'Kent Ekipmanları' ? 'selected' : '' }}>{{ __('site.subject_urban') }}</option>
                    <option value="Müze Tabela / Totem" {{ old('subject') === 'Müze Tabela / Totem' ? 'selected' : '' }}>{{ __('site.subject_museum_sign') }}</option>
                    <option value="Müze Binaları" {{ old('subject') === 'Müze Binaları' ? 'selected' : '' }}>{{ __('site.subject_museum_build') }}</option>
                    <option value="Matematik Müzesi" {{ old('subject') === 'Matematik Müzesi' ? 'selected' : '' }}>{{ __('site.subject_math_museum') }}</option>
                    <option value="Maket Müze" {{ old('subject') === 'Maket Müze' ? 'selected' : '' }}>{{ __('site.subject_model_museum') }}</option>
                    <option value="Matematik Atölyesi" {{ old('subject') === 'Matematik Atölyesi' ? 'selected' : '' }}>{{ __('site.subject_math_workshop') }}</option>
                    <option value="Ahşap Dekoratif Ürünler" {{ old('subject') === 'Ahşap Dekoratif Ürünler' ? 'selected' : '' }}>{{ __('site.subject_wood_decor') }}</option>
                    <option value="Diğer" {{ old('subject') === 'Diğer' ? 'selected' : '' }}>{{ __('site.subject_other') }}</option>
                  </select>
                  <label for="subject"><i class="bi bi-tag me-1"></i>{{ __('site.contact_subject') }}</label>
                  <div class="invalid-feedback">{{ __('site.contact_subject_error') }}</div>
                </div>
              </div>

              <!-- Mesaj -->
              <div class="col-12">
                <div class="form-floating">
                  <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" placeholder="{{ __('site.contact_message') }}" rows="5" required style="height:140px" data-testid="input-message">{{ old('message') }}</textarea>
                  <label for="message"><i class="bi bi-chat-text me-1"></i>{{ __('site.contact_message') }}</label>
                  <div class="invalid-feedback">{{ __('site.contact_message_error') }}</div>
                </div>
              </div>

              <!-- KVKK -->
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="kvkk" name="kvkk" required data-testid="checkbox-kvkk">
                  <label class="form-check-label" for="kvkk" style="font-size:0.85rem;color:var(--text-muted)">
                    <a href="#" style="color:var(--turquoise)">{{ __('site.contact_kvkk_link') }}</a>{{ __('site.contact_kvkk_suffix') }}
                  </label>
                  <div class="invalid-feedback">{{ __('site.contact_kvkk_error') }}</div>
                </div>
              </div>

              <!-- Gönder -->
              <div class="col-12">
                <button type="submit" id="contactSubmitBtn" class="btn-primary-custom w-100 justify-content-center"
                  style="display:flex;padding:0.85rem" data-testid="contact-submit-btn">
                  <i class="bi bi-send-fill me-1"></i> {{ __('site.contact_submit') }}
                </button>
                @if(env('RECAPTCHA_SITE_KEY'))
                  <div class="text-center mt-2" style="font-size:0.75rem;color:var(--text-muted)">
                    {!! __('site.contact_recaptcha') !!}
                  </div>
                @endif
              </div>

              <!-- Veya WhatsApp -->
              <div class="col-12">
                <div class="text-center py-2">
                  <span style="font-size:0.85rem;color:var(--text-muted)">— {{ __('site.contact_or') }} —</span>
                </div>
                @if(setting('contact_whatsapp'))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('contact_whatsapp')) }}?text={{ urlencode(__('site.whatsapp_float_msg')) }}"
                  class="btn-whatsapp w-100 justify-content-center" onclick="return!window.open(this.href)"
                  style="display:flex;padding:0.85rem" data-testid="contact-whatsapp-btn">
                  <i class="bi bi-whatsapp"></i> {{ __('site.contact_whatsapp_btn') }}
                </a>
                @endif
              </div>

            </div>
          </form>
        </div>
      </div>

    </div>

    <!-- ===================================
         Harita
         =================================== -->
    <div class="mt-6 reveal" data-testid="map-section">
      <h3 class="reviews-section-title">
        <i class="bi bi-map me-2 text-turquoise"></i>{{ __('site.contact_map') }}
      </h3>
      <div class="map-iframe-container">
        {!! setting('google_maps_iframe') ?? '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.15830869428!2d28.87717009!3d41.0082376!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caa7040068086b%3A0xe1ccfe98bc01b0d0!2zxLBzdGFuYnVs!5e0!3m2!1str!2str!4v1703000000000!5m2!1str!2str" width="100%" height="420" style="border:0;display:block" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="MATIXO Konum Haritası" data-testid="map-iframe"></iframe>' !!}
      </div>
    </div>

    <!-- ===================================
         SSS
         =================================== -->
    <section class="mt-6" data-testid="faq-section">
      <div class="text-center mb-4 reveal">
        <span class="section-badge">{{ __('site.contact_faq_badge') }}</span>
        <h2 class="section-title" style="font-size:1.8rem">{{ __('site.contact_faq_title') }}</h2>
      </div>
      @if($faqs->isNotEmpty())
      <div class="row g-3">
        @php
          $half = ceil($faqs->count() / 2);
          $leftFaqs = $faqs->take($half);
          $rightFaqs = $faqs->slice($half);
        @endphp
        <div class="col-lg-6 reveal delay-1">
          <div class="accordion" id="faqLeft">
            @foreach($leftFaqs as $faq)
              <div class="accordion-item border rounded-3 mb-3 overflow-hidden">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed accordion-header-white" type="button" data-bs-toggle="collapse" data-bs-target="#faqL{{ $faq->id }}">
                    <i class="bi bi-question-circle me-2 text-turquoise"></i>
                    {{ str_replace('{product}', 'MATIXO', gt($faq, 'question')) }}
                  </button>
                </h3>
                <div id="faqL{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqLeft">
                  <div class="accordion-body accordion-body-gray">
                    {!! nl2br(e(str_replace('{product}', 'MATIXO', gt($faq, 'answer')))) !!}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="col-lg-6 reveal delay-2">
          <div class="accordion" id="faqRight">
            @foreach($rightFaqs as $faq)
              <div class="accordion-item border rounded-3 mb-3 overflow-hidden">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed accordion-header-white" type="button" data-bs-toggle="collapse" data-bs-target="#faqR{{ $faq->id }}">
                    <i class="bi bi-question-circle me-2 text-turquoise"></i>
                    {{ str_replace('{product}', 'MATIXO', gt($faq, 'question')) }}
                  </button>
                </h3>
                <div id="faqR{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqRight">
                  <div class="accordion-body accordion-body-gray">
                    {!! nl2br(e(str_replace('{product}', 'MATIXO', gt($faq, 'answer')))) !!}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      @endif
    </section>

  </div>
</main>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function() {
  'use strict';

  // ── SweetAlert2 MATIXO teması ──
  var swal = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-primary px-5 py-2',
      cancelButton:  'btn btn-outline-secondary px-4 py-2 ms-2',
    },
    buttonsStyling: false,
    fontFamily: "'Outfit', sans-serif",
  });

  @if(session('success'))
  // Başarı popup’u
  swal.fire({
    icon: 'success',
    iconColor: '#41B7A8',
    title: '{{ __('site.contact_success_title') }}',
    html: '<p style="color:#4A6270;font-size:0.95rem">{{ session('success') }}</p>',
    confirmButtonText: '{{ __('site.contact_success_btn') }}',
  }).then(function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
  @endif

  @if($errors->any())
  swal.fire({
    icon: 'warning',
    iconColor: '#F09237',
    title: '{{ __('site.contact_error_title') }}',
    html: '<ul style="text-align:left;color:#4A6270;font-size:0.9rem;margin:0;padding-left:1.2rem">' +
      @foreach($errors->all() as $error)
        '<li>{{ addslashes($error) }}</li>' +
      @endforeach
    '</ul>',
    confirmButtonText: '{{ __('site.contact_error_btn') }}',
  });
  @endif

  // ── Form HTML5 validation ──
  var form = document.getElementById('contactForm');
  if (form) {
    form.addEventListener('submit', function(e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        form.classList.add('was-validated');
      }
    }, false);
  }
}());
</script>

@if(env('RECAPTCHA_SITE_KEY'))
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
<script>
  document.getElementById('contactForm')?.addEventListener('submit', function(e) {
    if (!this.checkValidity()) {
      return; // Validation geçmediyse reCAPTCHA tetikleme
    }
    e.preventDefault();
    const form = this;
    const btn = document.getElementById('contactSubmitBtn');
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Gönderiliyor...';
    }
    grecaptcha.ready(function() {
      grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', { action: 'submit_contact' }).then(function(token) {
        document.getElementById('recaptchaToken').value = token;
        form.submit();
      });
    });
  });
</script>
@endif
@endpush
@endsection
