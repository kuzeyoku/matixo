@php
  $isEdit = isset($item);
  $action = $isEdit ? route('admin.products.update', $item->id) : route('admin.products.store');
@endphp
@include('admin.components.form-assets')

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
  @csrf @if($isEdit) @method('PUT') @endif

  <ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item"><button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-main"><i class="bi bi-info-circle me-1"></i>Genel</button></li>
    <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-gallery"><i class="bi bi-images me-1"></i>Galeri</button></li>
    <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-features"><i class="bi bi-list-check me-1"></i>Özellikler</button></li>
    <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-specs"><i class="bi bi-table me-1"></i>Teknik Tablo</button></li>
    <li class="nav-item"><button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-seo"><i class="bi bi-search me-1"></i>SEO</button></li>
  </ul>

  <div class="tab-content">
    {{-- ── GENEL ─────────────────────────────────────── --}}
    <div class="tab-pane fade show active" id="tab-main">
      <div class="row g-3">
        <div class="col-lg-8">
          <div class="card shadow-sm mb-3"><div class="card-body">
            @include('admin.components.translatable-input', ['field' => 'title', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Ürün Başlığı', 'required' => true])
            @include('admin.components.translatable-input', ['field' => 'short_description', 'item' => $item ?? null, 'type' => 'textarea', 'label' => 'Kısa Açıklama', 'rows' => 3])
            @include('admin.components.translatable-input', ['field' => 'description', 'item' => $item ?? null, 'type' => 'quill', 'label' => 'Detaylı Açıklama (HTML)'])
          </div></div>

          <div class="card shadow-sm"><div class="card-body">
            <h5 class="h6 mb-3">Ürün Bilgileri</h5>
            <div class="row g-2">
              <div class="col-sm-6"><label class="form-label small">Ürün Kodu</label>
                <input type="text" name="code" value="{{ old('code', $item->code ?? '') }}" class="form-control" placeholder="MTX-XXX-001"></div>
              <div class="col-sm-6"><label class="form-label small">Malzeme</label>
                <input type="text" name="material" value="{{ old('material', $item->material ?? '') }}" class="form-control"></div>
              <div class="col-sm-6"><label class="form-label small">Yaş Grubu</label>
                <input type="text" name="age_range" value="{{ old('age_range', $item->age_range ?? '') }}" class="form-control" placeholder="6-14 Yaş"></div>
              <div class="col-sm-6"><label class="form-label small">Sertifikasyon</label>
                <input type="text" name="certification" value="{{ old('certification', $item->certification ?? '') }}" class="form-control" placeholder="CE Sertifikalı"></div>
              <div class="col-sm-6"><label class="form-label small">Üretim Süresi</label>
                <input type="text" name="production_time" value="{{ old('production_time', $item->production_time ?? '') }}" class="form-control" placeholder="15-20 İş Günü"></div>
              <div class="col-sm-6"><label class="form-label small">Garanti</label>
                <input type="text" name="warranty" value="{{ old('warranty', $item->warranty ?? '') }}" class="form-control" placeholder="2 yıl"></div>
            </div>
          </div></div>
        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm mb-3"><div class="card-body">
            <h5 class="h6 mb-3">Yapılandırma</h5>
            <div class="mb-3"><label class="form-label small">Kategori <span class="text-danger">*</span></label>
              <select name="category_id" class="form-select" required>
                <option value="">— Seçin —</option>
                @foreach($categories as $c)
                  <option value="{{ $c->id }}" @selected(old('category_id', $item->category_id ?? null) == $c->id)>{{ $c->getTranslation('name', default_locale()) }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3"><label class="form-label small">Fiyat (TRY)</label>
              <input type="number" step="0.01" min="0" name="price" value="{{ old('price', isset($item) && $item->price ? number_format($item->price, 2, '.', '') : '') }}" class="form-control" placeholder="0.00">
            </div>
            <div class="mb-3"><label class="form-label small">Etiket</label>
              <select name="badge" class="form-select">
                @foreach($badgeOptions as $k => $v)<option value="{{ $k }}" @selected(old('badge', $item->badge ?? '') === $k)>{{ $v }}</option>@endforeach
              </select>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $item->is_featured ?? false))>
              <label class="form-check-label small" for="is_featured"><i class="bi bi-star-fill text-warning"></i> Öne çıkan ürün</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $item->is_active ?? true))>
              <label class="form-check-label small" for="is_active">Aktif</label>
            </div>
          </div></div>

          <div class="card shadow-sm"><div class="card-body">
            @include('admin.components.dropify', ['name' => 'cover_image', 'value' => $item->cover_image ?? null, 'label' => 'Kapak Görseli'])
          </div></div>
        </div>
      </div>
    </div>

    {{-- ── GALERİ ────────────────────────────────────── --}}
    <div class="tab-pane fade" id="tab-gallery">
      <div class="card shadow-sm"><div class="card-body">
        <h5 class="h6 mb-3">Ürün Galerisi</h5>

        @if($isEdit && $item->images->count())
          <div class="row g-2 mb-3" data-sortable>
            @foreach($item->images as $img)
              <div class="col-sm-4 col-md-3" data-id="{{ $img->id }}">
                <div class="repeater-row">
                  <input type="hidden" name="gallery_existing[{{ $loop->index }}][id]" value="{{ $img->id }}">
                  <img src="{{ asset('storage/'.$img->image_path) }}" class="w-100 rounded mb-2" style="aspect-ratio:4/3;object-fit:cover">
                  <input type="text" name="gallery_existing[{{ $loop->index }}][alt_text]" value="{{ $img->alt_text }}" class="form-control form-control-sm mb-2" placeholder="Alt text">
                  <div class="form-check small">
                    <input class="form-check-input" type="checkbox" name="gallery_remove[]" value="{{ $img->id }}" id="rem-{{ $img->id }}">
                    <label class="form-check-label text-danger" for="rem-{{ $img->id }}"><i class="bi bi-trash"></i> Bu görseli kaldır</label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        <h6 class="small text-muted mt-4">Yeni Görseller Ekle</h6>
        <div id="newImagesWrap"></div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addNewImage()"><i class="bi bi-plus-lg"></i> Yeni görsel</button>

        <script>
          let imgIdx = 0;
          function addNewImage() {
            const wrap = document.getElementById('newImagesWrap');
            const row = document.createElement('div');
            row.className = 'repeater-row d-flex gap-2 align-items-center mt-2';
            row.innerHTML =
              '<input type="file" name="gallery_files[]" class="form-control form-control-sm" accept="image/*">' +
              '<input type="text" name="gallery_alt[]" placeholder="Alt text" class="form-control form-control-sm">' +
              '<button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>';
            wrap.appendChild(row);
            imgIdx++;
          }
        </script>
      </div></div>
    </div>

    {{-- ── ÖZELLİKLER ────────────────────────────────── --}}
    <div class="tab-pane fade" id="tab-features">
      <div class="card shadow-sm"><div class="card-body">
        <h5 class="h6 mb-3">Madde Madde Özellikler (Ürün sağ kolonu)</h5>
        <div id="featuresWrap" data-sortable>
          @foreach(old('features', $isEdit ? $item->features->map(fn($f) => ['feature_text' => $f->feature_text])->toArray() : []) as $i => $f)
            <div class="repeater-row d-flex gap-2 align-items-center" data-id="{{ $i }}">
              <i class="bi bi-grip-vertical sortable-handle"></i>
              @foreach(active_languages() as $lang)
                <input type="text" name="features[{{ $i }}][feature_text][{{ $lang->code }}]"
                       value="{{ is_array($f['feature_text'] ?? null) ? ($f['feature_text'][$lang->code] ?? '') : '' }}"
                       class="form-control form-control-sm" placeholder="{{ strtoupper($lang->code) }}">
              @endforeach
              <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
            </div>
          @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addFeatureBtn"><i class="bi bi-plus-lg"></i> Yeni özellik</button>

        <script>
          (function () {
            const wrap = document.getElementById('featuresWrap');
            const langs = @json(active_languages()->pluck('code'));
            let idx = wrap.querySelectorAll('.repeater-row').length;
            document.getElementById('addFeatureBtn').onclick = function () {
              const row = document.createElement('div');
              row.className = 'repeater-row d-flex gap-2 align-items-center';
              row.dataset.id = idx;
              let inputs = '<i class="bi bi-grip-vertical sortable-handle"></i>';
              langs.forEach(c => inputs += `<input type="text" name="features[${idx}][feature_text][${c}]" class="form-control form-control-sm" placeholder="${c.toUpperCase()}">`);
              inputs += '<button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>';
              row.innerHTML = inputs;
              wrap.appendChild(row);
              idx++;
            };
          })();
        </script>
      </div></div>
    </div>

    {{-- ── TEKNİK TABLO ──────────────────────────────── --}}
    <div class="tab-pane fade" id="tab-specs">
      <div class="card shadow-sm"><div class="card-body">
        <h5 class="h6 mb-3">Teknik Özellikler (Anahtar / Değer)</h5>
        <div id="specsWrap">
          @foreach(old('specs', $isEdit ? $item->specs->map(fn($s) => ['spec_key' => $s->spec_key, 'spec_value' => $s->spec_value])->toArray() : []) as $i => $s)
            <div class="repeater-row" data-id="{{ $i }}">
              <div class="row g-2">
                @foreach(active_languages() as $lang)
                  <div class="col-md-6">
                    <small class="text-muted">{{ strtoupper($lang->code) }}</small>
                    <div class="d-flex gap-2">
                      <input type="text" name="specs[{{ $i }}][spec_key][{{ $lang->code }}]"
                             value="{{ is_array($s['spec_key'] ?? null) ? ($s['spec_key'][$lang->code] ?? '') : '' }}"
                             class="form-control form-control-sm" placeholder="Anahtar">
                      <input type="text" name="specs[{{ $i }}][spec_value][{{ $lang->code }}]"
                             value="{{ is_array($s['spec_value'] ?? null) ? ($s['spec_value'][$lang->code] ?? '') : '' }}"
                             class="form-control form-control-sm" placeholder="Değer">
                    </div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="btn btn-sm btn-link text-danger p-0 mt-2" onclick="this.closest('.repeater-row').remove()"><i class="bi bi-x"></i> Bu satırı kaldır</button>
            </div>
          @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addSpecBtn"><i class="bi bi-plus-lg"></i> Yeni satır</button>

        <script>
          (function () {
            const wrap = document.getElementById('specsWrap');
            const langs = @json(active_languages()->pluck('code'));
            let idx = wrap.querySelectorAll('.repeater-row').length;
            document.getElementById('addSpecBtn').onclick = function () {
              const row = document.createElement('div');
              row.className = 'repeater-row';
              row.dataset.id = idx;
              let html = '<div class="row g-2">';
              langs.forEach(c => {
                html += `<div class="col-md-6"><small class="text-muted">${c.toUpperCase()}</small><div class="d-flex gap-2"><input type="text" name="specs[${idx}][spec_key][${c}]" class="form-control form-control-sm" placeholder="Anahtar"><input type="text" name="specs[${idx}][spec_value][${c}]" class="form-control form-control-sm" placeholder="Değer"></div></div>`;
              });
              html += '</div><button type="button" class="btn btn-sm btn-link text-danger p-0 mt-2" onclick="this.closest(\'.repeater-row\').remove()"><i class="bi bi-x"></i> Bu satırı kaldır</button>';
              row.innerHTML = html;
              wrap.appendChild(row);
              idx++;
            };
          })();
        </script>
      </div></div>
    </div>

    {{-- ── SEO ──────────────────────────────────────── --}}
    <div class="tab-pane fade" id="tab-seo">
      <div class="card shadow-sm"><div class="card-body">
        @include('admin.components.translatable-input', ['field' => 'meta_title', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Meta Başlık'])
        @include('admin.components.translatable-input', ['field' => 'meta_description', 'item' => $item ?? null, 'type' => 'textarea', 'label' => 'Meta Açıklama', 'rows' => 2])
        @include('admin.components.dropify', ['name' => 'og_image', 'value' => $item->og_image ?? null, 'label' => 'Open Graph Görseli (sosyal medya paylaşımı)'])
      </div></div>
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Kaydet</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">İptal</a>
  </div>
</form>
