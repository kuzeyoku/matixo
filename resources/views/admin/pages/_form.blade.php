@php $isEdit = isset($item); $action = $isEdit ? route('admin.pages.update', $item->id) : route('admin.pages.store'); @endphp
@include('admin.components.form-assets')

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-3">
  @csrf @if($isEdit) @method('PUT') @endif
  <div class="col-lg-8">
    <div class="card shadow-sm"><div class="card-body">
      @include('admin.components.translatable-input', ['field' => 'title', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Başlık', 'required' => true])
      @include('admin.components.translatable-input', ['field' => 'content', 'item' => $item ?? null, 'type' => 'quill', 'label' => 'İçerik (HTML)'])
      <h6 class="small text-muted mt-4 mb-2 text-uppercase">SEO</h6>
      @include('admin.components.translatable-input', ['field' => 'meta_title', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Meta Başlık'])
      @include('admin.components.translatable-input', ['field' => 'meta_description', 'item' => $item ?? null, 'type' => 'textarea', 'label' => 'Meta Açıklama', 'rows' => 2])
    </div></div>
  </div>
  <div class="col-lg-4">
    <div class="card shadow-sm mb-3"><div class="card-body">
      @include('admin.components.dropify', ['name' => 'cover_image', 'value' => $item->cover_image ?? null, 'label' => 'Kapak Görseli'])
      <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" name="show_in_footer" value="1" id="show_in_footer" @checked(old('show_in_footer', $item->show_in_footer ?? false))>
        <label class="form-check-label small" for="show_in_footer">Footer'da göster</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $item->is_active ?? true))>
        <label class="form-check-label small" for="is_active">Aktif</label>
      </div>
    </div></div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-check-lg"></i> Kaydet</button>
      <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">İptal</a>
    </div>
  </div>
</form>
