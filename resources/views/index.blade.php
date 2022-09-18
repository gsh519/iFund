<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iFund</title>

    <!-- Fonts -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
                    <h2 class="amount" ref="amount" v-if="balance">¥@{{ current_value }}</h2>
                </div>
            </div>
            <div class="list-wrapper">
                <template v-if="payments.length">
                    <div class="list-header">
                        <p @click="deleteCheckedPayments">
                            <i class="fas fa-trash-alt"></i>
                            削除
                        </p>
                    </div>
                    <ul class="list" ref="list">
                        <!-- 支出リストループ -->

                        <li v-for="payment in payments" class="list-item">
                            <p class="list-date">@{{ payment_date_format(payment.payment_date) }}</p>
                            <div class="list-flex">
                                <div class="list-checkbox">
                                    <input class="checkbox" type="checkbox" :value="payment" v-model="checkedPayments">
                                    <label for="checkbox"></label>
                                </div>
                                <div class="list-content" @click="updateCheckedPayment(payment)">
                                    <p class="list-text">@{{ payment.memo }}</p>
                                    <p class="list-money">¥@{{ payment_value(payment.value) }}</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </template>
                <template v-else>
                    <div class="list-header" style="text-align: center;">
                        今月の支出がありません
                    </div>
                </template>
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

                    <div class="store-btn" @click="store(payment_id)">
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
            payment_id: null,
            today: null,

            // 初期値
            balance: null,
            payments: [],

            checkedPayments: [],
        },
        mounted() {
            this.getToday();
            this.fetchBalance();
        },
        computed: {
            current_value() {
                return this.balance.current_value.toLocaleString();
            },
        },
        methods: {
            showCreateInput() {
                this.plus_btn_flag = true;
            },
            close() {
                this.plus_btn_flag = false;
            },

            /**
             *  初期値セット
             */

            /**
             * 表示関連
             */
            payment_date_format(date) {
                return date.replace(/-/g, '/'); // ハイフンをスラッシュに変更して表示
            },
            payment_value(value) {
                return value.toLocaleString();
            },

            /**
             * 残金額・予算の取得
             */
            fetchBalance() {
                axios.get('/balance').then(res => {
                    this.balance = res.data;
                    this.payments = res.data.payments;
                }).catch(err => {});
            },

            /**
             *  支出保存処理 payment_idがある場合は更新　なければ新規作成
             */
            store(payment_id) {
                // バリデーション
                if (this.memo === '' || this.payment === '' || this.payment === '0') {
                    return;
                }

                // 更新処理
                if (payment_id) {
                    // 残金額の再計算
                    let update_payment_index = this.payments.findIndex(payment => payment.payment_id === payment_id);
                    this.balance.current_value += this.payments[update_payment_index].value;

                    // 値の更新
                    this.payments[update_payment_index].memo = this.memo;
                    this.payments[update_payment_index].value = this.payment;
                    this.balance.current_value -= this.payment;

                    // リセット
                    let store_payment = this.payment;
                    let store_memo = this.memo;
                    this.memo = '';
                    this.payment = '';

                    this.updatePayment(store_payment, store_memo);
                } else { // 新規作成処理
                    // リストに値セット
                    let payment_obj = {
                        value: this.payment,
                        memo: this.memo,
                        payment_date: this.getInputDate(),
                    };
                    this.payments.unshift(payment_obj);

                    // 残金額を再計算
                    this.balance.current_value -= this.payment;

                    // リセット
                    let store_payment = this.payment;
                    let store_memo = this.memo;
                    this.memo = '';
                    this.payment = '';

                    this.savePayment(store_payment, store_memo);
                }
            },
            // データベースに保存
            savePayment(payment, memo) {
                axios.post('/payment/create', {
                    memo: memo,
                    value: payment,
                    year: this.getTodayYear(),
                    month: this.getTodayMonth(),
                }).then(res => {
                    this.fetchBalance();
                }).catch(err => {});
            },

            /**
             * 支出編集処理
             */
            updateCheckedPayment(payment) {
                console.log(payment);
                this.plus_btn_flag = true;
                this.memo = payment.memo;
                this.payment = payment.value;
                this.payment_id = payment.payment_id;
            },
            updatePayment(payment, memo) {
                axios.post(`/payment/${this.payment_id}/update`, {
                        memo: memo,
                        value: payment,
                        year: this.getTodayYear(),
                        month: this.getTodayMonth(),
                    })
                    .then(res => {
                        this.fetchBalance();
                        this.payment_id = null;
                    }).catch(err => {});
            },

            /**
             * 支出削除処理
             */
            deleteCheckedPayments() {
                let checked_payment_ids = [];

                this.checkedPayments.forEach((checked_payment) => {
                    this.payments = this.payments.filter((payment) => {
                        // idが一致したやつを取り除く
                        return payment.payment_id !== checked_payment.payment_id;
                    });

                    checked_payment_ids.push(checked_payment.payment_id);
                });

                this.recaluculateBalance(this.checkedPayments);
                this.deletePayments(checked_payment_ids);
                checked_payment_ids.splice(0);
                this.checkedPayments.splice(0);
            },
            recaluculateBalance(delete_payments) {
                delete_payments.forEach((payment) => {
                    this.balance.current_value = Number(this.balance.current_value) + Number(payment.value);
                });
            },
            deletePayments(delete_payments) {
                axios.post('/payment/delete', {
                        delete_payments: delete_payments,
                    })
                    .then(res => {}).catch(err => {});
            },

            /**
             * 日付関連
             */
            getToday() {
                let today = new Date();
                this.today = today;
            },
            getTodayYear() {
                return this.today.getFullYear();
            },
            getTodayMonth() {
                return this.today.getMonth() + 1;
            },
            getInputDate() {
                let year = this.today.getFullYear();
                let month = this.today.getMonth() + 1;
                let date = this.today.getDate();

                return year + '/' + month + '/' + date;
            }
        }
    });
</script>
