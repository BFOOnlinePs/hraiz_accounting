<?php

namespace App\Http\Controllers;

use App\Models\CashPaymentsModel;
use App\Models\DocAmountModel;
use App\Models\OrderModel;
use App\Models\PriceOffersModel;
use App\Models\ProducationLinesModel;
use App\Models\ProductionOrdersModel;
use App\Models\ProductModel;
use App\Models\TasksModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $order_count = OrderModel::count();
        $product_count = ProductModel::count();
        $supplier_count = User::whereJsonContains('user_role',['4'])->count();
        $task_count = TasksModel::count();
        $data = OrderModel::join('price_offers', 'price_offers.order_id', '=', 'orders.id')->where('orders.order_status' ,'!=', -1)->take(5)->orderBy('orders.id', 'desc')->get();
        foreach ($data as $key) {
            $key->user = User::where('id', $key->user_id)->first();
            $carbonDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $key->created_at);
            $key->created_at = $carbonDate->format('Y-m-d');
            $key->supplier = PriceOffersModel::where('order_id', $key->order_id)->get();
            foreach ($key->supplier as $child) {
                $child->name = User::select('name')->where('id', $child->supplier_id)->first();
            }
        }

        $production_orders = ProductionOrdersModel::where('employee_id',auth()->user()->id)->get();
        foreach ($production_orders as $key){
            $key->production_lines = ProducationLinesModel::where('id',$key->production_line_id)->first();
            $key->user = User::where('id',$key->employee_id)->first();
        }


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
                    'first_term_balance' => DocAmountModel::where('type','start_period_balance')->whereYear('created_at',session()->get('login_date'))->where('client_id', $item->client_id)->orderBy('id','desc')->first(),
                ];
            });

        return view('admin.home', ['data' => $data,'order_count'=>$order_count,'product_count'=>$product_count,'supplier_count'=>$supplier_count,'task_count'=>$task_count,'production_orders'=>$production_orders]);
    }
}
