<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iFund</title>

    <!-- Fonts -->
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
    <header>
        <h1>iFund</h1>
    </header>
    <div class="wrapper">
        <div class="swipe-wrapper">
            <ul class="swipe-list">
                <li>8月</li>
                <li class="active">9月</li>
                <li>10月</li>
            </ul>
        </div>
        <!-- 残金額 -->
        <div class="amount-wrapper">
            <div class="amount-area">
                <p>残金額</p>
                <h2 class="amount">¥125,329</h2>
            </div>
        </div>
        <!-- リスト -->
        <div class="list-wrapper">
            <div class="list-header">
                <p>
                    <i class="fas fa-trash-alt"></i>
                    削除
                </p>
            </div>
            <ul class="list">
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥1,000</p>
                    </li>
                </div>
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥1,000</p>
                    </li>
                </div>
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥1,000</p>
                    </li>
                </div>
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥35,000</p>
                    </li>
                </div>
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥5,000</p>
                    </li>
                </div>
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥520</p>
                    </li>
                </div>
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥520</p>
                    </li>
                </div>
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥520</p>
                    </li>
                </div>
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥520</p>
                    </li>
                </div>
                <div class="list-item">
                    <p class="list-date">2022/09/03</p>
                    <li class="list-flex">
                        <div class="list-checkbox">
                            <label for="chckbox">
                                <input id="chckbox" type="checkbox">
                            </label>
                        </div>
                        <p class="list-text">献立アプリ</p>
                        <p class="list-money">¥520</p>
                    </li>
                </div>
            </ul>
        </div>

        <div class="plus-btn">
            <i class="fas fa-plus"></i>
        </div>
    </div>
</body>

</html>
