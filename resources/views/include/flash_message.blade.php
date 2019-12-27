<link rel="stylesheet" href="{{ asset('vendor/manthra/css/toastr.min.css') }}">
<script src="{{ asset('vendor/manthra/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/manthra/js/toastr.min.js') }}"></script>
<script>
  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    var timeout = "{{ config('laravelmanthra.clear_message') }}"
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
  @endif
</script>
