@extends("site.layouts.main")

@section('title', __('site.categories'))

@section("content")
    <!-- Sayfa Hero / Breadcrumb -->
    <div class="page-hero" data-testid="page-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="hero-icon-box">
                            <i class="bi bi-grid-fill"></i>
                        </div>
                        <span class="hero-label">{{ __('site.categories') }}</span>
                    </div>
                    <h1>{{ __('site.all_categories') }}</h1>
                    <p class="hero-desc">{{ __('site.cat_section_subtitle') }}</p>
                </div>
                <div class="col-lg-4 d-none d-lg-flex justify-content-end align-items-center">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.breadcrumb_home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('site.categories') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Ana İçerik -->
    <main class="py-6" data-testid="categories-main">
        <div class="container">
            <div class="row g-4">
                @forelse($categories as $category)
                    <div class="col-md-6 col-lg-4 reveal">
                        <div class="card h-100 border-0 shadow-sm category-card" style="border-radius: var(--radius-md); overflow: hidden; transition: var(--transition);">
                            <div class="position-relative" style="height: 200px; overflow: hidden;">
                                <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://placehold.co/800x600/eeeeee/999999?text=' . urlencode(gt($category, 'name')) }}" 
                                     alt="{{ gt($category, 'name') }}" 
                                     style="width: 100%; height: 100%; object-fit: cover; transition: var(--transition);" 
                                     class="category-img">
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-3" style="background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);">
                                    <div class="d-flex align-items-center gap-2 text-white">
                                        <div class="d-flex align-items-center justify-content-center bg-primary rounded-circle" style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="{{ $category->icon ?? 'bi bi-grid-fill' }} text-white" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <h3 class="h5 mb-0 text-white fw-bold">{{ gt($category, 'name') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="text-muted small mb-3 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    {{ gt($category, 'description') ?: __('site.empty_category') }}
                                </p>
                                
                                @if($category->children->isNotEmpty())
                                    <div class="mb-3">
                                        <h4 class="small fw-bold text-uppercase text-muted mb-2">{{ __('site.filter_sub_cats') }}</h4>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($category->children->take(4) as $child)
                                                <a href="{{ route('categories.show', $child->slug) }}" class="badge bg-light text-dark text-decoration-none border py-1.5 px-2">
                                                    {{ gt($child, 'name') }}
                                                </a>
                                            @endforeach
                                            @if($category->children->count() > 4)
                                                <span class="badge bg-light text-muted border py-1.5 px-2">+{{ $category->children->count() - 4 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                    <span class="small text-muted">{{ __('site.product_count', ['count' => $category->products_count]) }}</span>
                                    <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-sm btn-primary-custom" style="border-radius: 50px;">
                                        {{ __('site.detail_btn') }} <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-grid text-muted" style="font-size: 3rem;"></i>
                        <p class="mt-3 text-muted">{{ __('site.empty_category') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <style>
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .category-card:hover .category-img {
            transform: scale(1.05);
        }
    </style>
@endsection
