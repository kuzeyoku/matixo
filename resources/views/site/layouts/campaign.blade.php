<section class="campaign-section" id="kampanya" data-testid="campaign-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal-left">
                <span class="campaign-badge"><i class="bi bi-lightning-fill me-1"></i>{{ __('site.campaign_badge') }}</span>
                <h2>{{ __('site.campaign_title') }}</h2>
                <p>{{ __('site.campaign_desc') }}</p>
                <ul class="list-unstyled mt-3 mb-4">
                    <li class="d-flex gap-2 mb-2" style="color:rgba(255,255,255,0.85);font-size:0.95rem">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i> {{ __('site.campaign_perk_1') }}
                    </li>
                    <li class="d-flex gap-2 mb-2" style="color:rgba(255,255,255,0.85);font-size:0.95rem">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i> {{ __('site.campaign_perk_2') }}
                    </li>
                    <li class="d-flex gap-2 mb-2" style="color:rgba(255,255,255,0.85);font-size:0.95rem">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i> {{ __('site.campaign_perk_3') }}
                    </li>
                    <li class="d-flex gap-2" style="color:rgba(255,255,255,0.85);font-size:0.95rem">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i> {{ __('site.campaign_perk_4') }}
                    </li>
                </ul>
                <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(__('site.campaign_cta')) }}"
                    class="btn-whatsapp d-inline-flex" onclick="return!window.open(this.href)"
                    data-testid="campaign-whatsapp-btn">
                    <i class="bi bi-whatsapp"></i> {{ __('site.campaign_cta') }}
                </a>
            </div>
            <div class="col-lg-6 reveal-right">
                <div style="border-radius:var(--radius-lg);overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.3)">
                    <img src="https://images.pexels.com/photos/8926832/pexels-photo-8926832.jpeg?auto=compress&cs=tinysrgb&w=700&q=80"
                        alt="{{ __('site.campaign_title') }}" loading="lazy"
                        style="width:100%;height:380px;object-fit:cover;display:block">
                </div>
            </div>
        </div>
    </div>
</section>