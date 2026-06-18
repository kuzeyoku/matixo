@extends('admin.layouts.master')
@section('title', 'Diller')
@section('page-actions')
  <a href="{{ route('admin.languages.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Yeni Dil</a>
@endsection
@section('content')
<div class="card shadow-sm"><div class="table-responsive">
  <table class="table table-hover align-middle mb-0">
    <thead><tr class="small text-uppercase text-muted">
      <th width="80">Bayrak</th><th>Ad</th><th width="80">Kod</th><th width="80">Yön</th><th width="100">Varsayılan</th><th width="80">Durum</th><th width="120" class="text-end">İşlem</th>
    </tr></thead>
    <tbody>
      @forelse($items as $l)
        <tr>
          <td><span style="font-size:1.5rem">{{ $l->flag }}</span></td>
          <td class="fw-semibold small">{{ $l->name }}</td>
          <td><code>{{ $l->code }}</code></td>
          <td class="small">{{ strtoupper($l->direction) }}</td>
          <td>{!! $l->is_default ? '<span class="badge bg-info">Varsayılan</span>' : '—' !!}</td>
          <td>{!! $l->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Pasif</span>' !!}</td>
          <td class="text-end">
            <a href="{{ route('admin.languages.edit', $l->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
            @if(!$l->is_default)
              <form method="POST" action="{{ route('admin.languages.destroy', $l->id) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-light text-danger" data-confirm="Bu dil silinsin mi? Çevirileri kaybolabilir."><i class="bi bi-trash"></i></button></form>
            @endif
          </td>
        </tr>
      @empty <tr><td colspan="7" class="text-center text-muted py-4">Dil yok.</td></tr> @endforelse
    </tbody>
  </table>
</div></div>
@endsection
