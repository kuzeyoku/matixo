@extends('admin.layouts.master')
@section('title', 'Aktivite Logları')
@section('content')
<x-list-card :items="$items" :show-active-filter="false" search-placeholder="Açıklama ara...">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr class="small text-uppercase text-muted">
        <th width="180">Tarih</th><th width="160">Kullanıcı</th><th width="120">Eylem</th><th>Açıklama</th><th width="130">IP</th>
      </tr></thead>
      <tbody>
        @forelse($items as $log)
          <tr>
            <td class="small text-muted">{{ $log->created_at?->format('d.m.Y H:i:s') }}</td>
            <td class="small">{{ $log->user?->name ?? '—' }}</td>
            <td>
              @php $actionColors = ['create' => 'success', 'update' => 'info', 'delete' => 'danger', 'login' => 'primary', 'logout' => 'secondary', 'failed_login' => 'warning']; @endphp
              <span class="badge bg-{{ $actionColors[$log->action] ?? 'secondary' }}">{{ $log->action }}</span>
            </td>
            <td class="small">{{ $log->description }}</td>
            <td class="small text-muted"><code>{{ $log->ip_address }}</code></td>
          </tr>
        @empty <tr><td colspan="5" class="text-center text-muted py-4">Log yok.</td></tr> @endforelse
      </tbody>
    </table>
  </div>
</x-list-card>
@endsection
