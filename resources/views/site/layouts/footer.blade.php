<footer class="main-footer" data-testid="main-footer">
    <div class="container">
        <div class="row g-5">
            <!-- Marka -->
            <div class="col-lg-4">
                <span class="footer-brand"><span class="logo-text">MATI<span
                            style="color:var(--turquoise)">X</span>O</span></span>
                <p class="footer-desc">
                    {{ setting('site_description') ?? __('site.why_expert_desc') }}
                </p>
                <div class="footer-social">
                    @if(setting('social_instagram'))
                        <a href="{{ setting('social_instagram') }}" aria-label="Instagram" onclick="return!window.open(this.href)"><i
                                class="bi bi-instagram"></i></a>
                    @endif
                    @if(setting('social_linkedin'))
                        <a href="{{ setting('social_linkedin') }}" aria-label="LinkedIn" onclick="return!window.open(this.href)"><i
                                class="bi bi-linkedin"></i></a>
                    @endif
                    @if(setting('social_youtube'))
                        <a href="{{ setting('social_youtube') }}" aria-label="YouTube" onclick="return!window.open(this.href)"><i
                                class="bi bi-youtube"></i></a>
                    @endif
                    @if(setting('social_facebook'))
                        <a href="{{ setting('social_facebook') }}" aria-label="Facebook" onclick="return!window.open(this.href)"><i
                                class="bi bi-facebook"></i></a>
                    @endif
                    @if(setting('contact_whatsapp'))
                        <a href="https://wa.me/{{ setting('contact_whatsapp') }}" aria-label="WhatsApp" onclick="return!window.open(this.href)"><i class="bi bi-whatsapp"></i></a>
                    @endif
                </div>
            </div>

            <!-- Kategoriler -->
            <div class="col-sm-6 col-lg-2">
                <h4 class="footer-heading">{{ __('site.footer_categories') }}</h4>
                <ul class="footer-links">
                    @foreach($footerCategories as $cat)
                        <li><a href="{{ route('categories.show', $cat->slug) }}"><i
                                    class="bi bi-chevron-right"></i>{{ Str::limit(gt($cat, 'name'), 15) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Kurumsal -->
            <div class="col-sm-6 col-lg-2">
                <h4 class="footer-heading">{{ __('site.footer_corporate') }}</h4>
                <ul class="footer-links">
                    @foreach($footerPages->take(4) as $page)
                        <li><a href="{{ route('pages.show', $page->slug) }}"><i
                                    class="bi bi-chevron-right"></i>{{ gt($page, 'title') }}</a>
                        </li>
                    @endforeach
                    <li><a href="{{ route('contact') }}"><i class="bi bi-chevron-right"></i>{{ __('site.contact') }}</a></li>

                </ul>
            </div>

            <!-- İletişim -->
            <div class="col-lg-4">
                <h4 class="footer-heading">{{ __('site.footer_contact') }}</h4>
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>{!! nl2br(e(setting('contact_address'))) !!}</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <span>{{ setting('contact_phone') }}</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <span>{{ setting('contact_email') }}</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-clock-fill"></i>
                    <span>{{ setting('working_hours') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <p>{!! __('site.footer_copyright', ['year' => date('Y')]) !!}</p>
                <div class="d-flex gap-3">
                    @foreach($footerPages->skip(4)->take(3) as $page)
                        <a
                            href="{{ route('pages.show', $page->slug) }}">{{ gt($page, 'title') }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</footer>