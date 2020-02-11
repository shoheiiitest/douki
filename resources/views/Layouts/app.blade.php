<!doctype html>
<html lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Bootstrap CSS -->
    {{--    <link rel="stylesheet" href="{{ asset('css/bootstrap-nico/bootstrap.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap-honoka/bootstrap.min.css') }}">

    <!-- FontAwesome cdn -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome/all.min.css') }}">

    <!-- HandsOnTable -->
    <link rel="stylesheet" href="{{ asset('css/handsontable/handsontable.full.min.css') }}">

    <title>@yield('title')</title>
    <style>
        [v-cloak] {
            display: none !important;
        }

        .handle{
            cursor:-webkit-grabbing;
        }

        .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }
            /* @yield('style') */

            #modalWrap {
                display: none;
                background: none;
                width: 100%;
                height: 100%;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 100;
                overflow: hidden;
            }

            .modalBox {
                position: fixed;
                width: 85%;
                max-width: 600px;
                height: 0;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
                overflow: hidden;
                opacity: 1;
                display: none;
                border-radius: 3px;
                z-index: 1000;
            }

            .modalInner {
                padding: 10px;
                text-align: center;
                box-sizing: border-box;
                background: rgba(23,162,184, 0.9);  
                color: #fff;
            }
    </style>
</head>
<body>
    @auth
        <div class="py-1 mt-1 mb-5 bg-info text-white">
            <h1 class="text-center pt-3">@yield('title')</h1>
            <div class="text-right">
                <span class="text-right pr-5">ユーザ名： {{ Auth::user()['name'] }}</span>
                <button onclick="location.href='/logout'" class="btn btn-dark mr-3 mb-1">ログアウト</button>
            </div>
        </div>
    @else
                        <div class="top-right links">
                    <div class="text-right">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-white m-5">新規登録</a>
                        @endif
                    </div>
            </div>
    @endauth
<div class="container">
    @yield('content')
</div>
<script type="text/javascript"  src="{{ mix('js/app.js')  }}" charset="utf-8"></script>

<!-- Bootstrap JS -->
{{--<script type="text/javascript"  src="{{ asset('js/bootstrap-nico/bootstrap.min.js')  }}" charset="utf-8"></script>--}}
<script type="text/javascript"  src="{{ asset('js/bootstrap-honoka/bootstrap.min.js')  }}" charset="utf-8"></script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>--}}
@yield('script')
</body>
</html>
