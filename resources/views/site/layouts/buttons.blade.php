<a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(__('site.whatsapp_float_msg')) }}"
    class="whatsapp-float" onclick="return!window.open(this.href)" aria-label="{{ __('site.whatsapp_float_aria') }}"
    data-testid="whatsapp-float-btn" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ __('site.whatsapp_float_title') }}">
    <i class="bi bi-whatsapp"></i>
</a>

<!-- Yukarı Çık -->
<button class="back-to-top" id="backToTop" aria-label="{{ __('site.back_to_top_aria') }}" data-testid="back-to-top-btn">
    <i class="bi bi-arrow-up"></i>
</button>