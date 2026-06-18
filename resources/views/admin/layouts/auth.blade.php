<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Giriş') · {{ setting('site_name', 'MATIXO') }}</title>

  <link href="{{ asset('site/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('site/css/bootstrap-icons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('site/css/fonts.css') }}" rel="stylesheet">
  <link href="{{ admin_asset('admin/css/admin.css') }}" rel="stylesheet">
</head>
<body class="auth-body">
  <div class="auth-wrap">
    <div class="auth-panel">
      <div class="auth-brand">
        <span class="logo-text">MATI<span style="color:var(--mx-turquoise)">X</span>O</span>
        <p class="text-muted small mt-2 mb-0">Yönetim Paneli</p>
      </div>

      @include('admin.layouts.partials.flash')

      @yield('content')
    </div>

    <div class="auth-side d-none d-lg-flex">
      <div class="auth-side-content">
        <span class="badge bg-warning text-dark mb-3" style="letter-spacing:0.1em">GÜVENLİ GİRİŞ</span>
        <h2 class="mb-3" style="font-family:'Outfit',sans-serif;font-weight:800">Eğitim mekanlarını yönetin</h2>
        <p class="mb-0 text-white-50">Ürünler, kategoriler, kampanyalar ve daha fazlasını tek panelden yönetin.</p>
      </div>
    </div>
  </div>

  <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
