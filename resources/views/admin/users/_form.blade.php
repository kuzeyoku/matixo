@php $isEdit = isset($item); $action = $isEdit ? route('admin.users.update', $item->id) : route('admin.users.store'); @endphp
<form method="POST" action="{{ $action }}" class="row g-3">
  @csrf @if($isEdit) @method('PUT') @endif
  <div class="col-lg-6"><div class="card shadow-sm"><div class="card-body">
    <div class="mb-3"><label class="form-label small fw-semibold">Ad Soyad <span class="text-danger">*</span></label>
      <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" class="form-control" required></div>
    <div class="mb-3"><label class="form-label small fw-semibold">E-posta <span class="text-danger">*</span></label>
      <input type="email" name="email" value="{{ old('email', $item->email ?? '') }}" class="form-control" required></div>
    <div class="mb-3"><label class="form-label small fw-semibold">Şifre {!! $isEdit ? '' : '<span class="text-danger">*</span>' !!}</label>
      <input type="password" name="password" class="form-control" {{ $isEdit ? '' : 'required' }} minlength="10" placeholder="{{ $isEdit ? 'Boş bırakırsanız mevcut şifre korunur' : 'En az 10 karakter' }}">
      <div class="form-text small">Min 10 karakter. Karışık (büyük+küçük+rakam+sembol) öneriyoruz.</div></div>
    <input type="hidden" name="role" value="admin">

    <div class="form-check">
      <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $item->is_active ?? true))>
      <label class="form-check-label small" for="is_active">Aktif</label>
    </div>

    <div class="mt-3"><button class="btn btn-primary"><i class="bi bi-check-lg"></i> Kaydet</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">İptal</a></div>
  </div></div></div>
</form>
