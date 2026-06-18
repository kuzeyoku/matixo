@php $campaign = app(\App\Services\CampaignService::class)->getOrCreate(); @endphp

@if($campaign && $campaign->is_active)
<div class="matixo-modal-backdrop" id="campaignModal" role="dialog" aria-modal="true"
    aria-labelledby="campaignModalTitle" data-testid="campaign-modal"
    data-delay="{{ ($campaign->show_delay_seconds ?? 2) * 1000 }}"
    data-hide-days="{{ $campaign->hide_days ?? 3 }}">
    <div class="matixo-modal">
        <button type="button" class="matixo-modal-close" data-modal-close aria-label="{{ __('site.modal_close') }}"
            data-testid="campaign-modal-close-btn">
            <i class="bi bi-x-lg"></i>
        </button>

        <!-- Sol: Görsel + Slogan -->
        <div class="matixo-modal-visual">
            <img src="{{ $campaign->image ? asset('storage/' . $campaign->image) : 'https://images.pexels.com/photos/8926832/pexels-photo-8926832.jpeg?auto=compress&cs=tinysrgb&w=600&q=80' }}"
                alt="{{ __('site.modal_special_offer') }}" loading="lazy">
            <div class="matixo-modal-visual-content">
                <span class="matixo-modal-tag">
                    <i class="bi bi-stars"></i> {{ gt($campaign, 'highlight_word') ?: __('site.modal_special_offer') }}
                </span>
                <h3 id="campaignModalTitle">
                    {{ gt($campaign, 'title') }}
                </h3>
                @if($campaign->valid_until)
                <div class="matixo-modal-visual-foot">
                    <i class="bi bi-calendar-event"></i>
                    <span>{{ __('site.modal_valid_until', ['date' => $campaign->valid_until->translatedFormat('d F Y')]) }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Sağ: İçerik + CTA -->
        <div class="matixo-modal-body">
            <h4>{{ gt($campaign, 'title') }}</h4>
            <p class="lead">
                {{ gt($campaign, 'description') }}
            </p>

            <ul class="matixo-modal-perks" data-testid="campaign-modal-perks">
                @foreach($campaign->perks ?? [] as $perk)
                    @php
                        $perkText = '';
                        if (is_array($perk['text'])) {
                            $perkText = $perk['text'][app()->getLocale()] ?? ($perk['text'][default_locale()] ?? '');
                        }
                    @endphp
                    @if($perkText)
                        <li><i class="bi bi-check-lg"></i><span>{!! $perkText !!}</span></li>
                    @endif
                @endforeach
            </ul>

            <div class="matixo-modal-cta">
                <a href="{{ $campaign->button_url ?? '#' }}"
                    class="btn-whatsapp" onclick="return!window.open(this.href)" data-modal-close
                    data-testid="campaign-modal-whatsapp-btn">
                    <i class="bi bi-whatsapp"></i> {{ gt($campaign, 'button_text') ?: __('site.modal_get_offer') }}
                </a>
                <a href="{{ route('home') }}" class="btn-outline-custom" data-modal-close
                    data-testid="campaign-modal-explore-btn">
                    <i class="bi bi-grid"></i> {{ __('site.modal_explore') }}
                </a>
            </div>

            <div class="matixo-modal-foot">
                <label>
                    <input type="checkbox" id="campaignDontShow" data-testid="campaign-modal-hide-check">
                    {{ __('site.modal_dont_show') }}
                </label>
                <a href="#" data-modal-close data-testid="campaign-modal-dismiss-link">{{ __('site.modal_dismiss') }}</a>
            </div>
        </div>
    </div>
</div>
@endif