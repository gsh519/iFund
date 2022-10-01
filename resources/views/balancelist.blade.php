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
                <div @click="fetchBalance(show_date.getFullYear(), show_date.getMonth() - 1)" class="date-previous">
                    <i class="fas fa-angle-left"></i>
                </div>
                <div class="date-content">{{ $balance_year }}年</div>
                <div @click="fetchBalance(show_date.getFullYear(), show_date.getMonth() + 1)" class="date-next"><i class="fas fa-angle-right"></i></div>
            </div>

            <div class="list-wrapper">

                <ul class="list">

                    <template v-for="calendar in calendars">
                        <li class="list-item" :class='{ "active": todayMonth === calendar }'>
                            <a href="{{ route('balance.create') }}" style="display:block; padding: 20px;">
                                <div>
                                    <p style="font-size: 28px; font-weight: bold; color: #555; text-align: center;">@{{ calendar }}月</p>
                                </div>
                            </a>
                        </li>
                    </template>
                </ul>

                <!-- @if ($balances->isNotEmpty()) -->
                <!-- <ul class="list"> -->
                <!-- 支出リストループ -->
                <!-- @foreach ($balances as $balance) -->
                <!-- <li class="list-item">
                        <a href="{{ route('balance.create', ['balance_year' => $balance->balance_year, 'balance_month' => $balance->balance_month]) }}" style="display:block; padding: 20px;">
                            <div>
                                <p style="font-size: 28px; font-weight: bold; color: #555; text-align: center;">{{ $balance->balance_month }}月</p>
                            </div>
                        </a>
                    </li> -->
                <!-- @endforeach -->
                <!-- </ul> -->
                <!-- @endif -->
            </div>

        </div>
    </div>
</body>

</html>

<script>
    const app = new Vue({
        el: '#app',
        data: {
            calendars: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
            today: null,
            todayMonth: null,
        },
        mounted() {
            this.getToday();
        },
        methods: {
            getToday() {
                let today = new Date();
                this.today = today;
                this.todayMonth = today.getMonth() + 1;
            }
        }
    });
</script>
