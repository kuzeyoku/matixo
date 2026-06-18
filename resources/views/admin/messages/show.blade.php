@extends('admin.layouts.master')
@section('title', 'Mesaj Detayı')
@section('content')
<div class="row g-3">
  <div class="col-lg-8">
    <div class="card shadow-sm mb-3"><div class="card-body">
      <div class="d-flex justify-content-between mb-3">
        <div>
          <h5 class="mb-1">{{ $item->subject ?: 'Konu yok' }}</h5>
          <div class="small text-muted">{{ $item->name }} &lt;{{ $item->email }}&gt; {{ $item->phone ? '• '.$item->phone : '' }}</div>
        </div>
        <span class="small text-muted">{{ $item->created_at->format('d.m.Y H:i') }}</span>
      </div>
      <hr>
      <p style="white-space:pre-wrap">{{ $item->message }}</p>
      <div class="small text-muted mt-3"><i class="bi bi-globe"></i> {{ $item->ip_address }}</div>
    </div></div>

    @if($item->replied_at)
      <div class="card border-success shadow-sm"><div class="card-body bg-light">
        <h6 class="text-success small"><i class="bi bi-reply-fill"></i> Cevabınız ({{ $item->replied_at->format('d.m.Y H:i') }})</h6>
        <p class="mb-0" style="white-space:pre-wrap">{{ $item->reply_content }}</p>
      </div></div>
    @endif
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm"><div class="card-body">
      <h6 class="h6 mb-3"><i class="bi bi-reply text-primary"></i> Cevapla</h6>
      <form method="POST" action="{{ route('admin.messages.reply', $item->id) }}">
        @csrf
        <div class="mb-2">
          <input type="text" name="subject" value="Re: {{ $item->subject }}" class="form-control form-control-sm" required>
        </div>
        <div class="mb-2">
          <textarea name="body" class="form-control form-control-sm" rows="6" required placeholder="Cevabınızı yazın..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send"></i> Cevap Gönder</button>
      </form>

      <hr>
      <form method="POST" action="{{ route('admin.messages.destroy', $item->id) }}">@csrf @method('DELETE')
        <button class="btn btn-outline-danger w-100" data-confirm="Mesaj silinsin mi?"><i class="bi bi-trash"></i> Sil</button>
      </form>
      <a href="{{ route('admin.messages.index') }}" class="btn btn-light w-100 mt-2">Geri</a>
    </div></div>
  </div>
</div>
@endsection
