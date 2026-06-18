/**
 * MATIXO - Ana JavaScript Dosyası
 * Bootstrap 5 + Vanilla JS
 */

'use strict';

// ===================================
// DOM Hazır
// ===================================
document.addEventListener('DOMContentLoaded', function () {
  initCookieConsent();
  initCampaignModal();
  initScrollReveal();
  initStickyHeader();
  initBackToTop();
  initSearchToggle();
  initCounters();
  initProductThumbs();
  initTooltips();
});

// ===================================
// Kampanya / Duyuru Modalı
// ===================================
function initCampaignModal() {
  const modal = document.getElementById('campaignModal');
  if (!modal) return;

  const STORAGE_KEY = 'matixo_campaign_dismissed';
  const HIDE_DAYS = 3; // 'Bir daha gösterme' seçilirse kaç gün gizlenecek

  // Daha önce kalıcı olarak kapatıldı mı?
  const dismissed = localStorage.getItem(STORAGE_KEY);
  if (dismissed) {
    const elapsed = Date.now() - parseInt(dismissed, 10);
    const expireMs = HIDE_DAYS * 24 * 60 * 60 * 1000;
    if (elapsed < expireMs) return;
  }

  // 1.8 sn sonra göster
  setTimeout(function () {
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
  }, 1800);

  function close(remember) {
    modal.classList.remove('show');
    document.body.style.overflow = '';
    if (remember) {
      localStorage.setItem(STORAGE_KEY, Date.now().toString());
    }
  }

  modal.querySelectorAll('[data-modal-close]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const dontShow = document.getElementById('campaignDontShow');
      close(!!(dontShow && dontShow.checked));
    });
  });

  // Backdrop tıklaması
  modal.addEventListener('click', function (e) {
    if (e.target === modal) close(false);
  });

  // ESC tuşu
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modal.classList.contains('show')) close(false);
  });
}

// ===================================
// Çerez Bildirimi
// ===================================
function initCookieConsent() {
  const consent = document.getElementById('cookieConsent');
  if (!consent) return;

  const accepted = localStorage.getItem('matixo_cookie_accepted');
  if (!accepted) {
    setTimeout(() => consent.classList.add('show'), 1500);
  }

  const btnAccept = document.getElementById('cookieAccept');
  const btnReject = document.getElementById('cookieReject');

  if (btnAccept) {
    btnAccept.addEventListener('click', function () {
      localStorage.setItem('matixo_cookie_accepted', 'true');
      consent.classList.remove('show');
    });
  }
  if (btnReject) {
    btnReject.addEventListener('click', function () {
      localStorage.setItem('matixo_cookie_accepted', 'false');
      consent.classList.remove('show');
    });
  }
}

// ===================================
// Yapışkan Header
// ===================================
function initStickyHeader() {
  const header = document.querySelector('.main-header');
  if (!header) return;

  function onScroll() {
    if (window.scrollY > 80) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
}

// ===================================
// Yukarı Çık Butonu
// ===================================
function initBackToTop() {
  const btn = document.getElementById('backToTop');
  if (!btn) return;

  window.addEventListener('scroll', function () {
    if (window.scrollY > 400) {
      btn.classList.add('show');
    } else {
      btn.classList.remove('show');
    }
  }, { passive: true });

  btn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// ===================================
// Arama Paneli
// ===================================
function initSearchToggle() {
  const searchBtn = document.getElementById('searchToggle');
  const searchForm = document.getElementById('searchPanel');
  if (!searchBtn || !searchForm) return;

  searchBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    searchForm.classList.toggle('show');
    if (searchForm.classList.contains('show')) {
      searchForm.querySelector('input').focus();
    }
  });

  document.addEventListener('click', function (e) {
    if (!searchForm.contains(e.target) && e.target !== searchBtn) {
      searchForm.classList.remove('show');
    }
  });
}

// ===================================
// Scroll Reveal Animasyonları
// ===================================
function initScrollReveal() {
  const revealEls = document.querySelectorAll(
    '.reveal, .reveal-left, .reveal-right, .reveal-zoom'
  );
  if (!revealEls.length) return;

  const observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
  );

  revealEls.forEach(function (el) { observer.observe(el); });
}

// ===================================
// Sayaç Animasyonu
// ===================================
function initCounters() {
  const counters = document.querySelectorAll('[data-count]');
  if (!counters.length) return;

  const observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.5 }
  );

  counters.forEach(function (el) { observer.observe(el); });
}

