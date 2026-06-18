{{--
  Ortak listele/filtre + boş durum + sayfalama wrapper.
  @prop $items = paginator
--}}
@props(['items', 'searchPlaceholder' => 'Ara...', 'showActiveFilter' => true])

<div class="card shadow-sm">
  <div class="card-body border-bottom">
    <form method="GET" class="row g-2 align-items-center">
      <div class="col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
          <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ $searchPlaceholder }}">
        </div>
      </div>
      @if($showActiveFilter)
        <div class="col-md-3">
          <select name="is_active" class="form-select form-select-sm">
            <option value="">Tüm durumlar</option>
            <option value="1" @selected(request('is_active') === '1')>Sadece aktif</option>
            <option value="0" @selected(request('is_active') === '0')>Sadece pasif</option>
          </select>
        </div>
      @endif
      <div class="col-md-2">
        <button class="btn btn-sm btn-primary w-100"><i class="bi bi-funnel"></i> Filtrele</button>
      </div>
      <div class="col-md-2">
        <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary w-100">Sıfırla</a>
      </div>
    </form>
  </div>

  {{ $slot }}

  @if($items->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
      <span class="small text-muted">
        Toplam <strong>{{ $items->total() }}</strong> kayıt. Sayfa {{ $items->currentPage() }} / {{ $items->lastPage() }}.
      </span>
      <div>{{ $items->links() }}</div>
    </div>
  @endif
</div>
