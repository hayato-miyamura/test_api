<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Test_Api') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script type="text/javascript" src="//code.jquery.com/jquery-3.5.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/ja.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        // 価格にカンマをいれる
        $('.item_price').each(function() {
            $(this).html(addFigure($(this).html()));
        });

        function addFigure(str) {
            var num = new String(str).replace(/,/g, "");
            while (num != (num = num.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
            return num;
        }

        // 編集モーダルの表示
        $('.editbtn').on('click', function() {
            $('#edit_item_modal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#id').val(data[0]);
            $('#title').val(data[1]);
            $('#description').val(data[3]);
            $('#price').val(data[4].replace("円", "").replace(",", ""));
        });

        // POSTリクエスト
        $('#addItem').on('submit', function(e) {
            e.preventDefault();

            var title = $('#add_title').val();
            var image = $('#add_image').val();
            var description = $('#add_description').val();
            var price = $('#add_price').val();

            const formData = new FormData($('#addItem').get(0));

            formData.append('title', title);
            formData.append('image', image);
            formData.append('description', description);
            formData.append('price', price);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                type: "POST",
                url: "/item",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#add_item_modal').modal('hide');
                    alert("商品データの保存に成功しました");
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                    alert("商品データの保存に失敗しました");
                }
            });
        });

        // PUTリクエスト
        $('#editItem').on('submit', function(e) {
            e.preventDefault();

            var id = $('#id').val();
            var title = $('#title').val();
            var image = $('#image').val();
            var description = $('#description').val();
            var price = $('#price').val();

            const formData = new FormData($('#editItem').get(0));

            formData.append('title', title);
            formData.append('image', image);
            formData.append('description', description);
            formData.append('price', price);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                type: "POST",
                url: "/item/" + id,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#edit_item_modal').modal('hide');
                    alert("アップデートに成功しました");
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                    alert("アップデートに失敗しました");
                }
            });
        });

        // DELETEリクエスト
        $('.deletebtn').on('click', function() {

            var deleteConfirm = confirm('本当に削除しますか？');

            if (deleteConfirm == true) {
                var id = $(this).closest('tr').find('#item_id').text();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: "POST",
                    url: "/item/" + id,
                    data: {
                        'id': id,
                        '_method': 'DELETE'
                    },
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        alert("削除に成功しました");
                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                        alert("削除に失敗しました");
                    }
                });
            };
        });

    });
</script>

</html>