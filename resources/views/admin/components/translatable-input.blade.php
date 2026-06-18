{{--
  Çoklu dil sekmeli form helper.
  Kullanım:
    <x-translatable-tabs :item="$item" :field="'name'" :rules="['required']" />
  Veya manuel:
    @include('admin.components.translatable-input', ['field' => 'name', 'item' => $item, 'type' => 'text'])
--}}
@props(['field', 'item' => null, 'type' => 'text', 'label' => null, 'required' => false, 'rows' => 3, 'placeholder' => ''])

@php
  $langs = active_languages();
  $tabId = 'tab-' . $field . '-' . uniqid();
@endphp

<div class="translatable-field mb-3">
  @if($label)
    <label class="form-label small fw-semibold">
      {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>
  @endif

  <ul class="nav nav-tabs nav-tabs-translatable" role="tablist">
    @foreach($langs as $i => $lang)
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ $i === 0 ? 'active' : '' }} {{ $errors->has($field.'.'.$lang->code) ? 'text-danger' : '' }}"
                type="button" data-bs-toggle="tab" data-bs-target="#{{ $tabId }}-{{ $lang->code }}">
          <span class="me-1">{{ $lang->flag }}</span>{{ strtoupper($lang->code) }}
          @if($errors->has($field.'.'.$lang->code))<i class="bi bi-exclamation-circle small"></i>@endif
        </button>
      </li>
    @endforeach
  </ul>

  <div class="tab-content tab-content-translatable">
    @foreach($langs as $i => $lang)
      @php
        $value = old(
          $field . '.' . $lang->code,
          $item ? ($item->getTranslation($field, $lang->code, false) ?: '') : ''
        );
        $name = "{$field}[{$lang->code}]";
        $isRequired = $required && $lang->is_default;
      @endphp

      <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="{{ $tabId }}-{{ $lang->code }}">
        @if($type === 'textarea')
          <textarea name="{{ $name }}" class="form-control @error($field.'.'.$lang->code) is-invalid @enderror"
                    rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $isRequired ? 'required' : '' }}>{{ $value }}</textarea>
        @elseif($type === 'quill')
          <textarea name="{{ $name }}" data-quill data-toolbar="full" class="form-control"
                    placeholder="{{ $placeholder }}">{{ $value }}</textarea>
        @elseif($type === 'quill-simple')
          <textarea name="{{ $name }}" data-quill data-toolbar="simple" class="form-control"
                    placeholder="{{ $placeholder }}">{{ $value }}</textarea>
        @else
          <input type="text" name="{{ $name }}" value="{{ $value }}"
                 class="form-control @error($field.'.'.$lang->code) is-invalid @enderror"
                 placeholder="{{ $placeholder }}" {{ $isRequired ? 'required' : '' }}>
        @endif

        @error($field.'.'.$lang->code)
          <div class="invalid-feedback d-block small">{{ $message }}</div>
        @enderror
      </div>
    @endforeach
  </div>
</div>
