<!doctype html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('css/bootstrap-nico/bootstrap.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap-honoka/bootstrap.min.css') }}">
    <!-- Bootstrap CSS -->
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}

    <!-- FontAwesome cdn -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- HandsOnTable -->
    <link rel="stylesheet" href="{{ asset('css/handsontable/handsontable.full.min.css') }}">

    <title>@yield('title')</title>
    <style>
        [v-cloak] {
            display: none !important;
        }
        @yield('style')
        @yield('css')
    </style>
</head>
<body>
<div class="py-3 mt-3 mb-5 bg-info text-white">
    <h1 class="text-center">@yield('title')</h1>
</div>
<div class="container">
    @yield('content')
</div>
<script type="text/javascript"  src="{{ mix('js/app.js')  }}" charset="utf-8"></script>
{{--<script type="text/javascript"  src="{{ asset('js/bootstrap-nico/bootstrap.min.js')  }}" charset="utf-8"></script>--}}
<script type="text/javascript"  src="{{ asset('js/bootstrap-honoka/bootstrap.min.js')  }}" charset="utf-8"></script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>--}}
{{--<script type="text/javascript"  src="{{ asset('js/handsontable/handsontable.full.min.js')  }}" charset="utf-8"></script>--}}
@yield('script')
</body>
</html>
