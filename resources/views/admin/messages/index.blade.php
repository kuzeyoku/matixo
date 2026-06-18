@extends('admin.layouts.master')
@section('title', 'İletişim Mesajları')
@section('content')
<x-list-card :items="$items" :show-active-filter="false" search-placeholder="Ad/email/konu ara...">
  <div class="card-body border-bottom border-top-0 pt-0">
    <div class="btn-group btn-group-sm">
      @foreach(['' => 'Tümü', '0' => 'Okunmamış', '1' => 'Okunmuş'] as $k => $v)
        <a href="{{ url()->current().'?is_read='.$k }}" class="btn btn-outline-primary {{ (string) request('is_read', '') === $k ? 'active' : '' }}">{{ $v }}</a>
      @endforeach
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr class="small text-uppercase text-muted">
        <th>Gönderen</th><th>Konu</th><th>Mesaj</th><th width="120">Tarih</th><th width="100">Durum</th><th width="100" class="text-end">İşlem</th>
      </tr></thead>
      <tbody>
        @forelse($items as $m)
          <tr class="{{ !$m->is_read ? 'fw-semibold' : '' }}">
            <td><div class="small">{{ $m->name }}</div><div class="text-muted small">{{ $m->email }}</div></td>
            <td class="small">{{ $m->subject ?: '—' }}</td>
            <td class="small text-muted">{{ \Illuminate\Support\Str::limit($m->message, 80) }}</td>
            <td class="small text-muted">{{ $m->created_at->format('d.m.Y H:i') }}</td>
            <td>
              @if(!$m->is_read)<span class="badge bg-primary">Yeni</span>
              @elseif($m->replied_at)<span class="badge bg-success">Yanıtlandı</span>
              @else<span class="badge bg-light text-muted">Okundu</span>@endif
            </td>
            <td class="text-end">
              <a href="{{ route('admin.messages.show', $m->id) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a>
              <form method="POST" action="{{ route('admin.messages.destroy', $m->id) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-light text-danger" data-confirm="Mesaj silinsin mi?"><i class="bi bi-trash"></i></button></form>
            </td>
          </tr>
        @empty <tr><td colspan="6" class="text-center text-muted py-4">Mesaj yok.</td></tr> @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
