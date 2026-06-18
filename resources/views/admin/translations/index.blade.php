@extends('admin.layouts.master')
@section('title', 'Çeviri Yönetimi')
@section('page_title', 'Çeviri Yönetimi')

@section('content')
  <div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
      <h5 class="mb-0 text-dark fw-bold">Çeviriler</h5>
      <div class="d-flex gap-2">
        <form action="{{ route('admin.translations.import') }}" method="POST" class="d-inline"
          onsubmit="return confirm('Mevcut dil dosyalarındaki çeviri anahtarları veritabanına aktarılacak/güncellenecektir. Devam edilsin mi?');">
          @csrf
          <button type="submit" class="btn btn-sm btn-outline-success">
            <i class="bi bi-arrow-repeat"></i> Dosyadan İçe Aktar
          </button>
        </form>
        <a href="{{ route('admin.translations.create') }}" class="btn btn-sm btn-primary">
          <i class="bi bi-plus-lg"></i> Yeni Çeviri
        </a>
      </div>
    </div>
    
    <div class="card-body bg-light border-bottom py-3">
      <form method="GET" action="{{ route('admin.translations.index') }}" class="row g-2 align-items-center">
        <div class="col-md-6 col-lg-4">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control border-start-0 ps-0" 
              placeholder="Grup, anahtar veya çeviri metninde ara..." value="{{ $search ?? '' }}">
            <button class="btn btn-primary" type="submit">Ara</button>
            @if($search)
              <a href="{{ route('admin.translations.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-lg"></i> Temizle
              </a>
            @endif
          </div>
        </div>
      </form>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th width="150">Grup</th>
            <th>Anahtar (Key)</th>
            <th>Çeviriler (TR, EN vb.)</th>
            <th class="text-end" width="100">İşlem</th>
          </tr>
        </thead>
        <tbody>
          @forelse($translations as $item)
            <tr>
              <td><span class="badge bg-secondary">{{ $item->group }}</span></td>
              <td><code class="text-dark">{{ $item->key }}</code></td>
              <td>
                @foreach($item->text as $locale => $text)
                  <div class="mb-1">
                    <span class="badge bg-primary me-1">{{ strtoupper($locale) }}</span>
                    <span class="text-muted small">{{ Str::limit($text, 50) }}</span>
                  </div>
                @endforeach
              </td>
              <td class="text-end">
                <a href="{{ route('admin.translations.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('admin.translations.destroy', $item->id) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Emin misiniz?');">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center py-4 text-muted">Kayıt bulunamadı.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($translations->hasPages())
      <div class="card-footer bg-white border-top-0 pb-0">
        {{ $translations->links() }}
      </div>
    @endif
  </div>
@endsection