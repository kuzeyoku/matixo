@props(['name', 'value' => null, 'label' => null, 'required' => false, 'help' => null, 'max' => '5M'])

<div class="mb-3">
  @if($label)
    <label class="form-label small fw-semibold">
      {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>
  @endif

  <input type="file" name="{{ $name }}" class="dropify @error($name) is-invalid @enderror"
         data-default-file="{{ $value ? asset('storage/'.$value) : '' }}"
         data-allowed-file-extensions="jpg jpeg png webp"
         data-max-file-size="{{ $max }}"
         data-show-remove="true"
         data-messages-default="Görseli sürükleyip bırakın ya da tıklayın"
         data-messages-replace="Değiştirmek için sürükleyin / tıklayın"
         data-messages-remove="Kaldır"
         data-messages-error="Bir hata oluştu" />

  @if($help)<div class="form-text small">{{ $help }}</div>@endif

  @if($value)
    <div class="form-check mt-2 small">
      <input class="form-check-input" type="checkbox" name="{{ $name }}_remove" value="1" id="{{ $name }}_remove">
      <label class="form-check-label text-danger" for="{{ $name }}_remove">
        <i class="bi bi-trash"></i> Mevcut görseli kaldır
      </label>
    </div>
  @endif

  @error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</div>
