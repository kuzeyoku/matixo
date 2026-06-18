@php $isEdit = isset($item); $action = $isEdit ? route('admin.references.update', $item->id) : route('admin.references.store'); @endphp
@include('admin.components.form-assets')

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-3">
  @csrf @if($isEdit) @method('PUT') @endif
  <div class="col-lg-6">
    <div class="card shadow-sm"><div class="card-body">
      <div class="mb-3"><label class="form-label small fw-semibold">Ad <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" class="form-control" required></div>
      <div class="mb-3"><label class="form-label small fw-semibold">Web Sitesi</label>
        <input type="url" name="link_url" value="{{ old('link_url', $item->link_url ?? '') }}" class="form-control" placeholder="https://..."></div>
      @include('admin.components.dropify', ['name' => 'logo', 'value' => $item->logo ?? null, 'label' => 'Logo (şeffaf PNG önerilir)'])
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $item->is_active ?? true))>
        <label class="form-check-label small" for="is_active">Aktif</label>
      </div>
    </div></div>
  </div>
  <div class="col-lg-6">
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Kaydet</button>
      <a href="{{ route('admin.references.index') }}" class="btn btn-outline-secondary">İptal</a>
    </div>
  </div>
</form>
