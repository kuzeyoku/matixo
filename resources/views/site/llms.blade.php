# MATIXO

> {{ setting('seo_meta_description') ?: 'Eğitim mekanları tasarlayan, bilim ve matematik parkları üreten, müze ekipmanları ve montessöri materyalleri geliştiren öncü bir üretim firması.' }}

MATIXO, okul, belediye, bilim merkezi ve müze projeleri için özel tasarım ve CE standartlarına uygun interaktif eğitim modülleri ve park ekipmanları üretmektedir.

## Ana Sayfalar
- [Ana Sayfa]({{ route('home') }})
- [Tüm Ürünler]({{ route('products.index') }})
- [Kategoriler]({{ route('categories.index') }})
- [İletişim]({{ route('contact') }})

## Kategoriler
@foreach($categories as $category)
- [{{ gt($category, 'name') }}]({{ route('categories.show', $category->slug) }}): {{ Str::limit(gt($category, 'description'), 120) }}
@endforeach

## Ürünler
@foreach($products as $product)
- [{{ gt($product, 'title') }}]({{ route('products.show', $product->slug) }}): {{ Str::limit(strip_tags(gt($product, 'short_description')), 150) }}
@endforeach

## Bilgi Sayfaları
@foreach($pages as $page)
- [{{ gt($page, 'title') }}]({{ route('pages.show', $page->slug) }})
@endforeach
