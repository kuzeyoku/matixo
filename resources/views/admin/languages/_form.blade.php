@php $isEdit = isset($item); $action = $isEdit ? route('admin.languages.update', $item->id) : route('admin.languages.store'); @endphp
<form method="POST" action="{{ $action }}" class="row g-3">
  @csrf @if($isEdit) @method('PUT') @endif
  <div class="col-lg-6"><div class="card shadow-sm"><div class="card-body">
    <div class="row g-2">
      <div class="col-md-6 mb-2"><label class="form-label small fw-semibold">Dil Adı <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" class="form-control" required placeholder="Deutsch"></div>
      <div class="col-md-3 mb-2"><label class="form-label small fw-semibold">Kod <span class="text-danger">*</span></label>
        <input type="text" name="code" value="{{ old('code', $item->code ?? '') }}" class="form-control" required maxlength="5" placeholder="de"></div>
      <div class="col-md-3 mb-2"><label class="form-label small fw-semibold">Bayrak (emoji)</label>
        <input type="text" name="flag" value="{{ old('flag', $item->flag ?? '') }}" class="form-control" placeholder="🇩🇪"></div>
    </div>

    <div class="row g-2">
      <div class="col-md-4 mb-2"><label class="form-label small fw-semibold">Yön</label>
        <select name="direction" class="form-select">
          <option value="ltr" @selected(old('direction', $item->direction ?? 'ltr') === 'ltr')>Soldan Sağa (LTR)</option>
          <option value="rtl" @selected(old('direction', $item->direction ?? null) === 'rtl')>Sağdan Sola (RTL)</option>
        </select></div>
      <div class="col-md-4 mb-2"><label class="form-label small fw-semibold">Sıralama</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="form-control"></div>
    </div>

    <div class="form-check mb-2">
      <input type="checkbox" name="is_default" value="1" class="form-check-input" id="is_default" @checked(old('is_default', $item->is_default ?? false))>
      <label class="form-check-label small" for="is_default">Varsayılan dil (Tek aktif olur)</label>
    </div>
    <div class="form-check">
      <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $item->is_active ?? true))>
      <label class="form-check-label small" for="is_active">Aktif</label>
    </div>

    <div class="mt-3"><button class="btn btn-primary"><i class="bi bi-check-lg"></i> Kaydet</button>
    <a href="{{ route('admin.languages.index') }}" class="btn btn-outline-secondary">İptal</a></div>
  </div></div></div>
</form>
