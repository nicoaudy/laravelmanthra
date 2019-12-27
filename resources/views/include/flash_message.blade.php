<link rel="stylesheet" href="{{ asset('vendor/manthra/css/toastr.min.css') }}">
<script src="{{ asset('vendor/manthra/js/toastr.min.js') }}"></script>
<script>
  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}", {timeOut: config('laravelmanthra.clear_message')});
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}", {timeOut: config('laravelmanthra.clear_message')});
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}", {timeOut: config('laravelmanthra.clear_message')});
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}", {timeOut: config('laravelmanthra.clear_message')});
            break;
    }
  @endif
</script>
