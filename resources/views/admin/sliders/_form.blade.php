@php $isEdit = isset($item);
$action = $isEdit ? route('admin.sliders.update', $item->id) : route('admin.sliders.store'); @endphp
@include('admin.components.form-assets')

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-3">
  @csrf @if($isEdit) @method('PUT') @endif

  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        @include('admin.components.translatable-input', ['field' => 'title', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Başlık', 'required' => true])
        @include('admin.components.translatable-input', ['field' => 'subtitle', 'item' => $item ?? null, 'type' => 'textarea', 'label' => 'Alt Başlık', 'rows' => 2])
        @include('admin.components.translatable-input', ['field' => 'badge_text', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Rozet Metni'])
        @include('admin.components.translatable-input', ['field' => 'button_text', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Buton Metni'])
        <div class="mb-3"><label class="form-label small fw-semibold">Buton Link URL</label>
          <input type="text" name="link_url" value="{{ old('link_url', $item->link_url ?? '') }}" class="form-control"
            placeholder="/kategori/bilim-parklari">
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        @include('admin.components.dropify', ['name' => 'image', 'value' => $item->image ?? null, 'label' => 'Slider Görseli'])

        <div class="row g-2 mt-2">
          <div class="col-6"><label class="form-label small">Başlangıç</label>
            <input type="date" name="starts_at" value="{{ old('starts_at', ($item ?? null)?->starts_at?->format('Y-m-d')) }}"
              class="form-control form-control-sm">
          </div>
          <div class="col-6"><label class="form-label small">Bitiş</label>
            <input type="date" name="ends_at" value="{{ old('ends_at', ($item ?? null)?->ends_at?->format('Y-m-d')) }}"
              class="form-control form-control-sm">
          </div>
        </div>

        <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
            @checked(old('is_active', $item->is_active ?? true))>
          <label class="form-check-label small" for="is_active">Aktif</label>
        </div>
      </div>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-check-lg"></i> Kaydet</button>
      <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">İptal</a>
    </div>
  </div>
</form>