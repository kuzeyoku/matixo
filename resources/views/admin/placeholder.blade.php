@extends('admin.layouts.master')

@section('title', $title ?? 'Sayfa')

@section('content')
  <div class="card shadow-sm">
    <div class="card-body text-center py-5">
      <i class="bi bi-tools text-muted" style="font-size:3rem"></i>
      <h2 class="h4 mt-3">{{ $title ?? 'Bu modül' }}</h2>
      <p class="text-muted mb-0">Bu modül <strong>Faz 2</strong> kapsamında inşa edilecektir.</p>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary mt-3">
        <i class="bi bi-arrow-left me-1"></i>Dashboard'a Dön
      </a>
    </div>
  </div>
@endsection