function animateCounter(el) {
  const target = parseInt(el.getAttribute('data-count'), 10);
  const suffix = el.getAttribute('data-suffix') || '';
  const duration = 1800;
  const step = target / (duration / 16);
  let current = 0;

  const timer = setInterval(function () {
    current += step;
    if (current >= target) {
      current = target;
      clearInterval(timer);
    }
    el.textContent = Math.floor(current).toLocaleString('tr-TR') + suffix;
  }, 16);
}

// ===================================
// Ürün Görseli Thumbnails (Ürün Sayfası)
// ===================================
function initProductThumbs() {
  const thumbs = document.querySelectorAll('.product-thumb');
  if (!thumbs.length) return;

  const carousel = document.getElementById('productCarousel');
  if (!carousel) return;

  const bsCarousel = bootstrap.Carousel.getInstance(carousel) ||
    new bootstrap.Carousel(carousel, { interval: false });

  thumbs.forEach(function (thumb, i) {
    thumb.addEventListener('click', function () {
      thumbs.forEach(function (t) { t.classList.remove('active'); });
      thumb.classList.add('active');
      bsCarousel.to(i);
    });
  });

  carousel.addEventListener('slid.bs.carousel', function (e) {
    thumbs.forEach(function (t) { t.classList.remove('active'); });
    if (thumbs[e.to]) thumbs[e.to].classList.add('active');
  });
}

// ===================================
// Bootstrap Tooltips
// ===================================
function initTooltips() {
  const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  tooltipEls.forEach(function (el) {
    new bootstrap.Tooltip(el);
  });
}

// ===================================
// Ürün Filtresi (Kategori Sayfası)
// ===================================
function filterProducts() {
  const sortEl = document.getElementById('sortSelect');
  if (sortEl) {
    sortEl.addEventListener('change', function () {
      // Laravel backend entegrasyonu için sort parametresi URL'ye eklenir
      const url = new URL(window.location.href);
      url.searchParams.set('sort', this.value);
      // window.location.href = url.toString(); // Backend entegrasyonunda aktif edilir
      console.log('[MATIXO] Sort:', this.value);
    });
  }
}

// ===================================
// WhatsApp Mesaj Oluşturucu
// ===================================
function buildWhatsAppLink(productName, productCode) {
  const phone = '905555555555';
  const msg = encodeURIComponent(
    'Merhaba, ' + productName + ' (' + (productCode || '') + ') ürünü hakkında bilgi almak istiyorum.'
  );
  return 'https://wa.me/' + phone + '?text=' + msg;
}

// WhatsApp linklerini dinamik olarak güncelle
document.querySelectorAll('[data-product-name]').forEach(function (el) {
  const name = el.getAttribute('data-product-name');
  const code = el.getAttribute('data-product-code') || '';
  el.setAttribute('href', buildWhatsAppLink(name, code));
});

// ===================================
// Lazy Loading (Native)
// ===================================
document.querySelectorAll('img[data-src]').forEach(function (img) {
  img.setAttribute('loading', 'lazy');
  const observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        img.src = img.getAttribute('data-src');
        observer.disconnect();
      }
    });
  });
  observer.observe(img);
});

// ===================================
// İletişim Formu
// ===================================
const contactForm = document.getElementById('contactForm');
if (contactForm) {
  contactForm.addEventListener('submit', function (e) {
    e.preventDefault();
    const btn = contactForm.querySelector('[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Gönderiliyor...';
    btn.disabled = true;

    // Simülasyon - backend entegrasyonunda gerçek istek gönderilir
    setTimeout(function () {
      btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Mesajınız İletildi!';
      btn.classList.remove('btn-primary-custom');
      btn.classList.add('btn-whatsapp');
      contactForm.reset();
      setTimeout(function () {
        btn.innerHTML = originalText;
        btn.disabled = false;
        btn.classList.add('btn-primary-custom');
        btn.classList.remove('btn-whatsapp');
      }, 3500);
    }, 1800);
  });
}

// ===================================
// Sayfa Yükleme Çubuğu Kaldır
// ===================================
window.addEventListener('load', function () {
  const loader = document.querySelector('.page-loader');
  if (loader) {
    setTimeout(function () {
      loader.style.display = 'none';
    }, 1200);
  }
});
