@extends('admin.layouts.master')
@section('title', 'Kampanya Modal')
@include('admin.components.form-assets')

@section('content')
<form method="POST" action="{{ route('admin.campaign.update') }}" enctype="multipart/form-data" class="row g-3">
  @csrf @method('PUT')

  <div class="col-lg-8">
    <div class="card shadow-sm"><div class="card-body">
      @include('admin.components.translatable-input', ['field' => 'title', 'item' => $item, 'type' => 'text', 'label' => 'Başlık', 'required' => true])
      @include('admin.components.translatable-input', ['field' => 'highlight_word', 'item' => $item, 'type' => 'text', 'label' => 'Vurgulu Kelime (turkuaz renkte)'])
      @include('admin.components.translatable-input', ['field' => 'description', 'item' => $item, 'type' => 'textarea', 'label' => 'Açıklama', 'rows' => 3])

      <div class="mb-3">
        <label class="form-label small fw-semibold">Maddeler (her dilde tek satır)</label>
        <div id="perksWrap">
          @php $perks = old('perks', $item->perks ?? []); @endphp
          @foreach($perks as $i => $perk)
            <div class="repeater-row" data-id="{{ $i }}">
              <div class="row g-2 align-items-center">
                @foreach(active_languages() as $lang)
                  <div class="col">
                    <small class="text-muted">{{ strtoupper($lang->code) }}</small>
                    <input type="text" name="perks[{{ $i }}][text][{{ $lang->code }}]"
                           value="{{ is_array($perk['text'] ?? null) ? ($perk['text'][$lang->code] ?? '') : '' }}"
                           class="form-control form-control-sm" placeholder="Madde metni">
                  </div>
                @endforeach
                <div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.repeater-row').remove()"><i class="bi bi-x"></i></button></div>
              </div>
            </div>
          @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addPerkBtn"><i class="bi bi-plus-lg"></i> Madde ekle</button>
      </div>

      @include('admin.components.translatable-input', ['field' => 'button_text', 'item' => $item, 'type' => 'text', 'label' => 'Buton Metni'])

      <div class="mb-3"><label class="form-label small fw-semibold">Buton URL (genellikle WhatsApp linki)</label>
        <input type="text" name="button_url" value="{{ old('button_url', $item->button_url ?? '') }}" class="form-control" placeholder="https://wa.me/905555555555?text=..."></div>
    </div></div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm mb-3"><div class="card-body">
      <h5 class="h6 mb-3">Davranış</h5>
      <div class="row g-2 mb-3">
        <div class="col-6"><label class="form-label small">Gösterim Gecikmesi (sn)</label>
          <input type="number" name="show_delay_seconds" value="{{ old('show_delay_seconds', $item->show_delay_seconds ?? 2) }}" class="form-control" min="0" max="60"></div>
        <div class="col-6"><label class="form-label small">"Bir daha gösterme" Süresi (gün)</label>
          <input type="number" name="hide_days" value="{{ old('hide_days', $item->hide_days ?? 3) }}" class="form-control" min="0" max="365"></div>
      </div>
      <div class="mb-3"><label class="form-label small">Geçerlilik Tarihi</label>
        <input type="date" name="valid_until" value="{{ old('valid_until', $item->valid_until?->format('Y-m-d')) }}" class="form-control"></div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $item->is_active ?? false))>
        <label class="form-check-label small fw-semibold" for="is_active">Modal aktif (anasayfada açılsın)</label>
      </div>
    </div></div>

    <div class="card shadow-sm mb-3"><div class="card-body">
      @include('admin.components.dropify', ['name' => 'image', 'value' => $item->image ?? null, 'label' => 'Modal Görseli'])
    </div></div>

    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> Kampanyayı Kaydet</button>
  </div>
</form>

<script>
(function () {
  const wrap = document.getElementById('perksWrap');
  const langs = @json(active_languages()->pluck('code'));
  let idx = wrap.querySelectorAll('.repeater-row').length;
  document.getElementById('addPerkBtn').onclick = function () {
    const row = document.createElement('div');
    row.className = 'repeater-row';
    let html = '<div class="row g-2 align-items-center">';
    langs.forEach(c => html += `<div class="col"><small class="text-muted">${c.toUpperCase()}</small><input type="text" name="perks[${idx}][text][${c}]" class="form-control form-control-sm" placeholder="Madde metni"></div>`);
    html += '<div class="col-auto"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest(\'.repeater-row\').remove()"><i class="bi bi-x"></i></button></div></div>';
    row.innerHTML = html;
    wrap.appendChild(row);
    idx++;
  };
})();
</script>
@endsection
