<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iFund</title>

    <!-- Fonts -->
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
                    <h2 class="amount" ref="amount">¥125,329</h2>
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
                <ul class="list" ref="list">
                    <li class="list-item">
                        <p class="list-date">2022/09/03</p>
                        <div class="list-flex">
                            <div class="list-checkbox">
                                <input id="checkbox" class="checkbox" type="checkbox">
                                <label for="checkbox"></label>
                            </div>
                            <p class="list-text">献立アプリ</p>
                            <p class="list-money">¥1,000</p>
                        </div>
                    </li>
                    <li class="list-item">
                        <p class="list-date">2022/09/03</p>
                        <div class="list-flex">
                            <div class="list-checkbox">
                                <input id="checkbox" class="checkbox" type="checkbox">
                                <label for="checkbox"></label>
                            </div>
                            <p class="list-text">献立アプリ</p>
                            <p class="list-money">¥1,000</p>
                        </div>
                    </li>
                    <li class="list-item">
                        <p class="list-date">2022/09/03</p>
                        <div class="list-flex">
                            <div class="list-checkbox">
                                <input id="checkbox" class="checkbox" type="checkbox">
                                <label for="checkbox"></label>
                            </div>
                            <p class="list-text">献立アプリ</p>
                            <p class="list-money">¥1,000</p>
                        </div>
                    </li>

                    <!-- クローン用 -->
                    <li class="list-item" ref="list-item">
                        <p class="list-date">2022/09/03</p>
                        <div class="list-flex">
                            <div class="list-checkbox">
                                <input id="checkbox" class="checkbox" type="checkbox">
                                <label for="checkbox"></label>
                            </div>
                            <p class="list-text" ref="list-text"></p>
                            <p class="list-money" ref="list-money"></p>
                        </div>
                    </li>

                </ul>
            </div>

            <div class="plus-btn" @click="showCreateInput">
                <i class="fas fa-plus"></i>
            </div>
            <div class="input-area" v-if="plus_btn_flag">
                <div class="input-area-wrapper">
                    <!-- テキスト -->
                    <div class="input-head">
                        <p class="info">支出の入力</p>
                        <div class="xmark" @click="close"><i class="fas fa-times"></i></div>
                    </div>
                    <div class="payment">
                        <p class="payment-text">メモ</p>
                        <div class="payment-input">
                            <input type="text" v-model="memo" required>
                        </div>
                    </div>
                    <div class="payment">
                        <p class="payment-text">支出</p>
                        <div class="payment-input">
                            <input type="number" v-model="payment" required>
                        </div>
                    </div>

                    <div class="store-btn" @click="store">
                        <button>
                            保存
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    const app = new Vue({
        el: '#app',
        data: {
            plus_btn_flag: false,
            memo: '',
            payment: '',
            list_text: '',
            list_money: '',
        },
        mounted() {},
        methods: {
            showCreateInput() {
                this.plus_btn_flag = true;
            },
            close() {
                this.plus_btn_flag = false;
            },
            store() {
                if (this.memo === '' || this.payment === '' || this.payment === '0') {
                    return;
                }
                // リストに値セット
                this.list_text = this.memo;
                this.list_money = this.payment;
                this.$refs['list-text'].textContent = this.list_text;
                this.$refs['list-money'].textContent = '¥' + parseInt(this.list_money, 10).toLocaleString();
                let clone = this.$refs['list-item'].cloneNode(true);
                this.$refs['list'].prepend(clone);

                // 残金額を再計算
                let amount = parseInt(this.$refs['amount'].textContent.split('¥')[1].replace(/,/g, ''), 10);
                let payment = parseInt(this.list_money, 10);
                let balance = amount - payment;
                this.$refs['amount'].textContent = '¥' + balance.toLocaleString();

                // リセット
                this.list_text = '';
                this.list_money = '';
                this.memo = '';
                this.payment = '';
            },
        }
    });
</script>
