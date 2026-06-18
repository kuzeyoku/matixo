@extends('admin.layouts.master')
@section('title', 'Yorum Detayı')
@section('content')
<div class="row g-3">
  <div class="col-lg-8">
    <div class="card shadow-sm"><div class="card-body">
      <div class="d-flex justify-content-between mb-3">
        <div>
          <h5 class="mb-0">{{ $item->reviewer_name }}</h5>
          <div class="text-muted small">{{ $item->reviewer_org }} • {{ $item->reviewer_email ?: 'e-posta yok' }}</div>
        </div>
        <div>@for($i=0;$i<5;$i++)<i class="bi bi-star{{ $i<$item->rating?'-fill':'' }} text-warning"></i>@endfor</div>
      </div>
      <p class="lead">{{ $item->review_text }}</p>
      <div class="small text-muted mt-3">
        <i class="bi bi-clock"></i> {{ $item->created_at->format('d.m.Y H:i') }} •
        <i class="bi bi-globe"></i> {{ $item->ip_address }}
      </div>
    </div></div>
  </div>
  <div class="col-lg-4">
    <div class="card shadow-sm"><div class="card-body">
      <h6 class="text-muted small text-uppercase mb-2">Ürün</h6>
      <p class="mb-3">{{ $item->product?->getTranslation('title', default_locale()) }}</p>
      <h6 class="text-muted small text-uppercase mb-2">İşlemler</h6>
      <div class="d-grid gap-2">
        @if($item->status !== 'approved')
          <form method="POST" action="{{ route('admin.reviews.approve', $item->id) }}">@csrf @method('PATCH')<button class="btn btn-success w-100"><i class="bi bi-check-lg"></i> Onayla</button></form>
        @endif
        @if($item->status !== 'rejected')
          <form method="POST" action="{{ route('admin.reviews.reject', $item->id) }}">@csrf @method('PATCH')<button class="btn btn-warning w-100"><i class="bi bi-x-lg"></i> Reddet</button></form>
        @endif
        <form method="POST" action="{{ route('admin.reviews.destroy', $item->id) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger w-100" data-confirm="Yorum silinsin mi?"><i class="bi bi-trash"></i> Sil</button></form>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-light">Geri</a>
      </div>
    </div></div>
  </div>
</div>
@endsection
