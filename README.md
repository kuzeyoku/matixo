# MATIXO Admin Panel — Laravel 12

Açık hava bilim parkları, montessöri materyalleri, müze ekipmanları üreten MATIXO firması için **çoklu dil destekli, Bootstrap 5 tabanlı yönetim paneli**.

## 🚀 Hızlı Başlangıç

```bash
cd matixo-laravel
composer install
cp .env.example .env
# .env içinde DB_DATABASE, DB_USERNAME, DB_PASSWORD ayarla
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

**Giriş:** http://127.0.0.1:8000/admin/login
**Email:** `admin@matixo.com` · **Şifre:** `Matixo!2026Admin`

---

## ✨ Modüller (Faz 1 + Faz 2 = TAMAMLANDI)

| Modül | URL | İçerik |
|---|---|---|
| 📊 Dashboard | `/admin` | İstatistik kartları, son mesajlar/aktiviteler |
| 🗂️ Kategoriler | `/admin/categories` | CRUD + ağaç yapı + Bento + Sortable + Dropify |
| 📦 Ürünler | `/admin/products` | Galeri + Features + Specs + Quill açıklama + 5 sekme |
| ⭐ Yorumlar | `/admin/reviews` | Onayla / Reddet / Sil |
| 🎞️ Sliderlar | `/admin/sliders` | CRUD + tarih aralığı + Sortable |
| 🎯 Kampanya Modal | `/admin/campaign` | Singleton + Perks repeater + gösterim ayarları |
| 🏢 Referanslar | `/admin/references` | CRUD + logo + Sortable |
| 📄 Sayfalar | `/admin/pages` | Quill içerik + SEO + footer toggle |
| 💬 Mesajlar | `/admin/messages` | Liste + okudum + cevapla (mail gönderir) + sil |
| ⚙️ Ayarlar | `/admin/settings` | **7 sekme** + SMTP test butonu |
| 👥 Kullanıcılar | `/admin/users` | CRUD + aktif/pasif + kilit aç |
| 🌍 Diller | `/admin/languages` | CRUD + LTR/RTL + varsayılan |
| 📜 Aktivite | `/admin/activity` | Log liste + filtre |

---

## 🏗️ Mimari (Merkezi Sistem)

### Modeller (Eloquent)
```
BaseModel (abstract)
  ├─ Category   ✓ HasTranslations + softDeletes
  ├─ Product    ✓ HasTranslations + softDeletes + 4 ilişki
  ├─ Slider     ✓ HasTranslations + softDeletes
  └─ Page       ✓ HasTranslations + softDeletes

Model (direct)
  ├─ User, Language, Setting
  ├─ ProductImage, ProductFeature, ProductSpec
  ├─ Review, Campaign, Reference
  ├─ ContactMessage, ActivityLog
```

### Servisler
```
BaseService (abstract)  ← paginate / create / update / delete / toggle / reorder
  ├─ CategoryService
  ├─ ProductService     (sync features + specs + gallery)
  ├─ SliderService
  └─ PageService

Standalone services:
  ├─ MediaService       (WebP + Intervention v3)
  ├─ ActivityLogger     (login/logout/CRUD audit)
  ├─ CampaignService    (singleton)
  ├─ ReferenceService   (sade, BaseModel kullanmaz)
  └─ SettingService     (toplu kaydet + SMTP test)
```

### Controller'lar
```
BaseAdminController (abstract)  ← index/create/store/edit/update/destroy/toggle/reorder
  ├─ CategoryController
  ├─ ProductController
  ├─ SliderController
  └─ PageController

Standalone controllers:
  ├─ DashboardController, LoginController
  ├─ ReviewController, MessageController
  ├─ CampaignController, ReferenceController
  ├─ SettingController, UserController
  ├─ LanguageController, ActivityLogController
```

### FormRequest'ler
```
BaseAdminRequest (abstract)
  ├─ translatableRule($field)
  ├─ translatableTextarea($field, $max)
  └─ imageRule($maxKb)

  ↳ CategoryRequest, ProductRequest, SliderRequest, PageRequest,
    CampaignRequest, ReferenceRequest
