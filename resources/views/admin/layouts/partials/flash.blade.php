@if(session('success') || session('error') || session('warning') || $errors->any())
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

      @if(session('success'))
        Toast.fire({
          icon: 'success',
          title: {!! json_encode(session('success')) !!}
        });
      @endif

      @if(session('error'))
        Toast.fire({
          icon: 'error',
          title: {!! json_encode(session('error')) !!}
        });
      @endif

      @if(session('warning'))
        Toast.fire({
          icon: 'warning',
          title: {!! json_encode(session('warning')) !!}
        });
      @endif

      @if($errors->any())
        Swal.fire({
          icon: 'error',
          title: 'Hata oluştu!',
          html: '<ul class="text-start mb-0 mt-2 text-muted small" style="list-style-type: disc; padding-left: 1.5rem;">@foreach($errors->all() as $err)<li>{!! addslashes(e($err)) !!}</li>@endforeach</ul>',
          confirmButtonText: 'Tamam',
          customClass: {
            confirmButton: 'btn btn-primary px-4 py-2'
          },
          buttonsStyling: false
        });
      @endif
    });
  </script>
@endif
