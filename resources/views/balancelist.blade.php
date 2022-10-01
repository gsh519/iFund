<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iFund</title>

    <!-- Fonts -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div id="app">
        <header>
            <h1>
                <a href="{{ route('home') }}" style="width: 100%; display: block; color: #fff;">
                    iFund
                </a>
            </h1>
        </header>
        <div class="wrapper">

            <h2 style="color: #666; text-align:center; padding: 20px 10px 10px;">残金額設定</h2>

            <div style="text-align: left; padding: 0 24px 0">
                <a class="back-btn" href="{{ route('home') }}">戻る</a>
            </div>

            <div class="date-wrapper" style="padding: 0 0 10px 0;">
                <div class="date-previous">
                    <a style="display: flex; width: 100%; justify-content: center; color: var(--main-color);" href="{{ route('balance.list', ['balance_year' => $balance_year - 1])}}">
                        <i class="fas fa-angle-left"></i>
                    </a>
                </div>
                <div class="date-content">{{ $balance_year }}年</div>
                <div class="date-next">
                    <a style="display: flex; width: 100%; justify-content: center; color: var(--main-color);" href="{{ route('balance.list', ['balance_year' => $balance_year + 1])}}">
                        <i class="fas fa-angle-right"></i>
                    </a>
                </div>
            </div>

            <div class="list-wrapper">

                @if (!empty($calendars))
                <ul class="list">
                    <!-- 支出リストループ -->
                    @foreach ($calendars as $calendar)
                    @if (($calendar == $today_month) && ($today_year == $balance_year))
                    <li class="list-item active">
                        <a href="{{ route('balance.create', ['balance_year' => $balance_year, 'balance_month' => $calendar]) }}" style="display:block; padding: 20px;">
                            <div>
                                <p style="font-size: 28px; font-weight: bold; color: #555; text-align: center;">{{ $calendar }}月</p>
                            </div>
                        </a>
                    </li>
                    @else
                    <li class="list-item">
                        <a href="{{ route('balance.create', ['balance_year' => $balance_year, 'balance_month' => $calendar]) }}" style="display:block; padding: 20px;">
                            <div>
                                <p style="font-size: 28px; font-weight: bold; color: #555; text-align: center;">{{ $calendar }}月</p>
                            </div>
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
                @endif

            </div>

        </div>
    </div>
</body>

</html>

<script>
    const app = new Vue({
        el: '#app',
        data: {},
        methods: {}
    });
</script>
