<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Panel') · {{ setting('site_name', 'MATIXO') }}</title>

  <link href="{{ asset('site/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('site/css/bootstrap-icons.min.css') }}" rel="stylesheet">
  <link href="{{ admin_asset('admin/css/sweetalert2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('site/css/fonts.css') }}" rel="stylesheet">
  <link href="{{ admin_asset('admin/css/admin.css') }}" rel="stylesheet">
  @stack('styles')
</head>

<body class="admin-body">

  <div class="admin-wrapper">
    @include('admin.layouts.partials.sidebar')

    <div class="admin-main">
      @include('admin.layouts.partials.topbar')

      <main class="admin-content">
        @include('admin.layouts.partials.flash')

        @hasSection('page-header')
          @yield('page-header')
        @else
          <div class="page-header mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div>
                <h1 class="page-title h4 mb-1" data-testid="page-title">@yield('title')</h1>
                @hasSection('page-subtitle')<p class="page-subtitle text-muted mb-0">@yield('page-subtitle')</p>@endif
              </div>
              <div class="page-actions">
                @yield('page-actions')
              </div>
            </div>
          </div>
        @endif

        @yield('content')
      </main>

      <footer class="admin-footer">
        <span>&copy; {{ date('Y') }} {{ setting('site_name', 'MATIXO') }} Yönetim Paneli</span>
        <span class="text-muted">v1.0.0</span>
      </footer>
    </div>
  </div>

  <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ admin_asset('admin/js/sweetalert2.min.js') }}"></script>
  <script src="{{ admin_asset('admin/js/admin.js') }}"></script>
  @stack('scripts')
</body>

</html>