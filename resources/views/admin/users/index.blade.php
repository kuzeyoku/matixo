@extends('admin.layouts.master')
@section('title', 'Kullanıcılar')
@section('page-actions')
  <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-person-plus"></i> Yeni Kullanıcı</a>
@endsection
@section('content')
<x-list-card :items="$items" :show-active-filter="false" search-placeholder="Ad/email ara...">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr class="small text-uppercase text-muted">
        <th>Kullanıcı</th><th>E-posta</th><th width="120">Son Giriş</th><th width="100">Durum</th><th width="180" class="text-end">İşlem</th>
      </tr></thead>
      <tbody>
        @forelse($items as $u)
          <tr>
            <td><div class="d-flex align-items-center gap-2">
              <span class="user-avatar" style="width:32px;height:32px;font-size:0.8rem">{{ mb_strtoupper(mb_substr($u->name,0,1)) }}</span>
              <div><div class="fw-semibold small">{{ $u->name }}</div><div class="small text-muted">{{ ucfirst($u->role) }}</div></div>
            </div></td>
            <td class="small">{{ $u->email }}</td>
            <td class="small text-muted">{{ $u->last_login_at?->diffForHumans() ?? 'Hiç' }}<br>{{ $u->last_login_ip }}</td>
            <td>
              @if($u->isLocked())<span class="badge bg-danger">Kilitli</span>
              @elseif(!$u->is_active)<span class="badge bg-secondary">Pasif</span>
              @else<span class="badge bg-success">Aktif</span>@endif
            </td>
            <td class="text-end">
              @if($u->isLocked())
                <form method="POST" action="{{ route('admin.users.unlock', $u->id) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-warning" title="Kilidi aç"><i class="bi bi-unlock"></i></button></form>
              @endif
              @if($u->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.toggle', $u->id) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-light" title="Aktif/Pasif"><i class="bi bi-power"></i></button></form>
              @endif
              <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
              @if($u->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-light text-danger" data-confirm="Kullanıcı silinsin mi?"><i class="bi bi-trash"></i></button></form>
              @endif
            </td>
          </tr>
        @empty <tr><td colspan="5" class="text-center text-muted py-4">Kullanıcı yok.</td></tr> @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
