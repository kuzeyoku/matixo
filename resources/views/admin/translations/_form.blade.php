@php 
$isEdit = isset($item);
$action = $isEdit ? route('admin.translations.update', $item->id) : route('admin.translations.store'); 
@endphp

<form method="POST" action="{{ $action }}" class="card shadow-sm">
  @csrf @if($isEdit) @method('PUT') @endif
  <div class="card-body">
    <div class="row g-4">
      <div class="col-md-6">
        <label class="form-label small fw-semibold">Grup</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-folder2-open"></i></span>
            <input type="text" name="group" class="form-control" value="{{ old('group', $item->group ?? '*') }}" required>
        </div>
        <div class="form-text">JSON benzeri yapı için varsayılan olarak <code>*</code> kullanın.</div>
      </div>
      <div class="col-md-6">
        <label class="form-label small fw-semibold">Anahtar (Key)</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-key"></i></span>
            <input type="text" name="key" class="form-control" value="{{ old('key', $item->key ?? '') }}" placeholder="Örn: Ana Sayfa veya contact_us" required>
        </div>
        <div class="form-text">Kod içinde <code>__('Ana Sayfa')</code> şeklinde çağırdığınız asıl metin.</div>
      </div>

      <div class="col-12 mt-4">
        <h6 class="fw-bold mb-3 border-bottom pb-2">Çeviriler</h6>
        
        <div class="row g-3">
            @foreach(active_languages() as $lang)
            <div class="col-md-6">
                <label class="form-label small fw-semibold">{{ $lang->name }} ({{ strtoupper($lang->code) }})</label>
                <textarea name="text[{{ $lang->code }}]" class="form-control" rows="2" placeholder="{{ $lang->name }} karşılığını girin...">{{ old("text.{$lang->code}", $item->text[$lang->code] ?? '') }}</textarea>
            </div>
            @endforeach
        </div>
      </div>

    </div>
  </div>
  <div class="card-footer bg-light text-end">
    <button type="submit" class="btn btn-primary">
      <i class="bi bi-check-lg"></i> {{ $isEdit ? 'Güncelle' : 'Kaydet' }}
    </button>
  </div>
</form>
