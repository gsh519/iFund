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

            <div style="text-align: left; padding: 16px 24px 0">
                <a class="back-btn" href="{{ route('home') }}">戻る</a>
            </div>

            <!-- 残金額 -->
            <div class="amount-wrapper">
                <h2 style="text-align: center; margin-bottom: 20px;">{{ $today_year }}年{{ $next_month }}月</h2>
                <form action="{{ route('balance.create') }}" method="post">
                    @csrf
                    <input type="hidden" name="year" value="{{ $today_year }}">
                    <input type="hidden" name="month" value="{{ $next_month }}">
                    <div class="amount-area">
                        <label>残金額</label>
                        <input type="number" name="balance_value" value="{{ $balance->current_value }}">
                    </div>
                    <div class="button-area" style="margin-top: 16px;">
                        <button type="submit">
                            設定
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script>
</script>
