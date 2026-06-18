@extends('admin.layouts.master')
@section('title', 'Sayfalar')
@section('page-actions')
  <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Yeni Sayfa</a>
@endsection
@section('content')
<x-list-card :items="$items" search-placeholder="Slug ara...">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr class="small text-uppercase text-muted">
        <th>Başlık</th><th>Slug</th><th width="120">Footer</th><th width="80">Durum</th><th width="120" class="text-end">İşlem</th>
      </tr></thead>
      <tbody>
        @forelse($items as $p)
          <tr>
            <td class="fw-semibold small">{{ $p->getTranslation('title', default_locale()) }}</td>
            <td class="small text-muted"><code>{{ $p->slug }}</code></td>
            <td>{!! $p->show_in_footer ? '<span class="badge bg-info">Footerda</span>' : '<span class="badge bg-light text-muted">—</span>' !!}</td>
            <td><form method="POST" action="{{ route('admin.pages.toggle', $p->id) }}" class="d-inline">@csrf @method('PATCH')<button class="badge border-0 {{ $p->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $p->is_active ? 'Aktif' : 'Pasif' }}</button></form></td>
            <td class="text-end">
              <a href="{{ route('admin.pages.edit', $p->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.pages.destroy', $p->id) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-light text-danger" data-confirm="Silinsin mi?"><i class="bi bi-trash"></i></button></form>
            </td>
          </tr>
        @empty <tr><td colspan="5" class="text-center text-muted py-4">Sayfa yok.</td></tr> @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
