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

            <div class="date-wrapper">
                <div @click="fetchBalance(show_date.getFullYear(), show_date.getMonth() - 1)" class="date-previous">
                    <i class="fas fa-angle-left"></i>
                </div>
                <div class="date-content">@{{ date_display }}</div>
                <div @click="fetchBalance(show_date.getFullYear(), show_date.getMonth() + 1)" class="date-next"><i class="fas fa-angle-right"></i></div>
            </div>
            <!-- <div class="swipe-wrapper">
                <ul class="swipe-list">
                    <li v-for="calendar in calendars" :class="{ 'active' : isThisMonth(calendar) }" @click="fetchBalance(calendar)">@{{ calendar.month }}月</li>
                </ul>
            </div> -->

            <div style="text-align: right; padding: 0 24px">
                <a href="{{ route('balance.create') }}" style="font-weight: bold; color: var(--main-color);">予算設定</a>
            </div>

            <template v-if="message">
                <p style="text-align: center; margin-top: 40px; font-size: 30px;">@{{ message }}</p>
            </template>
            <template v-else>
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
                            @{{ this.show_date.getMonth() + 1 }}月の支出がありません
                        </div>
                    </template>
                </div>
            </template>

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
                        <p class="payment-text">日付</p>
                        <div class="payment-input">
                            <input type="date" v-model="payment_date" required class="date">
                        </div>
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
            // 初期値
            balance: null,
            payments: [],
            plus_btn_flag: false,
            message: null,
            payment_id: null,
            today: null,
            show_date: new Date(),

            // 送信用値セット
            memo: '',
            payment: '',
            payment_date: null,

            // 削除対象支出
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
            date_display() {
                return `${this.show_date.getFullYear()}年${this.show_date.getMonth() + 1}月`;
            },
        },
        methods: {
            showCreateInput() {
                this.payment_date = this.getInputDate();
                this.plus_btn_flag = true;
            },
            close() {
                this.memo = '';
                this.payment = '';
                this.payment_date = null;
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
            fetchBalance(payload_year = null, payload_month = null) {
                // 日付を渡したい
                let year = (payload_year === null) ? this.today.getFullYear() : payload_year;
                let month = (payload_month === null) ? this.today.getMonth() + 1 : payload_month + 1;

                axios.get('/balance', {
                    params: {
                        year: year,
                        month: month,
                    }
                }).then(res => {
                    if (Object.keys(res.data).length === 0) {
                        this.message = 'データがありません';
                        this.show_date = new Date(payload_year ?? this.today.getFullYear(), payload_month ?? this.today.getMonth());
                    } else {
                        this.message = null;
                        this.show_date = new Date(res.data.balance_year, res.data.balance_month - 1);
                    }
                    this.balance = res.data;
                    this.payments = res.data.payments;
                }).catch(err => {});
            },

            /**
             *  支出保存処理 payment_idがある場合は更新　なければ新規作成
             */
            store(payment_id) {
                // バリデーション
                if (
                    this.memo === '' ||
                    this.payment === '' ||
                    this.payment === '0' ||
                    this.payment_date === null
                ) {
                    return;
                }

                // 更新処理
                if (payment_id) {
                    // 残金額の再計算
                    let update_payment_index = this.payments.findIndex(payment => payment.payment_id === payment_id);
                    this.balance.current_value += this.payments[update_payment_index].value;

                    // 値の更新
                    this.payments[update_payment_index].memo = this.memo;
                    this.payments[update_payment_index].value = Number(this.payment);
                    this.payments[update_payment_index].payment_date = this.payment_date;
                    this.balance.current_value -= this.payment;

                    // リセット
                    let store_payment = this.payment;
                    let store_memo = this.memo;
                    let store_payment_date = this.payment_date;
                    this.memo = '';
                    this.payment = '';
                    this.payment_date = null;

                    this.updatePayment(store_payment, store_memo, store_payment_date);
                } else { // 新規作成処理
                    // リストに値セット
                    let payment_obj = {
                        value: Number(this.payment),
                        memo: this.memo,
                        payment_date: this.payment_date,
                    };
                    this.payments.unshift(payment_obj);

                    // 残金額を再計算
                    this.balance.current_value -= this.payment;

                    // リセット
                    let store_payment = this.payment;
                    let store_memo = this.memo;
                    let store_payment_date = this.payment_date;
                    this.memo = '';
                    this.payment = '';
                    this.payment_date = null;

                    this.savePayment(store_payment, store_memo, store_payment_date);
                }
                this.plus_btn_flag = false;
            },
            // データベースに保存
            savePayment(payment, memo, payment_date) {
                console.log(payment_date);
                axios.post('/payment/create', {
                    memo: memo,
                    value: payment,
                    payment_date: payment_date,
                }).then(res => {
                    this.fetchBalance(res.data.balance_year, res.data.balance_month - 1);
                }).catch(err => {});
            },

            /**
             * 支出編集処理
             */
            updateCheckedPayment(payment) {
                this.plus_btn_flag = true;
                this.memo = payment.memo;
                this.payment = payment.value;
                this.payment_date = payment.payment_date;
                this.payment_id = payment.payment_id;
            },
            updatePayment(payment, memo, payment_date) {
                axios.post(`/payment/${this.payment_id}/update`, {
                        memo: memo,
                        value: payment,
                        payment_date: payment_date,
                    })
                    .then(res => {
                        this.fetchBalance(res.data.balance_year, res.data.balance_month - 1);
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
                        // idが一致しなかったやつが削除対象
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
                let dt = new Date();
                let y = dt.getFullYear();
                let m = ('00' + (dt.getMonth() + 1)).slice(-2);
                let d = ('00' + dt.getDate()).slice(-2)
                return y + '-' + m + '-' + d;
            },
        }
    });
</script>
