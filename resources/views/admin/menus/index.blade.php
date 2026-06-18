@extends('admin.layouts.master')
@section('title', 'Menü Yönetimi')
@section('page-actions')
  <a href="{{ route('admin.menus.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Yeni Menü</a>
@endsection
@section('content')
<x-list-card :items="$items" search-placeholder="URL ara...">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr class="small text-uppercase text-muted">
        <th width="40"></th>
        <th>Başlık</th>
        <th>URL / Hedef</th>
        <th width="100">Tür</th>
        <th width="100">Alt Menü</th>
        <th width="80">Durum</th>
        <th width="120" class="text-end">İşlem</th>
      </tr></thead>
      <tbody>
        @forelse($items as $m)
          {{-- Ana Menü Satırı --}}
          <tr>
            <td class="text-muted"><i class="bi bi-grip-vertical sortable-handle" style="cursor:grab"></i></td>
            <td class="fw-semibold small">
              @if($m->icon)<i class="{{ $m->icon }} me-1 text-muted"></i>@endif
              {{ $m->getTranslation('title', default_locale()) }}
            </td>
            <td class="small text-muted"><code>{{ $m->url ?: '—' }}</code></td>
            <td>
              @php $typeLabels = ['url'=>'URL','route'=>'Rota','page'=>'Sayfa','category'=>'Kategori']; @endphp
              <span class="badge bg-light text-muted">{{ $typeLabels[$m->link_type] ?? $m->link_type }}</span>
            </td>
            <td>
              @if($m->children->count())
                <span class="badge bg-info">{{ $m->children->count() }} alt</span>
              @else
                <span class="badge bg-light text-muted">—</span>
              @endif
            </td>
            <td>
              <form method="POST" action="{{ route('admin.menus.toggle', $m->id) }}" class="d-inline">@csrf @method('PATCH')
                <button class="badge border-0 {{ $m->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $m->is_active ? 'Aktif' : 'Pasif' }}</button>
              </form>
            </td>
            <td class="text-end">
              <a href="{{ route('admin.menus.edit', $m->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.menus.destroy', $m->id) }}" class="d-inline">@csrf @method('DELETE')
                <button class="btn btn-sm btn-light text-danger" data-confirm="Silinsin mi?"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>

          {{-- Alt Menü Satırları --}}
          @foreach($m->children as $child)
          <tr style="background:var(--mx-bg, #f8f9fa)">
            <td></td>
            <td class="small ps-4">
              <i class="bi bi-arrow-return-right me-1 text-muted"></i>
              @if($child->icon)<i class="{{ $child->icon }} me-1 text-muted"></i>@endif
              {{ $child->getTranslation('title', default_locale()) }}
            </td>
            <td class="small text-muted"><code>{{ $child->url ?: '—' }}</code></td>
            <td>
              <span class="badge bg-light text-muted">{{ $typeLabels[$child->link_type] ?? $child->link_type }}</span>
            </td>
            <td></td>
            <td>
              <form method="POST" action="{{ route('admin.menus.toggle', $child->id) }}" class="d-inline">@csrf @method('PATCH')
                <button class="badge border-0 {{ $child->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $child->is_active ? 'Aktif' : 'Pasif' }}</button>
              </form>
            </td>
            <td class="text-end">
              <a href="{{ route('admin.menus.edit', $child->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.menus.destroy', $child->id) }}" class="d-inline">@csrf @method('DELETE')
                <button class="btn btn-sm btn-light text-danger" data-confirm="Silinsin mi?"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
          @endforeach
        @empty
          <tr><td colspan="7" class="text-center text-muted py-4">Henüz menü öğesi eklenmemiş.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
