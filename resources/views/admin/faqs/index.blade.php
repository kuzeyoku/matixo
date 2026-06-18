@extends('admin.layouts.master')
@section('title', 'Sıkça Sorulan Sorular (SSS)')
@section('page-actions')
  <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Yeni SSS Ekle</a>
@endsection

@section('content')
<x-list-card :items="$items" search-placeholder="Soru ara...">
  <div class="card-body border-bottom border-top-0 pt-0 pb-3">
    <form method="GET" action="{{ route('admin.faqs.index') }}" class="row g-2 align-items-center">
      <div class="col-auto">
        <select name="product_id" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">— Tüm Sorular (Filtresiz) —</option>
          <option value="null" @selected(request('product_id') === 'null')>Sadece Genel Sorular</option>
          @foreach($products as $prod)
            <option value="{{ $prod->id }}" @selected(request('product_id') == $prod->id)>
              {{ $prod->getTranslation('title', default_locale()) }}
            </option>
          @endforeach
        </select>
      </div>
      @if(request('search') || request('product_id'))
        <div class="col-auto">
          <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x-lg"></i> Temizle</a>
        </div>
      @endif
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr class="small text-uppercase text-muted">
        <th width="40"></th><th>Soru</th><th>İlişkili Ürün</th><th width="80">Durum</th><th width="120" class="text-end">İşlem</th>
      </tr></thead>
      <tbody data-sortable data-sortable-url="{{ route('admin.faqs.reorder') }}">
        @forelse($items as $item)
          <tr data-id="{{ $item->id }}">
            <td><i class="bi bi-grip-vertical sortable-handle"></i></td>
            <td>
              <div class="fw-semibold small">{{ $item->getTranslation('question', default_locale()) }}</div>
              <div class="text-muted small text-truncate" style="max-width: 400px;">
                {{ Str::limit(strip_tags($item->getTranslation('answer', default_locale())), 80) }}
              </div>
            </td>
            <td>
              @if($item->product)
                <span class="badge bg-light text-dark border"><i class="bi bi-box-seam me-1 text-primary"></i>{{ $item->product->getTranslation('title', default_locale()) }}</span>
              @else
                <span class="badge bg-light text-muted border"><i class="bi bi-globe me-1"></i>Genel SSS</span>
              @endif
            </td>
            <td>
              <form method="POST" action="{{ route('admin.faqs.toggle', $item->id) }}" class="d-inline">
                @csrf @method('PATCH')
                <button class="badge border-0 {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                  {{ $item->is_active ? 'Aktif' : 'Pasif' }}
                </button>
              </form>
            </td>
            <td class="text-end">
              <a href="{{ route('admin.faqs.edit', $item->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.faqs.destroy', $item->id) }}" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-light text-danger" data-confirm="Bu SSS kaydını silmek istediğinize emin misiniz?"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty 
          <tr>
            <td colspan="5" class="text-center text-muted py-4">Soru bulunamadı.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