```

---

## 🔁 Blade Component Sistemi (DRY)

| Component | Kullanım |
|---|---|
| `admin.components.list-card` | Liste sayfası wrapper (arama + filtre + sayfalama) |
| `admin.components.translatable-input` | Çoklu dil sekmeli input/textarea/Quill |
| `admin.components.dropify` | Dropify görsel yükleyici + sil checkbox |
| `admin.components.form-assets` | Dropify+Quill+SortableJS CDN inject + auto-init |

Form yaklaşımı:
```blade
@include('admin.components.translatable-input', [
  'field' => 'title', 'item' => $item, 'type' => 'text',
  'label' => 'Başlık', 'required' => true,
])
```

---

## 🌍 Çoklu Dil

- Tüm `title/name/description/content` alanları **JSON kolon** (`spatie/laravel-translatable`)
- `languages` tablosu: TR (default) + EN (seed'lenmiş), panelden ekle/sil
- Admin formları **dil sekmeli** (TR / EN / yeni eklediğin diller)
- Frontend route prefix: `/` (TR), `/en/...` (EN)
- `default_locale()` ve `active_languages()` helper'ları

---

## ✉️ E-posta / SMTP

### Yapılandırma
1. `/admin/settings/?group=smtp` sekmesine git
2. SMTP Host / Port / Encryption / Username / Password / From Email / From Name doldur
3. **"Test maili gönder"** butonu ile doğrula

### Otomatik Akış
- İletişim formundan gelen mesaj → DB'ye kaydedilir
- Admin'lere otomatik bildirim maili gider (`NewContactMessage`)
- Panelden cevap yazılır → `ContactReply` mailable gönderilir + DB'ye `reply_content` kaydedilir

### Geliştirme
`.env` içinde `MAIL_MAILER=log` → mail'ler `storage/logs/laravel.log`'a yazılır.

---

## 🔐 Güvenlik

| Önlem | Detay |
|---|---|
| Login rate limit | 5 deneme / dakika (email + IP bazlı) |
| Hesap kilidi | 5 başarısız → 15 dakika kilit (otomatik açma butonu var) |
| Honeypot | Bot tuzağı görünmez input |
| Activity log | Tüm login/logout/CRUD işlemleri loglanır |
| Bcrypt rounds | 12 (`BCRYPT_ROUNDS` env) |
| CSRF | Tüm formlar `@csrf` |
| Session | DB driver, 120 dk inaktif → çıkış |
| Şifre min | 10 karakter |
| Self-protection | Kendi hesabını silemez/devre dışı bırakamaz |
| Strict Schema | InnoDB + utf8mb4_unicode_ci |

---

## 🎨 Admin UI

- **Bootstrap 5.3** + Bootstrap Icons + Outfit/Inter font
- Sidebar koyu lacivert (frontend tema ile uyumlu)
- Topbar — arama + bildirim badge + kullanıcı menü
- Marka renkleri CSS değişkeni olarak (`--mx-primary`, `--mx-turquoise`, `--mx-orange`)
- Tüm form bileşenleri Bootstrap stiline uygun

### Harici JS (sadece form sayfalarında)
- **Quill 2.0** — WYSIWYG editör (CDN, 43 KB)
- **Dropify** — görsel yükleyici (CDN, jQuery ile)
- **SortableJS** — sürükle bırak sıralama (CDN, 10 KB)

---

## ⚙️ Ayarlar Bölümleri (7 sekme)

| Sekme | İçerik |
|---|---|
| **Site** | Site adı, slogan, logo, favicon, footer metni, copyright, bakım modu |
| **İletişim** | Telefon, WhatsApp, email, adres, çalışma saatleri, Maps embed |
| **Sosyal Medya** | Instagram, Facebook, LinkedIn, Twitter, YouTube |
| **SMTP / Mail** | Host, port, encryption, user, password, from + **Test butonu** |
| **Bildirimler** | Email listesi, yeni mesaj/yorum bildirim toggle'ları |
| **SEO** | Meta title/desc, OG image, GA4, GTM, Site Verification |
| **Anasayfa** | Bölüm aç/kapa toggle'ları + öne çıkan ürün adedi + 4 istatistik |

`SettingService::save()` formdan gelen tüm anahtarları otomatik kaydeder ve `Cache::forget('matixo.settings')` ile cache'i temizler.

---

## 📁 Yüklenen Görseller

```
storage/app/public/
├── products/cover/{thumb,medium}/  ← ürün kapakları
├── products/gallery/                ← galeri
├── categories/                      ← kategori görselleri
├── sliders/                         ← slider görselleri
├── campaigns/                       ← kampanya modal görseli
├── references/                      ← referans logoları
├── pages/                           ← sayfa kapakları
└── settings/                        ← logo, favicon, OG image
```

**`MediaService`** her yüklemede:
1. Random isim (40 karakter) ile WebP'e dönüştürür
2. Kalite 85
3. Belirtilen boyutları üretir (thumb 320×240, medium 800×600)
4. Eski dosyayı (varsa) siler

`php artisan storage:link` unutmayın.

---

## 🛠️ Bakım Komutları

```bash
# Cache temizle
php artisan cache:clear

# Settings cache
php artisan tinker
>>> Cache::forget('matixo.settings');

# Aktivite logu temizle (varsayılan 90 günden eski)
php artisan activity:prune
php artisan activity:prune --days=30

# Cron (production):
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🚧 Sıradaki (Faz 3 — Frontend Blade Dönüşümü)

Mevcut statik HTML temayı (`/app/theme/`) Laravel Blade'e dönüştür:
- `resources/views/site/home.blade.php` ← `index.html` (slider, bento, ürünler DB'den)
- `resources/views/site/category.blade.php` ← `category.html`
- `resources/views/site/product.blade.php` ← `product.html`
- `resources/views/site/about.blade.php` ← `about.html`
- `resources/views/site/contact.blade.php` ← `contact.html` + form post → `ContactMessage`
- `SiteController` veya benzeri → DB'den içerik
- Kampanya modal: `@if($campaign?->is_active) @include('site.partials.modal') @endif`
- Çoklu dil URL routing: `Route::prefix('{locale?}')->where(['locale' => 'tr|en']) ->group(...)`

---

## 🐛 Bilinen Konular

| Sorun | Çözüm |
|---|---|
| 500 — `vendor/autoload not found` | `composer install` |
| `SQLSTATE 1045` | `.env` DB bilgilerini kontrol et |
| Görseller görünmüyor | `php artisan storage:link` |
| Login'de kilit | Panel üzerinden "Kilidi aç" veya DB'de `users.locked_until = NULL` |
| Hız aşımı | Cache temizle: `php artisan cache:clear` |

---

## 📄 Lisans
MIT
