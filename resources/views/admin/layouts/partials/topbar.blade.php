<header class="admin-topbar" data-testid="admin-topbar">
  <button class="btn topbar-toggle d-lg-none" id="sidebarToggle" aria-label="Menü">
    <i class="bi bi-list"></i>
  </button>

  <div class="topbar-search d-none d-md-flex">
    <i class="bi bi-search"></i>
    <input type="text" class="form-control border-0" placeholder="Hızlı arama..." data-testid="topbar-search">
  </div>

  <div class="topbar-actions ms-auto">
    @php
      $unreadCount = \App\Models\ContactMessage::unread()->count();
      $pendingReviews = \App\Models\Review::pending()->count();
    @endphp

    @if($pendingReviews > 0)
      <a href="{{ route('admin.reviews.index') }}" class="topbar-icon" title="Bekleyen yorumlar" data-testid="topbar-reviews-badge">
        <i class="bi bi-star"></i>
        <span class="topbar-badge bg-warning text-dark">{{ $pendingReviews }}</span>
      </a>
    @endif

    @if($unreadCount > 0)
      <a href="{{ route('admin.messages.index') }}" class="topbar-icon" title="Okunmamış mesajlar" data-testid="topbar-messages-badge">
        <i class="bi bi-envelope"></i>
        <span class="topbar-badge bg-primary">{{ $unreadCount }}</span>
      </a>
    @endif

    <form action="{{ route('admin.cache.clear') }}" method="POST" class="d-inline" id="cacheClearForm">
      @csrf
      <button type="submit" class="topbar-icon border-0 bg-transparent" title="Sistem Önbelleğini Temizle" data-confirm="Tüm sistem, route, config ve uygulama önbelleklerini temizlemek istediğinize emin misiniz?">
        <i class="bi bi-lightning-charge text-danger"></i>
      </button>
    </form>

    <a href="{{ url('/') }}" target="_blank" class="topbar-icon" title="Siteyi görüntüle" data-testid="topbar-view-site">
      <i class="bi bi-box-arrow-up-right"></i>
    </a>

    <div class="dropdown">
      <button class="topbar-user dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-testid="topbar-user-menu">
        <span class="user-avatar">{{ mb_strtoupper(mb_substr(auth()->user()?->name ?? 'U', 0, 1)) }}</span>
        <span class="d-none d-md-inline">{{ auth()->user()?->name }}</span>
        <i class="bi bi-chevron-down small"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm">
        <li><span class="dropdown-item-text small text-muted">{{ auth()->user()?->email }}</span></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item text-danger" data-testid="logout-btn">
              <i class="bi bi-box-arrow-right me-2"></i>Çıkış Yap
            </button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</header>
