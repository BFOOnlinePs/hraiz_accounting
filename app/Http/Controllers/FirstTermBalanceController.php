<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\DocAmountModel;
use App\Models\TransferOfFirstTermAccountsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\Tr;

class FirstTermBalanceController extends Controller
{
    public function index(){
        return view('admin.setting.first_term_balance.index');
    }

    public function first_term_balance_table_ajax(Request $request){
// $data = DocAmountModel::select(
        //     'users.name', // استخدام جدول users
        //     DB::raw('COALESCE(SUM(CASE WHEN doc_amount.type = "credit" THEN doc_amount.amount ELSE 0 END), 0) AS credit'),
        //     DB::raw('COALESCE(SUM(CASE WHEN doc_amount.type = "debit" THEN doc_amount.amount ELSE 0 END), 0) AS debt'),
        //     DB::raw('COALESCE(SUM(CASE WHEN doc_amount.type = "initial_balance" THEN doc_amount.amount ELSE 0 END), 0) AS first_payment_balance'),
        //     DB::raw('COALESCE(GROUP_CONCAT(doc_amount.reference_number SEPARATOR ", "), "") AS notes')
        // )
        // ->join('users', 'doc_amount.client_id', '=', 'users.id') // تعديل العلاقة لتكون مع جدول users
        // ->groupBy('users.id', 'users.name') // إضافة users.name إلى GROUP BY
        // ->get();
        $currency = Currency::get();
        $data = DocAmountModel::select(
            'client_id',
            DB::raw('
                COALESCE(SUM(CASE WHEN doc_amount.type = "sales" OR doc_amount.type = "return_purchases" OR doc_amount.type = "performance_bond" THEN doc_amount.amount ELSE 0 END), 0) AS credit'),
            DB::raw('
                COALESCE(SUM(CASE WHEN doc_amount.type = "purchase" OR doc_amount.type = "return_sales" OR doc_amount.type = "payment_bond" THEN doc_amount.amount ELSE 0 END), 0) AS debit')
        )
        ->groupBy('client_id')
        ->whereYear('created_at', session()->get('login_date') - 1)
        ->get()
        ->map(function ($item) {
            $credit = $item->credit;
            $debit = $item->debit;

            return [
                'client' => User::where('id', $item->client_id)->first(),
                'credit' => $credit,
                'debit' => $debit,
                'balance' => round($credit - $debit, 0),
            ];
        });
        return response()->json([
            'success' => 'true',
            'view' => view('admin.setting.first_term_balance.ajax.first_term_balance',['data'=>$data , 'currency'=>$currency])->render()
        ]);
    }

    // انشاء او تعديل رصيد اول المدة
    public function update_first_term_balance_ajax(Request $request){
        $year = session()->get('login_date');
        $data = DocAmountModel::createOrFirst([
            'created_at' => $year . '-01-01 00:00:00',
            'type' => 'start_period_balance',
            'client_id' => $request->client_id
        ],[
            'amount' => $request->value,
            'currency' => $request->currency_id
        ]);
        $data->save();
        return response()->json([
            'success' => 'true',
            'message' => 'تم التحديث بنجاح'
        ]);
    }
}
