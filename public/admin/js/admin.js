/**
 * MATIXO Admin Panel — Vanilla JS
 */
(function () {
  'use strict';

  // CSRF token for AJAX
  window.MATIXO = window.MATIXO || {};
  window.MATIXO.csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

  document.addEventListener('DOMContentLoaded', function () {
    initSidebar();
    initAutoDismissAlerts();
    initConfirmDelete();
    initTableRowClick();
  });

  function initSidebar() {
    var toggle    = document.getElementById('sidebarToggle');
    var sidebar   = document.getElementById('adminSidebar');
    var closeBtn  = document.getElementById('sidebarClose');
    var backdrop  = document.getElementById('sidebarBackdrop');

    if (!sidebar) return;

    function open() {
      sidebar.classList.add('show');
      backdrop && backdrop.classList.add('show');
    }
    function close() {
      sidebar.classList.remove('show');
      backdrop && backdrop.classList.remove('show');
    }

    toggle && toggle.addEventListener('click', open);
    closeBtn && closeBtn.addEventListener('click', close);
    backdrop && backdrop.addEventListener('click', close);
  }

  function initAutoDismissAlerts() {
    setTimeout(function () {
      document.querySelectorAll('.alert.alert-success, .alert.alert-info').forEach(function (el) {
        var alert = bootstrap.Alert.getOrCreateInstance(el);
        if (alert) alert.close();
      });
    }, 5000);
  }

  function initConfirmDelete() {
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
      el.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var msg = el.getAttribute('data-confirm') || 'Bu işlemi yapmak istediğinizden emin misiniz?';

        if (typeof Swal !== 'undefined') {
          Swal.fire({
            title: 'Emin misiniz?',
            text: msg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, Devam Et',
            cancelButtonText: 'Vazgeç',
            customClass: {
              confirmButton: 'btn btn-danger px-4 py-2 me-2',
              cancelButton: 'btn btn-secondary px-4 py-2'
            },
            buttonsStyling: false
          }).then(function (result) {
            if (result.isConfirmed) {
              var form = el.closest('form');
              if (form) {
                // Remove listener temporary and submit to prevent infinite loop
                form.submit();
              } else if (el.tagName === 'A') {
                window.location.href = el.getAttribute('href');
              }
            }
          });
        } else {
          if (confirm(msg)) {
            var form = el.closest('form');
            if (form) {
              form.submit();
            } else if (el.tagName === 'A') {
              window.location.href = el.getAttribute('href');
            }
          }
        }
      });
    });
  }

  function initTableRowClick() {
    document.querySelectorAll('tr[data-href]').forEach(function (row) {
      row.style.cursor = 'pointer';
      row.addEventListener('click', function (e) {
        if (e.target.closest('a,button,input,form')) return;
        window.location.href = row.getAttribute('data-href');
      });
    });
  }

  /**
   * Quill editor instance helper.
   * Usage: <textarea data-quill> ...html... </textarea>
   */
  window.MATIXO.initQuill = function () {
    if (typeof Quill === 'undefined') return;
    document.querySelectorAll('[data-quill]').forEach(function (textarea) {
      if (textarea.dataset.quillInit === '1') return;

      var name = textarea.getAttribute('name');
      var toolbar = textarea.getAttribute('data-toolbar') === 'simple'
        ? [['bold', 'italic', 'underline'], ['link'], [{ list: 'ordered' }, { list: 'bullet' }]]
        : [
            [{ header: [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ color: [] }, { background: [] }],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            ['clean']
          ];

      var div = document.createElement('div');
      div.innerHTML = textarea.value;
      textarea.style.display = 'none';
      textarea.parentNode.insertBefore(div, textarea);

      var quill = new Quill(div, {
        theme: 'snow',
        modules: { toolbar: toolbar },
        placeholder: textarea.getAttribute('placeholder') || ''
      });

      quill.on('text-change', function () {
        textarea.value = quill.root.innerHTML;
      });

      textarea.dataset.quillInit = '1';
    });
  };
})();
