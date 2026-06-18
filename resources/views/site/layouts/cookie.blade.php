<div class="cookie-consent" id="cookieConsent" role="dialog" aria-label="{{ __('site.cookie_title') }}" data-testid="cookie-consent">
    <div class="cookie-icon">🍪</div>
    <div class="cookie-text">
        <p>
            <strong>{{ __('site.cookie_title') }}</strong> {{ __('site.cookie_text') }}
            <a href="#">{{ __('site.cookie_policy_link') }}</a> {{ __('site.cookie_policy_suffix') }}
        </p>
    </div>
    <div class="cookie-actions">
        <button class="btn-primary-custom" id="cookieAccept" data-testid="cookie-accept-btn"
            style="padding:0.5rem 1.25rem;font-size:0.88rem">
            <i class="bi bi-check-lg"></i> {{ __('site.cookie_accept') }}
        </button>
        <button class="btn-outline-custom" id="cookieReject" data-testid="cookie-reject-btn"
            style="padding:0.5rem 1.25rem;font-size:0.88rem">
            {{ __('site.cookie_reject') }}
        </button>
    </div>
</div>