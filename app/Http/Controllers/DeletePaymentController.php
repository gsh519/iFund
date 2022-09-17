<?php

namespace App\Http\Controllers;

use App\UseCases\DeletePayment;
use Illuminate\Http\Request;

class DeletePaymentController extends Controller
{
    public function delete(Request $request, DeletePayment $DeletePayment)
    {
        // リクエストのバリデーション

        // 削除処理
        $DeletePayment($request->delete_payments);
    }
}
