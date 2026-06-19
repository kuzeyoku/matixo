@extends('site.layouts.main')
@section("content")
    @if(setting('home_show_slider', '1') == '1')
        @include("site.layouts.slider")
    @endif

    @if(setting('home_show_categories', '1') == '1')
        @include("site.layouts.categories")
    @endif

    @if(setting('home_show_featured', '1') == '1')
        @include("site.layouts.featured")
    @endif

    @if(setting('home_show_campaign', '1') == '1')
        @include("site.layouts.campaign")
    @endif

    @if(setting('home_show_why', '1') == '1')
        @include("site.layouts.whyus")
    @endif

    @if(setting('home_show_stats', '1') == '1')
        @include("site.layouts.stats")
    @endif

    @if(setting('home_show_references', '1') == '1')
        @include("site.layouts.references")
    @endif
@endsection