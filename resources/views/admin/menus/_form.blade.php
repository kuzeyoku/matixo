@php $isEdit = isset($item); $action = $isEdit ? route('admin.menus.update', $item->id) : route('admin.menus.store'); @endphp
@include('admin.components.form-assets')

<form method="POST" action="{{ $action }}" class="row g-3">
  @csrf @if($isEdit) @method('PUT') @endif

  <div class="col-lg-8">
    <div class="card shadow-sm"><div class="card-body">
      {{-- Başlık (çevirilebilir) --}}
      @include('admin.components.translatable-input', ['field' => 'title', 'item' => $item ?? null, 'type' => 'text', 'label' => 'Menü Başlığı', 'required' => true])

      {{-- Link Türü --}}
      <div class="mb-3">
        <label class="form-label">Link Türü</label>
        <select name="link_type" id="link_type" class="form-select @error('link_type') is-invalid @enderror">
          <option value="url"      @selected(old('link_type', $item->link_type ?? 'url') === 'url')>Manuel URL</option>
          <option value="route"    @selected(old('link_type', $item->link_type ?? '') === 'route')>Laravel Route</option>
          <option value="page"     @selected(old('link_type', $item->link_type ?? '') === 'page')>Sayfa Seç</option>
          <option value="category" @selected(old('link_type', $item->link_type ?? '') === 'category')>Kategori Seç</option>
        </select>
        @error('link_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- URL Input (link_type = url veya route) --}}
      <div class="mb-3" id="urlGroup">
        <label class="form-label">URL / Route</label>
        <input type="text" name="url" class="form-control @error('url') is-invalid @enderror"
               value="{{ old('url', $item->url ?? '') }}" placeholder="https://... veya route.name">
        @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">Manuel URL veya Laravel route adı girin.</div>
      </div>

      {{-- Sayfa Seçimi (link_type = page) --}}
      <div class="mb-3 d-none" id="pageGroup">
        <label class="form-label">Sayfa</label>
        <select name="page_slug" id="page_slug" class="form-select">
          <option value="">— Sayfa seçin —</option>
          @foreach($pages as $page)
            <option value="{{ $page->slug }}" @selected(old('page_slug', ($item->link_type ?? '') === 'page' ? ($item->url ?? '') : '') === $page->slug)>
              {{ $page->getTranslation('title', default_locale()) }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Kategori Seçimi (link_type = category) --}}
      <div class="mb-3 d-none" id="categoryGroup">
        <label class="form-label">Kategori</label>
        <select name="category_slug" id="category_slug" class="form-select">
          <option value="">— Kategori seçin —</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->slug }}" @selected(old('category_slug', ($item->link_type ?? '') === 'category' ? ($item->url ?? '') : '') === $cat->slug)>
              {{ $cat->getTranslation('name', default_locale()) }}
            </option>
          @endforeach
        </select>
      </div>
    </div></div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm mb-3"><div class="card-body">
      {{-- Üst Menü --}}
      <div class="mb-3">
        <label class="form-label">Üst Menü</label>
        <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
          <option value="0">— Ana Menü (Root) —</option>
          @foreach($parents as $p)
            <option value="{{ $p->id }}" @selected(old('parent_id', $item->parent_id ?? 0) == $p->id)>
              {{ $p->getTranslation('title', default_locale()) }}
            </option>
          @endforeach
        </select>
        @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- İkon --}}
      <div class="mb-3">
        <label class="form-label">İkon <small class="text-muted">(Bootstrap Icons)</small></label>
        <div class="input-group">
          <span class="input-group-text" id="iconPreview"><i class="{{ old('icon', $item->icon ?? 'bi bi-link-45deg') }}"></i></span>
          <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                 value="{{ old('icon', $item->icon ?? '') }}" placeholder="bi bi-house" id="iconInput">
        </div>
        @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
        <div class="form-text">Örn: <code>bi bi-house</code>, <code>bi bi-folder</code></div>
      </div>

      {{-- Target --}}
      <div class="mb-3">
        <label class="form-label">Açılış Şekli</label>
        <select name="link_target" class="form-select">
          <option value="_self" @selected(old('link_target', $item->link_target ?? '_self') === '_self')>Aynı Sekme (_self)</option>
          <option value="_blank" @selected(old('link_target', $item->link_target ?? '_self') === '_blank')>Yeni Sekme (_blank)</option>
        </select>
      </div>

      {{-- Sıra --}}
      <div class="mb-3">
        <label class="form-label">Sıra</label>
        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}" min="0">
      </div>

      {{-- Aktif --}}
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $item->is_active ?? true))>
        <label class="form-check-label small" for="is_active">Aktif</label>
      </div>
    </div></div>

    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-check-lg"></i> Kaydet</button>
      <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">İptal</a>
    </div>
  </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const linkType   = document.getElementById('link_type');
    const urlGroup   = document.getElementById('urlGroup');
    const pageGroup  = document.getElementById('pageGroup');
    const catGroup   = document.getElementById('categoryGroup');
    const urlInput   = document.querySelector('input[name="url"]');
    const pageSel    = document.getElementById('page_slug');
    const catSel     = document.getElementById('category_slug');
    const iconInput  = document.getElementById('iconInput');
    const iconPrev   = document.getElementById('iconPreview');

    function toggleGroups() {
        const v = linkType.value;
        urlGroup.classList.toggle('d-none', v === 'page' || v === 'category');
        pageGroup.classList.toggle('d-none', v !== 'page');
        catGroup.classList.toggle('d-none', v !== 'category');
    }

    linkType.addEventListener('change', toggleGroups);
    toggleGroups();

    // Sayfa / Kategori seçiminde url alanını otomatik doldur
    pageSel.addEventListener('change', () => { urlInput.value = pageSel.value; });
    catSel.addEventListener('change',  () => { urlInput.value = catSel.value; });

    // İkon önizleme
    iconInput.addEventListener('input', function() {
        iconPrev.innerHTML = '<i class="' + (this.value || 'bi bi-link-45deg') + '"></i>';
    });
});
</script>
@endpush
