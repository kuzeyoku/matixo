# MATIXO Web Sitesi Teması

## Genel Bakış
MATIXO firması için Bootstrap 5 + Vanilla JS ile hazırlanmış e-ticaret web sitesi teması.

## Dosya Yapısı
```
/theme/
├── index.html          → Ana Sayfa
├── category.html       → Kategori / Ürün Listesi Sayfası
├── product.html        → Ürün Detay Sayfası
├── contact.html        → İletişim Sayfası
├── about.html          → Hakkımızda Sayfası
├── css/
│   ├── style.css       → Ana stil dosyası (CSS değişkenleri, tüm bileşenler)
│   └── animations.css  → Animasyonlar ve scroll reveal efektleri
├── js/
│   └── main.js         → Vanilla JS (çerez, arama, sayaç, slider thumbnails)
└── images/             → Logo ve görseller için klasör
```

## Laravel Entegrasyonu
Bu tema saf HTML/CSS/JS olarak hazırlanmıştır. Laravel yönetim panelinize entegre ederken:

1. **HTML → Blade Template**: `.html` uzantılarını `.blade.php` olarak yeniden adlandırın.
2. **CSS/JS**: `css/` ve `js/` klasörlerini Laravel `public/` dizinine taşıyın.
3. **Görseller**: `images/` klasörünü `public/images/` altına koyun.
4. **Header/Footer**: Tekrar eden `<header>` ve `<footer>` bloklarını Laravel layout dosyasına (`layouts/app.blade.php`) taşıyın.
5. **Logo**: `images/logo.png` konumuna MATIXO logosunu yerleştirin.

## Renk Paleti
| Renk       | HEX     | Kullanım                     |
|------------|---------|------------------------------|
| Arka Plan  | #F7F3EB | Sayfa zemini                 |
| Ana Renk   | #20506B | Başlıklar, butonlar, header  |
| Turkuaz    | #41B7A8 | Vurgular, ikonlar, badge     |
| Yeşil      | #51AB53 | WhatsApp butonu, onay        |
| Turuncu    | #F09237 | Kampanya, badge, özel        |

## Tipografi
- **Başlıklar**: Outfit (Google Fonts) — 700, 800
- **Gövde**: Work Sans (Google Fonts) — 400, 500

## Bileşenler
- Sticky header (mobil uyumlu, hamburger menü)
- Hero carousel (Bootstrap Carousel Fade, 3 slayt)
- Bento Grid kategori kartları (11 kategori)
- Ürün kartları (badge, WhatsApp linki, detay linki)
- Kampanya bölümü (split layout)
- İstatistik sayacı (Intersection Observer)
- Çerez bildirimi (localStorage ile durum kaydı)
- WhatsApp yüzen butonu
- Yukarı çık butonu
- Scroll reveal animasyonları

## WhatsApp Linkleri
Tüm sipariş butonları `wa.me` formatını kullanır:
```
https://wa.me/905555555555?text=Merhaba%2C%20...%20hakk%C4%B1nda%20bilgi%20almak%20istiyorum.
```
Laravel'de dinamik olarak oluşturmak için:
```php
$waLink = "https://wa.me/" . config('app.whatsapp') . "?text=" . urlencode("Merhaba, {$product->name} ürünü hakkında bilgi almak istiyorum.");
```

## SEO
- Her sayfada `<title>`, `<meta description>`, `<meta keywords>` 
- Open Graph (`og:`) ve Twitter Card meta etiketleri
- `<link rel="canonical">` 
- Schema.org JSON-LD (Organization, Product, ContactPage, AboutPage)
- Tüm görsellerde `alt` attribute
- `loading="lazy"` ile resim optimizasyonu
- Anlamsal HTML5 (`<header>`, `<main>`, `<section>`, `<article>`, `<footer>`, `<nav>`)

## Sayfa Listesi
| Dosya           | Açıklama            | Laravel Route Önerisi     |
|-----------------|---------------------|---------------------------|
| index.html      | Ana Sayfa           | `/`                       |
| category.html   | Kategori Sayfası    | `/kategori/{slug}`        |
| product.html    | Ürün Detay          | `/urun/{slug}`            |
| contact.html    | İletişim            | `/iletisim`               |
| about.html      | Hakkımızda          | `/hakkimizda`             |

## Geliştirme Notları
- Bootstrap 5.3.3 CDN üzerinden kullanılmaktadır.
- Bootstrap Icons 1.11.3 CDN üzerinden kullanılmaktadır.
- Harici JavaScript bağımlılığı yoktur (jQuery veya diğer kütüphaneler).
- `js/main.js` içindeki WhatsApp numarası Laravel config'den çekilebilir.
- Ürün sayfa görselleri için Bootstrap Carousel kullanılmaktadır.
