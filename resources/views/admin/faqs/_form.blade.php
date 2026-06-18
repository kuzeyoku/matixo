@php $isEdit = isset($item);
$action = $isEdit ? route('admin.faqs.update', $item->id) : route('admin.faqs.store'); @endphp
@include('admin.components.form-assets')

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-3">
  @csrf @if($isEdit) @method('PUT') @endif

  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        @include('admin.components.translatable-input', ['field' => 'question', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Soru', 'required' => true])
        @include('admin.components.translatable-input', ['field' => 'answer', 'item' => $item ?? null, 'type' => 'textarea', 'label' => 'Cevap', 'rows' => 4, 'required' => true])
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        
        <div class="mb-3">
          <label class="form-label small fw-semibold">İlişkili Ürün</label>
          <select name="product_id" class="form-select select2">
            <option value="">— Genel SSS (Ürüne Bağlı Değil) —</option>
            @foreach($products as $prod)
              <option value="{{ $prod->id }}" @selected(old('product_id', $item->product_id ?? '') == $prod->id)>
                {{ $prod->getTranslation('title', default_locale()) }}
              </option>
            @endforeach
          </select>
          <div class="form-text small mt-1">Bu sorunun sadece belirli bir ürün sayfasında görünmesini istiyorsanız ürünü seçin. Boş bırakırsanız genel SSS (İletişim/Ana SSS) olarak kabul edilir.</div>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">Sıralama</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="form-control form-control-sm">
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
      <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">İptal</a>
    </div>
  </div>
</form>
