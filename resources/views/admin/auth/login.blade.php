@extends('admin.layouts.auth')

@section('title', 'Giriş Yap')

@section('content')
  <h1 class="h4 mb-2" style="font-family:'Outfit',sans-serif;font-weight:700">Hoş geldin</h1>
  <p class="text-muted small mb-4">Panele erişmek için giriş yapın.</p>

  <form method="POST" action="{{ route('login.attempt') }}" autocomplete="off" novalidate data-testid="login-form">
    @csrf

    {{-- Honeypot — bot trap, kullanıcılar görmez --}}
    <input type="text" name="website" tabindex="-1" autocomplete="off"
           style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0">

    @if(env('RECAPTCHA_SITE_KEY'))
      <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
    @endif

    <div class="mb-3">
      <label class="form-label small fw-semibold">E-posta</label>
      <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
        <input type="email" name="email" value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="ornek@matixo.com" required autofocus
               data-testid="login-email-input">
      </div>
      @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
      <label class="form-label small fw-semibold">Şifre</label>
      <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="••••••••••" required
               data-testid="login-password-input">
        <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1" data-testid="toggle-password-btn">
          <i class="bi bi-eye"></i>
        </button>
      </div>
      @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4">
      <label class="form-check small">
        <input type="checkbox" name="remember" value="1" class="form-check-input" data-testid="login-remember">
        <span class="form-check-label">Beni hatırla</span>
      </label>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" data-testid="login-submit-btn">
      <i class="bi bi-box-arrow-in-right me-1"></i>Giriş Yap
    </button>
  </form>

  <p class="text-center text-muted small mt-4 mb-0">
    <i class="bi bi-shield-check me-1"></i>Bağlantı güvenli ve şifreli
  </p>

  <script>
    document.getElementById('togglePassword').addEventListener('click', function () {
      var input = document.querySelector('input[name=password]');
      var icon = this.querySelector('i');
      if (input.type === 'password') { input.type = 'text'; icon.className = 'bi bi-eye-slash'; }
      else { input.type = 'password'; icon.className = 'bi bi-eye'; }
    });
  </script>

  @if(env('RECAPTCHA_SITE_KEY'))
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <script>
      document.querySelector('[data-testid="login-form"]').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        grecaptcha.ready(function() {
          grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {action: 'login'}).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
            form.submit();
          });
        });
      });
    </script>
  @endif
@endsection
