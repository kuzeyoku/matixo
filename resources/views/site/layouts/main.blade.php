<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="robots" content="index, follow">
  <meta name="author" content="MATIXO">
  <title>@yield('title', setting('seo_meta_title'))</title>
  <meta name="description" content="@yield('meta_description', setting('seo_meta_description'))">
  <meta name="keywords" content="@yield('keywords', setting('seo_meta_keywords'))">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:title" content="@yield('title', setting('seo_meta_title'))">
  <meta property="og:description" content="@yield('meta_description', setting('seo_meta_description'))">
  <meta property="og:image" content="{{ asset('site/images/og-image.jpg') }}">
  <meta property="og:locale" content="{{ app()->getLocale() === 'tr' ? 'tr_TR' : 'en_US' }}">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('title', setting('seo_meta_title'))">
  <meta name="twitter:description" content="@yield('meta_description', setting('seo_meta_description'))">

  <!-- Canonical -->
  <link rel="canonical" href="{{ url()->current() }}">

  <!-- Bootstrap 5 -->
  <link href="{{ asset('site/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="{{ asset('site/css/bootstrap-icons.min.css') }}" rel="stylesheet">
  <!-- Fonts (Outfit + Work Sans) -->
  <link rel="stylesheet" href="{{ asset('site/css/fonts.css') }}">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{asset('site/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('site/css/animations.css')}}">

  @stack('styles')

  <!-- Schema.org JSON-LD -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "Organization",
    "name": "MATIXO",
    "url": "https://www.matixo.com.tr",
    "logo": "https://www.matixo.com.tr/images/logo.png",
    "description": "{{ setting("seo_meta_description") }}",
    "address": {
      "@@type": "PostalAddress",
      "addressCountry": "TR",
      "addressLocality": "Aydın"
    },
    "contactPoint": {
      "@@type": "ContactPoint",
      "telephone": "{{ setting("contact_phone") }}",
      "contactType": "customer service",
      "availableLanguage": ["Turkish", "English"]
    },
    "sameAs": [
      "{{ setting("social_instagram") }}",
      "{{ setting("social_linkedin") }}",
      "{{ setting("social_youtube") }}",
      "{{ setting("social_facebook") }}",
      "{{ setting("social_twitter") }}"
    ]
  }
  </script>
</head>

<body>

  <!-- Sayfa Yükleme Çubuğu -->
  <div class="page-loader"></div>

  <!-- ===================================
     Üst Bilgi Çubuğu
     =================================== -->
  <div class="topbar d-none d-md-block">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex gap-3">
          <a href="tel:{{ setting("contact_phone") }}"><i
              class="bi bi-telephone-fill me-1"></i>{{ setting("contact_phone") }}</a>
          <a href="mailto:{{ setting("contact_email") }}"><i
              class="bi bi-envelope-fill me-1"></i>{{ setting("contact_email") }}</a>
        </div>
        <div class="d-flex gap-3">
          <span><i class="bi bi-clock me-1"></i>{{ setting("working_hours") }}</span>
          <a href="https://wa.me/{{ setting("contact_whatsapp") }}" onclick="return!window.open(this.href)">
            <i class="bi bi-whatsapp me-1"></i>WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================================
     Header / Navbar
     =================================== -->

  @include("site.layouts.header")

  @yield("content")

  <!-- ===================================
     Footer
     =================================== -->
  @include('site.layouts.footer')

  <!-- ===================================
     Kampanya / Duyuru Modalı
     =================================== -->
  @include("site.layouts.modal")

  <!-- ===================================
     Çerez Bildirimi
     =================================== -->
  @include("site.layouts.cookie")

  <!-- WhatsApp Float -->
  @include("site.layouts.buttons")


  <!-- Bootstrap JS -->
  <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Custom JS -->
  <script src="{{asset('site/js/main.js')}}"></script>

  @stack('scripts')
</body>

</html>