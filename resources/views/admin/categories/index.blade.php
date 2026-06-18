@extends('admin.layouts.master')
@section('title', 'Kategoriler')

@section('page-actions')
  <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
    <i class="bi bi-plus-lg"></i> Yeni Kategori
  </a>
@endsection

@section('content')
<x-list-card :items="$items" search-placeholder="Kategori adı veya slug ara...">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr class="small text-uppercase text-muted">
          <th width="40"></th>
          <th>Kategori</th>
          <th>Slug</th>
          <th width="100">Ürünler</th>
          <th width="80">Anasayfa</th>
          <th width="80">Durum</th>
          <th width="120" class="text-end">İşlemler</th>
        </tr>
      </thead>
      <tbody data-sortable data-sortable-url="{{ route('admin.categories.reorder') }}">
        @forelse($items as $cat)
          <tr data-id="{{ $cat->id }}">
            <td><i class="bi bi-grip-vertical sortable-handle"></i></td>
            <td>
              <div class="d-flex align-items-center gap-2">
                @if($cat->image)
                  <img src="{{ asset('storage/'.$cat->image) }}" class="rounded" width="36" height="36" style="object-fit:cover">
                @else
                  <span class="text-muted" style="font-size:1.3rem"><i class="{{ $cat->icon ?: 'bi-folder' }}"></i></span>
                @endif
                <div>
                  <div class="fw-semibold small">{{ $cat->getTranslation('name', default_locale()) }}</div>
                  @if($cat->parent_id)<div class="text-muted small">↳ {{ $cat->parent?->getTranslation('name', default_locale()) }}</div>@endif
                </div>
              </div>
            </td>
            <td class="small text-muted"><code>{{ $cat->slug }}</code></td>
            <td><span class="badge bg-light text-dark">{{ $cat->products()->count() }}</span></td>
            <td>{!! $cat->show_on_home ? '<span class="badge bg-success">Açık</span>' : '<span class="badge bg-secondary">Kapalı</span>' !!}</td>
            <td>
              <form method="POST" action="{{ route('admin.categories.toggle', $cat->id) }}" class="d-inline">
                @csrf @method('PATCH')
                <button class="badge border-0 {{ $cat->is_active ? 'bg-success' : 'bg-secondary' }}">
                  {{ $cat->is_active ? 'Aktif' : 'Pasif' }}
                </button>
              </form>
            </td>
            <td class="text-end">
              <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-light text-danger" data-confirm="Bu kategori silinsin mi? Bağlı ürünlerin kategorisi temizlenmez ama listede gözükmez."><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted py-4">Henüz kategori yok.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
