@extends('admin.layouts.master')
@section('title', 'Sistem Ayarları')
@include('admin.components.form-assets')

@section('content')
<div class="row g-3">
  <div class="col-lg-3">
    <div class="card shadow-sm"><div class="list-group list-group-flush">
      @foreach($sidebar as $key => $g)
        <a href="{{ route('admin.settings.edit', ['group' => $key]) }}"
           class="list-group-item list-group-item-action {{ $group === $key ? 'active' : '' }}">
          <i class="bi {{ $g['icon'] }} me-2"></i>{{ $g['label'] }}
        </a>
      @endforeach
    </div></div>
  </div>

  <div class="col-lg-9">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <input type="hidden" name="group" value="{{ $group }}">

      <div class="card shadow-sm"><div class="card-body">
        <h5 class="h6 mb-3">
          <i class="bi {{ $sidebar[$group]['icon'] ?? 'bi-gear' }} text-primary me-1"></i>
          {{ $sidebar[$group]['label'] ?? ucfirst($group) }}
        </h5>

        @forelse($groups[$group] ?? [] as $s)
          <div class="mb-3">
            <label class="form-label small fw-semibold">{{ $s->label ?: $s->key }}</label>

            @if($s->type === 'textarea')
              <textarea name="{{ $s->key }}" rows="3" class="form-control">{{ old($s->key, $s->value) }}</textarea>
            @elseif($s->type === 'image')
              @include('admin.components.dropify', ['name' => $s->key, 'value' => $s->value, 'label' => null])
            @elseif($s->type === 'boolean')
              <div class="form-check form-switch">
                <input type="hidden" name="{{ $s->key }}" value="0">
                <input class="form-check-input" type="checkbox" name="{{ $s->key }}" value="1" id="{{ $s->key }}" @checked(old($s->key, $s->value) == '1')>
                <label class="form-check-label small" for="{{ $s->key }}">{{ $s->description ?: 'Aktif' }}</label>
              </div>
            @elseif($s->type === 'password')
              <input type="password" name="{{ $s->key }}" value="" class="form-control" placeholder="(Değiştirmek için yazın, boş bırakırsanız korunur)">
            @elseif($s->type === 'html')
              <textarea name="{{ $s->key }}" data-quill data-toolbar="simple" class="form-control">{{ old($s->key, $s->value) }}</textarea>
            @else
              <input type="text" name="{{ $s->key }}" value="{{ old($s->key, $s->value) }}" class="form-control">
            @endif

            @if($s->description && $s->type !== 'boolean')
              <div class="form-text small">{{ $s->description }}</div>
            @endif
          </div>
        @empty
          <div class="text-center text-muted py-4">Bu bölümde ayar yok.</div>
        @endforelse

        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Ayarları Kaydet</button>
      </div></div>
    </form>

    {{-- SMTP test mail butonu --}}
    @if($group === 'smtp')
      <div class="card shadow-sm mt-3"><div class="card-body">
        <h6 class="small text-uppercase text-muted mb-2"><i class="bi bi-send-check"></i> SMTP Test</h6>
        <form method="POST" action="{{ route('admin.settings.test-smtp') }}" class="d-flex gap-2 align-items-end">
          @csrf
          <div class="flex-fill">
            <label class="form-label small">Test maili gönderilecek adres</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control form-control-sm" required>
          </div>
          <button type="submit" class="btn btn-warning btn-sm"><i class="bi bi-send"></i> Test Gönder</button>
        </form>
        <div class="form-text small mt-2">Ayarları önce kaydedin, sonra test edin. Hatalı SMTP ayarı varsa hata mesajı görüntülenir.</div>
      </div></div>
    @endif
  </div>
</div>
@endsection
