@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('page-header')
  <div class="page-header mb-4">
    <h1 class="page-title h4 mb-1">Hoş geldin, {{ auth()->user()->name }} 👋</h1>
    <p class="page-subtitle text-muted mb-0">İşte bugünkü panel özeti.</p>
  </div>
@endsection

@section('content')
  {{-- İstatistik Kartları --}}
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
      <a href="{{ route('admin.products.index') }}" class="stat-card text-decoration-none" data-testid="stat-products">
        <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-box-seam"></i></div>
        <div class="stat-content">
          <div class="stat-label">Toplam Ürün</div>
          <div class="stat-number">{{ $stats['products_count'] }}</div>
          <div class="stat-sub text-success small"><i class="bi bi-check-circle"></i> {{ $stats['active_products_count'] }} aktif</div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-lg-3">
      <a href="{{ route('admin.categories.index') }}" class="stat-card text-decoration-none" data-testid="stat-categories">
        <div class="stat-icon bg-info-subtle text-info"><i class="bi bi-folder"></i></div>
        <div class="stat-content">
          <div class="stat-label">Kategori</div>
          <div class="stat-number">{{ $stats['categories_count'] }}</div>
          <div class="stat-sub text-muted small">Yapı içeriği</div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-lg-3">
      <a href="{{ route('admin.reviews.index') }}" class="stat-card text-decoration-none" data-testid="stat-reviews">
        <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-star"></i></div>
        <div class="stat-content">
          <div class="stat-label">Bekleyen Yorum</div>
          <div class="stat-number">{{ $stats['pending_reviews_count'] }}</div>
          <div class="stat-sub small">Moderasyon bekliyor</div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-lg-3">
      <a href="{{ route('admin.messages.index') }}" class="stat-card text-decoration-none" data-testid="stat-messages">
        <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-envelope"></i></div>
        <div class="stat-content">
          <div class="stat-label">Okunmamış Mesaj</div>
          <div class="stat-number">{{ $stats['unread_messages_count'] }}</div>
          <div class="stat-sub small">İletişim formundan</div>
        </div>
      </a>
    </div>
  </div>

  {{-- Hızlı eylemler --}}
  <div class="card mb-4 shadow-sm">
    <div class="card-body">
      <h5 class="h6 mb-3"><i class="bi bi-lightning-charge-fill text-warning me-1"></i>Hızlı Eylemler</h5>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Ürün Ekle</a>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-images"></i> Slider Yönet</a>
        <a href="{{ route('admin.campaign.edit') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-megaphone"></i> Kampanya Modal Düzenle</a>
        <a href="{{ route('admin.settings.edit') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-gear"></i> Ayarlar</a>
      </div>
    </div>
  </div>

  {{-- Son aktiviteler --}}
  <div class="row g-3">
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h5 class="h6 mb-0"><i class="bi bi-envelope-paper text-primary me-1"></i>Son Mesajlar</h5>
          <a href="{{ route('admin.messages.index') }}" class="small text-decoration-none">Tümü <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="list-group list-group-flush">
          @forelse($recent_messages as $msg)
            <div class="list-group-item d-flex justify-content-between align-items-start">
              <div>
                <div class="fw-semibold small">{{ $msg->name }} @if(!$msg->is_read)<span class="badge bg-primary ms-1">Yeni</span>@endif</div>
                <div class="small text-muted">{{ \Illuminate\Support\Str::limit($msg->message, 60) }}</div>
              </div>
              <span class="small text-muted">{{ $msg->created_at->diffForHumans() }}</span>
            </div>
          @empty
            <div class="list-group-item text-center text-muted small py-4">Henüz mesaj yok</div>
          @endforelse
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <h5 class="h6 mb-0"><i class="bi bi-clock-history text-info me-1"></i>Son Aktiviteler</h5>
          <a href="{{ route('admin.activity.index') }}" class="small text-decoration-none">Tümü <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="list-group list-group-flush">
          @forelse($recent_logs as $log)
            <div class="list-group-item d-flex justify-content-between align-items-start">
              <div>
                <div class="small">
                  <strong>{{ $log->user?->name ?? 'Sistem' }}</strong>
                  <span class="text-muted">— {{ $log->description }}</span>
                </div>
              </div>
              <span class="small text-muted">{{ $log->created_at?->diffForHumans() }}</span>
            </div>
          @empty
            <div class="list-group-item text-center text-muted small py-4">Henüz aktivite yok</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
@endsection
