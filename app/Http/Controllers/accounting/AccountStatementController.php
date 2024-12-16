<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\BondsModel;
use App\Models\DocAmountModel;
use App\Models\InvoiceItemsModel;
use App\Models\PriceOfferItemsModel;
use App\Models\PriceOfferSalesItemsModel;
use App\Models\PriceOfferSalesModel;
use App\Models\PurchaseInvoicesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class AccountStatementController extends Controller
{
    public function customer_account_statement_index(){
        return view('admin.accounting.account_statement.customer_account_statement_index');
    }

    public function list_customers_table_ajax(Request $request){
//        $data = User::whereJsonContains('user_role','10')->when($request->filled('search_input'),function ($query) use ($request){
//            $query->where('name','like','%'.$request->search_input.'%')->get();
//        })->get();
        $query = User::query();
        if($request->filled('search_input')){
            $query->where('name','like','%'.$request->search_input.'%');
        }
        if ($request->radio_user == 'customer'){
            $query->whereJsonContains('user_role','10')->when($request->filled('search_input'),function ($query) use ($request){
                $query->where('name','like','%'.$request->search_input.'%')->get();
            });
        }
        if($request->radio_user == 'supplier'){
            $query->whereJsonContains('user_role','4')->when($request->filled('search_input'),function ($query) use ($request){
                $query->where('name','like','%'.$request->search_input.'%')->get();
            });
        }
        if (($request->radio_user != 'supplier') && ($request->radio_user != 'customer')) {
            $query->where(function($query) {
                $query->whereJsonContains('user_role', '10')
                      ->orWhereJsonContains('user_role', '4');
            });
        }
        $data = $query->paginate(10);
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.account_statement.ajax.list_customers_table',['data'=>$data])->render()
        ]);
    }

    public function account_statement_details($id,$user_type){
        $user = User::find($id);
        return view('admin.accounting.account_statement.account_statement_details',['user'=>$user,'user_type'=>$user_type]);
    }

//    public function account_statement_details_table_ajax(Request $request){
//        $invoicesQuery = DB::table('bfo_invoices as invoices')
//            ->select('invoices.id as i_id', 'invoices.client_id', 'invoices.created_at', 'invoices.invoice_type', DB::raw('"invoices" as type'), DB::raw('NULL as amount'))
//            ->where('invoices.client_id', $request->user_id)
//            ->selectSub(function ($query) {
//                $query->selectRaw('SUM(rate * quantity)')
//                    ->from('bfo_invoice_items')
//                    ->whereColumn('bfo_invoice_items.invoice_id', 'invoices.id');
//            }, 'total_rate');
//
//        $bondsQuery = DB::table('bonds')
//            ->select('bonds.invoice_id as i_id', 'bonds.amount as total_rate', 'bonds.invoice_type', DB::raw('"bonds" as type'), 'bonds.created_at')
//            ->whereIn('bonds.invoice_id', function ($query) use ($request) {
//                $query->select('invoices.id')
//                    ->from('bfo_invoices as invoices')
//                    ->whereIn('invoices.client_id', function ($query) use ($request) {
//                        $query->select('users.id')
//                            ->from('users')
//                            ->where('users.id', $request->user_id);
//                    });
//            });
//
//        $returnsQuery = DB::table('return_items')
//            ->select('return_items.*','return_items.id as i_id', DB::raw('"returns" as invoice_type'))
//            ->whereIn('return_items.invoice_id', function ($query) use ($request){
//                $query->select('returns.id')
//                    ->from('returns')
//                    ->whereIn('returns.invoice_id', function ($query) use ($request){
//                        $query->select('invoices.id')
//                            ->from('bfo_invoices as invoices')
//                            ->where('invoices.client_id', $request->user_id);
//                    });
//            });
//
//        $invoicesResult = $invoicesQuery->get();
//        $bondsResult = $bondsQuery->get();
//        $returnsResult = $returnsQuery->get();
//
//        $data = $invoicesResult->concat($bondsResult)->concat($returnsResult);
//        if (!empty($request->from) && !empty($request->to)) {
//            // Apply filtering logic only when both $request->from and $request->to are not empty
//            $data = $data->filter(function ($item) use ($request) {
//                // Get created_at value, use a default date if it's null
//                $createdAt = $item->created_at ?? now();
//
//                // Modify the condition as per your requirement
//                return $createdAt >= $request->from && $createdAt <= $request->to;
//            });
//        }
//
//        $invoicesQuery = DB::table('bfo_invoices')
//            ->select('invoice_type', DB::raw('COUNT(*) as count'))
//            ->where('client_id', $request->user_id)
//            ->groupBy('invoice_type')
//            ->get();
//
//        $bondsQuery = DB::table('bonds')
//            ->select('invoice_type', DB::raw('COUNT(*) as count'))
//            ->whereIn('invoice_id', function ($query) use ($request) {
//                $query->select('id')
//                    ->from('bfo_invoices')
//                    ->whereIn('client_id', function ($query) use ($request) {
//                        $query->select('id')
//                            ->from('users')
//                            ->where('id', $request->user_id);
//                    });
//            })
//            ->groupBy('invoice_type')
//            ->get();
//
//        $invoiceCounts = $invoicesQuery->concat($bondsQuery);
//
//        if (!empty($data)) {
//            $data = $data->sortBy('created_at')->values()->all();
//        }
//
//        return response()->json([
//            'success' => 'true',
//            'view' => view('admin.accounting.account_statement.ajax.account_statement_details_table',['data'=>$data,'invoiceCounts'=>$invoiceCounts])->render()
//        ]);
//    }

    public function account_statement_details_table_ajax(Request $request){
        $query = DocAmountModel::query();
        $query->with('currency_info');
        $query->where('client_id',$request->user_id);
        if ($request->filled('reference_number')){
            $query->where('reference_number','like','%'.$request->reference_number.'%');
        }
        if ($request->filled('from') && $request->filled('to')){
            $query->whereBetween('created_at',[Carbon::parse($request->from)->startOfDay(),Carbon::parse($request->to)->endOfDay()]);
        }
        $data = $query->with('invoice_items')->get();

        $sumQuery = DocAmountModel::select('type', DB::raw('COUNT(*) as type_count'))
            ->where('client_id',$request->user_id)
            ->groupBy('type')
            ->get();
            return $data;
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.account_statement.ajax.account_statement_details_table',['data' => $data,'sumQuery'=>$sumQuery , 'request'=>$request])->render()
        ]);
    }

    public function print_account_statement_details_pdf($user_id){
        $user = User::where('id',$user_id)->first();
        $query = DocAmountModel::query();
        $query->where('client_id',$user_id);
        $data = $query->get();
        $sumQuery = DocAmountModel::select('type', DB::raw('COUNT(*) as type_count'))
            ->where('client_id',$user_id)
            ->groupBy('type')
            ->get();
        $pdf = PDF::loadView('admin.accounting.account_statement.pdf.account_statement_details_pdf', ['data' => $data , 'user' => $user]);
        return $pdf->stream('account_statement.pdf');
    }
}
