@extends('admin.layouts.master')
@section('title', 'Sliderlar')
@section('page-actions')
  <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Yeni Slider</a>
@endsection

@section('content')
<x-list-card :items="$items">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr class="small text-uppercase text-muted">
        <th width="40"></th><th width="100">Görsel</th><th>Başlık</th><th>Link</th><th width="130">Tarih</th><th width="80">Durum</th><th width="120" class="text-end">İşlem</th>
      </tr></thead>
      <tbody data-sortable data-sortable-url="{{ route('admin.sliders.reorder') }}">
        @forelse($items as $s)
          <tr data-id="{{ $s->id }}">
            <td><i class="bi bi-grip-vertical sortable-handle"></i></td>
            <td>@if($s->image)<img src="{{ asset('storage/'.$s->image) }}" class="rounded" width="80" height="50" style="object-fit:cover">@endif</td>
            <td><div class="fw-semibold small">{{ $s->getTranslation('title', default_locale()) }}</div></td>
            <td class="small text-muted">{{ $s->link_url ?: '—' }}</td>
            <td class="small">{{ $s->starts_at?->format('d.m.Y') ?? '—' }}<br>{{ $s->ends_at?->format('d.m.Y') ?? '—' }}</td>
            <td><form method="POST" action="{{ route('admin.sliders.toggle', $s->id) }}" class="d-inline">@csrf @method('PATCH')<button class="badge border-0 {{ $s->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $s->is_active ? 'Aktif' : 'Pasif' }}</button></form></td>
            <td class="text-end">
              <a href="{{ route('admin.sliders.edit', $s->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.sliders.destroy', $s->id) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-light text-danger" data-confirm="Slider silinsin mi?"><i class="bi bi-trash"></i></button></form>
            </td>
          </tr>
        @empty <tr><td colspan="7" class="text-center text-muted py-4">Slider yok.</td></tr> @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
