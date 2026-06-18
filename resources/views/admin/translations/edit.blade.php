@extends('admin.layouts.master')
@section('title', 'Çeviriyi Düzenle')
@section('page_title', 'Çeviriyi Düzenle')
@section('page_action')
  <a href="{{ route('admin.translations.index') }}" class="btn btn-sm btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Geri Dön
  </a>
@endsection

@section('content')
  @include('admin.translations._form', ['item' => $translation])
@endsection