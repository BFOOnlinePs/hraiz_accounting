<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\InvoiceItemsModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\PriceOfferItemsModel;
use App\Models\PriceOffersModel;
use App\Models\PurchaseInvoicesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index($order_id){
        $order = OrderModel::find($order_id);
        $data = PurchaseInvoicesModel::where('order_id',$order_id)->get();
        $users_award = PriceOffersModel::where('order_id',$order_id)->where('status',1)->get();
        foreach ($users_award as $key){
            $key->user = User::where('id',$key->supplier_id)->first();
        }
        foreach($data as $key){
            $key->user = User::where('id',$key->client_id)->first();
        }
        return view('admin.orders.procurement_officer.invoices.index',['data'=>$data,'order'=>$order,'users_award'=>$users_award]);
    }

    public function create(Request $request){
        $data = new PurchaseInvoicesModel();
        $data->order_id = $request->order_id;
        $data->bill_date = Carbon::now()->toDateString();
        $data->due_date = Carbon::now()->toDateString();
        $data->client_id = $request->supplier_id;
        $price_offer = OrderItemsModel::where('order_id',$request->order_id)->get();
        if($data->save()){
            foreach($price_offer as $key){
                $invoice_items = new InvoiceItemsModel();
                $invoice_items->quantity = $key->qty ?? 0;
                $invoice_items->rate = PriceOfferItemsModel::where('order_id',$request->order_id)->where('supplier_id',$request->supplier_user_id)->where('product_id',$key->product_id)->first()->price ?? 0;
                $invoice_items->invoice_id = $data->id;
                $invoice_items->item_id = $key->product_id;
                $invoice_items->save();
            }
            return redirect()->route('procurement_officer.orders.invoices.index',['order_id'=>$request->order_id])->with(['success'=>'تم انشاء الفاتورة بنجاح']);
        }
    }
}
