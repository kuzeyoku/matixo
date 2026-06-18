@extends('admin.layouts.master')
@section('title', 'Yorumlar')
@section('content')
<x-list-card :items="$items" :show-active-filter="false" search-placeholder="Yorumcu adı/kurum ara...">
  <div class="card-body border-bottom border-top-0 pt-0">
    <div class="btn-group btn-group-sm">
      @foreach(['' => 'Tümü', 'pending' => 'Bekleyen', 'approved' => 'Onaylı', 'rejected' => 'Reddedildi'] as $k => $v)
        <a href="{{ url()->current().'?status='.$k }}" class="btn btn-outline-primary {{ request('status', '') === $k ? 'active' : '' }}">{{ $v }}</a>
      @endforeach
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr class="small text-uppercase text-muted">
        <th>Yorumcu</th><th>Ürün</th><th width="100">Puan</th><th>Önizleme</th><th width="100">Durum</th><th width="180" class="text-end">İşlem</th>
      </tr></thead>
      <tbody>
        @forelse($items as $r)
          <tr>
            <td><div class="fw-semibold small">{{ $r->reviewer_name }}</div><div class="text-muted small">{{ $r->reviewer_org }}</div></td>
            <td class="small">{{ $r->product?->getTranslation('title', default_locale()) }}</td>
            <td>@for($i=0;$i<5;$i++)<i class="bi bi-star{{ $i<$r->rating?'-fill':'' }} text-warning small"></i>@endfor</td>
            <td class="small text-muted">{{ \Illuminate\Support\Str::limit($r->review_text, 80) }}</td>
            <td>
              @php $s = ['pending' => ['warning', 'Bekliyor'], 'approved' => ['success', 'Onaylı'], 'rejected' => ['danger', 'Reddedildi']][$r->status]; @endphp
              <span class="badge bg-{{ $s[0] }}">{{ $s[1] }}</span>
            </td>
            <td class="text-end">
              <a href="{{ route('admin.reviews.show', $r->id) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a>
              @if($r->status !== 'approved')
                <form method="POST" action="{{ route('admin.reviews.approve', $r->id) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-success" title="Onayla"><i class="bi bi-check-lg"></i></button></form>
              @endif
              @if($r->status !== 'rejected')
                <form method="POST" action="{{ route('admin.reviews.reject', $r->id) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-warning" title="Reddet"><i class="bi bi-x-lg"></i></button></form>
              @endif
              <form method="POST" action="{{ route('admin.reviews.destroy', $r->id) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-light text-danger" data-confirm="Silinsin mi?"><i class="bi bi-trash"></i></button></form>
            </td>
          </tr>
        @empty <tr><td colspan="6" class="text-center text-muted py-4">Yorum yok.</td></tr> @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
