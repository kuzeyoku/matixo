@extends("site.layouts.main")

@section('title', gt($page, 'meta_title') ?: gt($page, 'title'))
@section('meta_description', gt($page, 'meta_description') ?: Str::limit(strip_tags(gt($page, 'content')), 160))

@section("content")
    <!-- Sayfa Hero / Breadcrumb -->
    <div class="page-hero" data-testid="page-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div
                            style="width:42px;height:42px;background:rgba(255,255,255,0.15);border-radius:10px;display:flex;align-items:center;justify-content:center">
                            <i class="bi bi-file-text" style="font-size:1.4rem;color:var(--white)"></i>
                        </div>
                        <span
                            style="font-family:'Outfit',sans-serif;font-weight:600;font-size:1rem;color:var(--turquoise)">{{ __('site.pages_corporate_label') }}</span>
                    </div>
                    <h1 class="page-hero-title mb-3">{{ gt($page, 'title') }}</h1>
                </div>
                <div class="col-lg-4 d-none d-lg-flex justify-content-end">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.pages_home_breadcrumb') }}</a></li>
                            <li class="breadcrumb-item active">{{ gt($page, 'title') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Sayfa İçeriği -->
    <section class="py-7" data-testid="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div style="background:var(--white);border-radius:var(--radius-lg);padding:3rem;border:1px solid var(--border);box-shadow:0 10px 30px rgba(0,0,0,0.02)">
                        <div class="page-description-content" style="color:var(--text-muted);line-height:1.8;font-size:1rem">
                            {!! gt($page, 'content') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
