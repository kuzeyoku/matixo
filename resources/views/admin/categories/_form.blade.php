@php
  $isEdit = isset($item);
  $action = $isEdit ? route('admin.categories.update', $item->id) : route('admin.categories.store');
@endphp
@include('admin.components.form-assets')

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="row g-3">
  @csrf @if($isEdit) @method('PUT') @endif

  <div class="col-lg-8">
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <h5 class="h6 mb-3"><i class="bi bi-translate text-primary me-1"></i>Çevirilebilir Alanlar</h5>

        @include('admin.components.translatable-input', [
          'field' => 'name', 'item' => $item ?? null, 'type' => 'text',
          'label' => 'Kategori Adı', 'required' => true,
        ])

        @include('admin.components.translatable-input', [
          'field' => 'description', 'item' => $item ?? null, 'type' => 'textarea',
          'label' => 'Açıklama', 'rows' => 3,
        ])

        <h6 class="small text-muted mt-4 mb-2 text-uppercase">SEO</h6>
        @include('admin.components.translatable-input', [
          'field' => 'meta_title', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Meta Başlık',
        ])
        @include('admin.components.translatable-input', [
          'field' => 'meta_description', 'item' => $item ?? null, 'type' => 'textarea', 'label' => 'Meta Açıklama', 'rows' => 2,
        ])
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <h5 class="h6 mb-3"><i class="bi bi-gear text-primary me-1"></i>Yapılandırma</h5>

        <div class="mb-3">
          <label class="form-label small fw-semibold">Üst Kategori</label>
          <select name="parent_id" class="form-select">
            <option value="">— Yok (kök kategori) —</option>
            @foreach($parents as $p)
              <option value="{{ $p->id }}" @selected(old('parent_id', $item->parent_id ?? null) == $p->id)>
                {{ $p->getTranslation('name', default_locale()) }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">İkon (Bootstrap Icons class)</label>
          <input type="text" name="icon" value="{{ old('icon', $item->icon ?? '') }}" class="form-control" placeholder="bi-tree">
          <div class="form-text small">Örn: <code>bi-tree</code>, <code>bi-puzzle</code>. <a href="https://icons.getbootstrap.com" target="_blank">Tüm ikonlar</a></div>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">Bento Boyut (Anasayfa)</label>
          <select name="bento_size" class="form-select">
            @foreach(['lg' => 'Büyük', 'md' => 'Orta', 'sm' => 'Küçük'] as $k => $v)
              <option value="{{ $k }}" @selected(old('bento_size', $item->bento_size ?? 'md') === $k)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label small fw-semibold">Sıralama</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="form-control">
        </div>

        @include('admin.components.dropify', [
          'name' => 'image', 'value' => $item->image ?? null, 'label' => 'Görsel',
          'help' => 'Önerilen 800×600 px, jpg/png/webp.',
        ])

        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" name="show_on_home" value="1" id="show_on_home" @checked(old('show_on_home', $item->show_on_home ?? false))>
          <label class="form-check-label small" for="show_on_home">Anasayfada göster (Bento)</label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $item->is_active ?? true))>
          <label class="form-check-label small" for="is_active">Aktif</label>
        </div>
      </div>
    </div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-check-lg"></i> Kaydet</button>
      <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">İptal</a>
    </div>
  </div>
</form>
