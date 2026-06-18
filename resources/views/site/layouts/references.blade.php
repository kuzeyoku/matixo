<section class="references-section" data-testid="references-section">
    <div class="container">
        <div class="text-center mb-4 reveal">
            <p class="section-subtitle ref-subtitle-custom">
                {{ __('site.ref_subtitle') }}
            </p>
        </div>
        <div class="row g-4 align-items-center justify-content-center text-center">
            @foreach($references as $reference)
                <div class="col-4 col-md-2 reveal delay-{{ $loop->iteration > 6 ? 1 : $loop->iteration }}">
                    @if($reference->link_url)
                        <a href="{{ $reference->link_url }}" onclick="return!window.open(this.href)" class="reference-item-link" data-testid="reference-link-{{ $reference->id }}">
                    @else
                        <div class="reference-item-wrap">
                    @endif

                    @if($reference->logo)
                        <img src="{{ asset('storage/' . $reference->logo) }}" alt="{{ $reference->name }}" class="reference-logo img-fluid" data-testid="reference-logo-{{ $reference->id }}">
                    @else
                        <span class="reference-text" data-testid="reference-text-{{ $reference->id }}">{{ $reference->name }}</span>
                    @endif

                    @if($reference->link_url)
                        </a>
                    @else
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>