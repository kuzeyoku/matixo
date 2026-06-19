@extends('admin.layouts.master')
@section('title', 'Ürünler')

@section('page-actions')
  <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
    <i class="bi bi-plus-lg"></i> Yeni Ürün
  </a>
@endsection

@section('content')
<x-list-card :items="$items" search-placeholder="Ürün adı, kodu veya slug ara...">
  {{-- Ekstra kategori filtresi --}}
  <div class="card-body border-bottom border-top-0 pt-0">
    <form method="GET" class="d-inline">
      @foreach(request()->except('category_id') as $k => $v)<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endforeach
      <select name="category_id" class="form-select form-select-sm d-inline-block" style="width:auto" onchange="this.form.submit()">
        <option value="">Tüm kategoriler</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->getTranslation('name', default_locale()) }}</option>
        @endforeach
      </select>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr class="small text-uppercase text-muted">
          <th width="40"></th>
          <th>Ürün</th>
          <th>Kategori</th>
          <th width="90">Kod</th>
          <th width="100">Fiyat</th>
          <th width="80">Öne Çıkan</th>
          <th width="80">Durum</th>
          <th width="120" class="text-end">İşlemler</th>
        </tr>
      </thead>
      <tbody data-sortable data-sortable-url="{{ route('admin.products.reorder') }}">
        @forelse($items as $p)
          <tr data-id="{{ $p->id }}">
            <td><i class="bi bi-grip-vertical sortable-handle"></i></td>
            <td>
              <div class="d-flex align-items-center gap-2">
                @if($p->cover_image)
                  <img src="{{ asset('storage/'.$p->cover_image) }}" class="rounded" width="46" height="46" style="object-fit:cover">
                @else
                  <div class="bg-light rounded" style="width:46px;height:46px;display:flex;align-items:center;justify-content:center"><i class="bi bi-box text-muted"></i></div>
                @endif
                <div>
                  <div class="fw-semibold small">{{ $p->getTranslation('title', default_locale()) }}</div>
                  @if($p->badge)<span class="badge bg-warning text-dark small">{{ ucfirst($p->badge) }}</span>@endif
                </div>
              </div>
            </td>
            <td class="small text-muted">{{ $p->category?->getTranslation('name', default_locale()) }}</td>
            <td class="small"><code>{{ $p->code ?: '—' }}</code></td>
            <td class="small fw-semibold">{{ $p->price ? '₺' . number_format($p->price, 2, ',', '.') : '—' }}</td>
            <td>{!! $p->is_featured ? '<i class="bi bi-star-fill text-warning"></i>' : '<i class="bi bi-star text-muted"></i>' !!}</td>
            <td>
              <form method="POST" action="{{ route('admin.products.toggle', $p->id) }}" class="d-inline">
                @csrf @method('PATCH')
                <button class="badge border-0 {{ $p->is_active ? 'bg-success' : 'bg-secondary' }}">
                  {{ $p->is_active ? 'Aktif' : 'Pasif' }}
                </button>
              </form>
            </td>
            <td class="text-end">
              <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-light text-danger" data-confirm="Bu ürün silinsin mi?"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center text-muted py-4">Henüz ürün yok.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
