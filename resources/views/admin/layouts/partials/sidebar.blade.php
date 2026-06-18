<aside class="admin-sidebar" id="adminSidebar" data-testid="admin-sidebar">
  <div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
      <span class="logo-text">MATI<span style="color:var(--mx-turquoise)">X</span>O</span>
    </a>
    <button class="btn btn-sm sidebar-close d-lg-none" id="sidebarClose" aria-label="Kapat">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">
      <span class="nav-section-label">Ana</span>
      <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-testid="nav-dashboard">
        <i class="bi bi-speedometer2"></i><span>Dashboard</span>
      </a>
    </div>

    <div class="nav-section">
      <span class="nav-section-label">Katalog</span>
      <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" data-testid="nav-products">
        <i class="bi bi-box-seam"></i><span>Ürünler</span>
      </a>
      <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" data-testid="nav-categories">
        <i class="bi bi-folder"></i><span>Kategoriler</span>
      </a>
      <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" data-testid="nav-reviews">
        <i class="bi bi-star"></i><span>Yorumlar</span>
      </a>
      <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}" data-testid="nav-faqs">
        <i class="bi bi-question-circle"></i><span>SSS Yönetimi</span>
      </a>
    </div>

    <div class="nav-section">
      <span class="nav-section-label">Anasayfa</span>
      <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" data-testid="nav-sliders">
        <i class="bi bi-images"></i><span>Sliderlar</span>
      </a>
      <a href="{{ route('admin.campaign.edit') }}" class="nav-link {{ request()->routeIs('admin.campaign.*') ? 'active' : '' }}" data-testid="nav-campaign">
        <i class="bi bi-megaphone"></i><span>Kampanya Modal</span>
      </a>
      <a href="{{ route('admin.references.index') }}" class="nav-link {{ request()->routeIs('admin.references.*') ? 'active' : '' }}" data-testid="nav-references">
        <i class="bi bi-award"></i><span>Referanslar</span>
      </a>
    </div>

    <div class="nav-section">
      <span class="nav-section-label">İçerik</span>
      <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" data-testid="nav-pages">
        <i class="bi bi-file-text"></i><span>Sayfalar</span>
      </a>
      <a href="{{ route('admin.menus.index') }}" class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}" data-testid="nav-menus">
        <i class="bi bi-list-nested"></i><span>Menü Yönetimi</span>
      </a>
      <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" data-testid="nav-messages">
        <i class="bi bi-envelope"></i><span>İletişim Mesajları</span>
      </a>
    </div>

    <div class="nav-section">
      <span class="nav-section-label">Yönetim</span>
      <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" data-testid="nav-settings">
        <i class="bi bi-gear"></i><span>Ayarlar</span>
      </a>
      <a href="{{ route('admin.languages.index') }}" class="nav-link {{ request()->routeIs('admin.languages.*') ? 'active' : '' }}" data-testid="nav-languages">
        <i class="bi bi-translate"></i><span>Diller</span>
      </a>
      <a href="{{ route('admin.translations.index') }}" class="nav-link {{ request()->routeIs('admin.translations.*') ? 'active' : '' }}" data-testid="nav-translations">
        <i class="bi bi-fonts"></i><span>Çeviriler (Metinler)</span>
      </a>
      <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-testid="nav-users">
        <i class="bi bi-people"></i><span>Kullanıcılar</span>
      </a>
      <a href="{{ route('admin.activity.index') }}" class="nav-link {{ request()->routeIs('admin.activity.*') ? 'active' : '' }}" data-testid="nav-activity">
        <i class="bi bi-clock-history"></i><span>Aktivite Logları</span>
      </a>
    </div>
  </nav>
</aside>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
