@extends('admin.layouts.master')
@section('title', 'Yeni Çeviri Ekle')
@section('page_title', 'Yeni Çeviri Ekle')
@section('page_action')
  <a href="{{ route('admin.translations.index') }}" class="btn btn-sm btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Geri Dön
  </a>
@endsection

@section('content')
  @include('admin.translations._form')
@endsection