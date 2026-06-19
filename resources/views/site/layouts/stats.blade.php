<section class="stats-section" data-testid="stats-section">
    <div class="container">
        <div class="row g-4 text-center align-items-center">
            @for($i = 1; $i <= 4; $i++)
                @php
                    $numVal = setting("stat_{$i}_number");
                    if (!$numVal) {
                        $defaults = [1 => '120+', 2 => '85+', 3 => '15 Yıl', 4 => '50+'];
                        $numVal = $defaults[$i] ?? '0';
                    }
                    preg_match('/^\d+/', $numVal, $matches);
                    $count = $matches[0] ?? '0';
                    $suffix = trim(str_replace($count, '', $numVal));
                    
                    $defaultLabels = [
                        1 => __('site.stat_projects'),
                        2 => __('site.stat_clients'),
                        3 => __('site.stat_experience'),
                        4 => __('site.stat_cities')
                    ];
                    $labelVal = setting("stat_{$i}_label") ?: $defaultLabels[$i];

                    if (empty($suffix)) {
                        if ($i === 3 || stripos($labelVal, 'tecrübe') !== false || stripos($labelVal, 'yıl') !== false) {
                            $suffix = ' ' . trim(__('site.stat_experience_suffix'));
                        } else {
                            $suffix = '+';
                        }
                    }
                @endphp
                <div class="col-6 col-md-3">
                    <div class="stat-item reveal delay-{{ $i }}">
                        <span class="stat-number" data-count="{{ $count }}" data-suffix="{{ $suffix }}">0{{ $suffix }}</span>
                        <span class="stat-label">{{ $labelVal }}</span>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
