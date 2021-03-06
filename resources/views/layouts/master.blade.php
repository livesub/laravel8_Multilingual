<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <title>dev_laravel8Ver</title>
</head>
<body>

<script src='//code.jquery.com/jquery-3.3.1.min.js'></script>

<script>
    function multi_lang()
    {
        var multilingual = $('#multi_lang').val();
        location.href = '{{ url('multilingual') }}/'+multilingual;
    }
</script>

    <div class='form-group'>
        <select name='multi_lang' id='multi_lang' onchange='multi_lang();'>
            <option value='kr'
            @if(Session::get('multi_lang') == '' || Session::get('multi_lang') == 'kr')
                selected
            @endif
            >Korea</option>
            <option value='en'
            @if(Session::get('multi_lang') == 'en')
                selected
            @endif
            >Englsh</option>
        </select>
    </div>

    <div class='form-group'>
    @if(!auth()->user())
        <a href='{{ route('login.index') }}'>LOGIN</a>
    @else
       <a href='{{ route('mypage.index') }}'>MYPAGE</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='{{ route('logout.destroy') }}'>LOGOUT</a>
    @endif
    </div>



    {{-- 각 내용 뿌리기 --}}
    @yield('content')







    {{-- alert_messages Error --}}
    @if (Session::has('alert_messages'))
    <script>
        alert('{!! Session::get('alert_messages') !!}');
    </script>
    @endif

</body>
</html>
