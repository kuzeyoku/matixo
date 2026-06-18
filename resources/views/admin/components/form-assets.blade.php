{{--
  Form-extends: Quill/Dropify/SortableJS CDN'lerini layout'a inject eder.
  Edit/create view'ların başına ekleyin.
--}}
@push('styles')
  <link href="{{ admin_asset('admin/css/dropify.min.css') }}" rel="stylesheet">
  <link href="{{ admin_asset('admin/css/quill.snow.css') }}" rel="stylesheet">
  <style>
    .nav-tabs-translatable .nav-link { padding: 0.4rem 0.85rem; font-size: 0.82rem; }
    .tab-content-translatable { border: 1px solid var(--bs-border-color-translucent); border-top: 0; border-radius: 0 0 0.5rem 0.5rem; padding: 0.75rem; background: white; }
    .ql-editor { min-height: 180px; }
    .ql-toolbar.ql-snow, .ql-container.ql-snow { border-color: var(--mx-border); }
    .ql-toolbar.ql-snow { border-radius: 0.5rem 0.5rem 0 0; background: var(--mx-bg); }
    .ql-container.ql-snow { border-radius: 0 0 0.5rem 0.5rem; }
    .dropify-wrapper { border-radius: 0.5rem; border-color: var(--mx-border); }
    .sortable-handle { cursor: grab; color: var(--mx-muted); }
    .sortable-ghost { opacity: 0.4; background: var(--mx-bg); }
    .repeater-row { background: white; border: 1px solid var(--mx-border); border-radius: 0.5rem; padding: 0.85rem; margin-bottom: 0.5rem; }
  </style>
@endpush

@push('scripts')
  <script src="{{ admin_asset('admin/js/jquery.min.js') }}"></script>
  <script src="{{ admin_asset('admin/js/dropify.min.js') }}"></script>
  <script src="{{ admin_asset('admin/js/quill.js') }}"></script>
  <script src="{{ admin_asset('admin/js/Sortable.min.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Dropify init
      if (window.jQuery && jQuery('.dropify').length) {
        jQuery('.dropify').dropify();
      }
      // Quill init (MATIXO.initQuill helper'ı admin.js'de)
      if (window.MATIXO && window.MATIXO.initQuill) {
        window.MATIXO.initQuill();
      }
      // Sortable tables
      document.querySelectorAll('[data-sortable]').forEach(function (el) {
        var url = el.getAttribute('data-sortable-url');
        new Sortable(el, {
          handle: '.sortable-handle',
          animation: 150,
          ghostClass: 'sortable-ghost',
          onEnd: function () {
            if (!url) return;
            var ids = Array.from(el.querySelectorAll('[data-id]')).map(r => r.getAttribute('data-id'));
            fetch(url, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': window.MATIXO.csrf,
                'Content-Type': 'application/json',
                'X-HTTP-Method-Override': 'PATCH'
              },
              body: JSON.stringify({ ids: ids })
            });
          }
        });
      });
    });
  </script>
@endpush
