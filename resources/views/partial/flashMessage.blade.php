@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has($msg))
    <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    <script>
        /*slide up after 15 seconds*/
        //$('.alert').delay(15000).slideUp();
        //added by Mahyar Ansary - fades alert after 10 seconds
        setTimeout(function(){$('.alert').fadeOut()},10000);
    </script>
    @endif
@endforeach