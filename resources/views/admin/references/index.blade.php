@extends('admin.layouts.master')
@section('title', 'Referanslar')
@section('page-actions')
  <a href="{{ route('admin.references.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Yeni Referans</a>
@endsection
@section('content')
<x-list-card :items="$items">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr class="small text-uppercase text-muted">
        <th width="40"></th><th width="80">Logo</th><th>Ad</th><th>Link</th><th width="80">Durum</th><th width="120" class="text-end">İşlem</th>
      </tr></thead>
      <tbody data-sortable data-sortable-url="{{ route('admin.references.reorder') }}">
        @forelse($items as $r)
          <tr data-id="{{ $r->id }}">
            <td><i class="bi bi-grip-vertical sortable-handle"></i></td>
            <td>@if($r->logo)<img src="{{ asset('storage/'.$r->logo) }}" width="50" height="50" style="object-fit:contain">@endif</td>
            <td class="fw-semibold small">{{ $r->name }}</td>
            <td class="small text-muted">{{ $r->link_url ?: '—' }}</td>
            <td><form method="POST" action="{{ route('admin.references.toggle', $r->id) }}" class="d-inline">@csrf @method('PATCH')<button class="badge border-0 {{ $r->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $r->is_active ? 'Aktif' : 'Pasif' }}</button></form></td>
            <td class="text-end">
              <a href="{{ route('admin.references.edit', $r->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.references.destroy', $r->id) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-light text-danger" data-confirm="Silinsin mi?"><i class="bi bi-trash"></i></button></form>
            </td>
          </tr>
        @empty <tr><td colspan="6" class="text-center text-muted py-4">Referans yok.</td></tr> @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
