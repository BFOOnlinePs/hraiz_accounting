<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\DocAmountModel;
use App\Models\InvoiceItemsModel;
use App\Models\OrdersSalesItemsModel;
use App\Models\OrdersSalesModel;
use App\Models\PreparationModel;
use App\Models\PriceOfferSalesItemsModel;
use App\Models\PriceOfferSalesModel;
use App\Models\ProductModel;
use App\Models\SystemSettingModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class OrdersSalesController extends Controller
{
    public function index()
    {
        $clients = User::whereJsonContains('user_role','10')->orWhereJsonContains('user_role','4')->get();
        return view('admin.accounting.orders_sales.index',['clients'=>$clients]);
    }

    public function list_orders_sales_ajax(Request $request)
    {
        $data = OrdersSalesModel::query();
        if($request->filled('reference_name')){
            $data->where('reference_number','like','%'.$request->reference_name.'%');
        }
        if($request->filled('user_id')){
            $data->where('user_id',$request->user_id);
        }

        $data = OrdersSalesModel::orderBy('id','desc')->paginate(10);
        foreach ($data as $key){
            $key->client = User::where('id',$key->user_id)->first();
        }
    
        return response()->json([
            'success' => true,
            'view' => view('admin.accounting.orders_sales.ajax.orders_sales_ajax',['data'=>$data])->render()
        ]);
    }

    public function product_list_ajax(Request $request){
        $data = ProductModel::where('product_name_ar','like','%'.$request->search.'%')->paginate(8);
        return response()->json([
            'success' => true,
            'view' => view('admin.accounting.orders_sales.ajax.product_list_ajax',['data'=>$data])->render()
        ]);
    }

    public function create(Request $request)
    {
        $data = new OrdersSalesModel();
        $data->user_id = $request->user_id;
        $data->reference_number = $request->reference_number;
        $data->inserted_at = Carbon::now();
        if ($data->save()){
            return redirect()->route('accounting.orders_sales.orders_sales_details',['order_id'=>$data->id]);
        }
    }

    public function orders_sales_details($order_id)
    {
        $data = OrdersSalesModel::where('id',$order_id)->first();
        $clients = User::whereJsonContains('user_role','10')->orWhereJsonContains('user_role','4')->get();
        $employees = User::whereJsonContains('user_role','11')->get();
        return view('admin.accounting.orders_sales.orders_sales_details',['data'=>$data , 'clients'=>$clients , 'employees'=>$employees]);
    }

    public function orders_sales_items_list_ajax(Request $request)
    {
        $data = OrdersSalesItemsModel::where('order_id',$request->order_id)->get();
        $order_items = OrdersSalesModel::where('id',$request->order_id)->first();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        return response()->json([
            'success' => true,
            'view' => view('admin.accounting.orders_sales.ajax.list_product_details',['data'=>$data , 'order_items'=>$order_items])->render()
        ]);
    }

    public function create_orders_sales_items(Request $request)
    {
        $check_if_find = OrdersSalesItemsModel::where('order_id',$request->order_id)->where('product_id',$request->product_id)->first();
        if ($check_if_find){
            $check_if_find->qty += 1;
            if ($check_if_find->save()){
                return response()->json([
                    'success' => true,
                    'message' => 'تم اضافة الصنف بنجاح'
                ]);
            }
        }
        else{
            $data = new OrdersSalesItemsModel();
            $data->order_id = $request->order_id;
            $data->product_id = $request->product_id;
            $data->price = ProductModel::where('id',$request->product_id)->first()->price ?? 0;
            if ($data->save()){
                return response()->json([
                    'success' => true,
                    'message' => 'تم اضافة الصنف بنجاح'
                ]);
            }
        }
    }

    public function update_orders_sales_items(Request $request)
    {
        $data = OrdersSalesItemsModel::where('id',$request->id)->first();
        $data->{$request->key} = $request->value;
        if ($data->save()){
            return response()->json([
                'success' => true,
                'message' => 'تم تعديل البيانات بنجاح'
            ]);
        }
    }

    public function update_orders_sales(Request $request)
    {
        $data = OrdersSalesModel::where('id',$request->id)->first();
        $data->{$request->key} = $request->value;
        if ($data->save()){
            return response()->json([
                'success' => true,
                'message' => 'تم تعديل البيانات بنجاح'
            ]);
        }
    }

    public function delete_orders_sales_items(Request $request)
    {
        $data = OrdersSalesItemsModel::where('id',$request->id)->first();
        if ($data->delete()){
            return response()->json([
                'success' => true,
                'message' => 'تم حذف البيانات بنجاح'
            ]);
        }
    }

    public function price_offer_sales_ajax(Request $request)
    {
        $data = PriceOfferSalesModel::query();
        if ($request->filled('client_id')){
            $data->where('customer_id',$request->client_id);
        }
        $data = $data->with('user')->get();
        return response()->json([
            'success'=>'true',
            'view' => view('admin.accounting.orders_sales.ajax.sales_price_offer',['data'=>$data])->render()
        ]);
    }

    public function add_price_offer_sales_to_order_sales(Request $request)
    {
        $get_last_id = OrdersSalesModel::latest('id')->first()->id;
        $data = new OrdersSalesModel();
        $data->user_id = $request->customer_id;
        $data->order_status = 'invoice_has_not_been_posted';
        $data->price_offer_sales_id = $request->price_offer_sales_id;
        $data->reference_number = 'عرض سعر رقم ' . $data->id;
        $data->inserted_at = Carbon::now();
        if ($data->save()){
            $get_price_offer_sales_items = PriceOfferSalesItemsModel::where('price_offer_sales_id',$request->price_offer_sales_id)->get();
            foreach ($get_price_offer_sales_items as $key){
                $order_sales_items = new OrdersSalesItemsModel();
                $order_sales_items->order_id = $data->id;
                $order_sales_items->product_id = $key->product_id;
                $order_sales_items->qty = $key->qty;
                $order_sales_items->price = $key->price;
                $order_sales_items->notes = $key->notes;
                $order_sales_items->save();
            }
            $redirectUrl = route('accounting.orders_sales.orders_sales_details', ['order_id' => $data->id]);            return response()->json([
                'success' => true,
                'message' => 'تم انشاء طلبية البيع بنجاح',
                'redirect' => $redirectUrl
            ]);
        }
    }

    public function update_order_sales_status(Request $request)
    {
        $data = OrdersSalesModel::where('id',$request->id)->first();
        $data->order_status = 'invoice_has_been_posted';
            $doc_amount = new DocAmountModel();
            $doc_amount->type = 'order_sales';
            $doc_amount->invoice_id = $request->id;
            $doc_amount->amount = OrdersSalesItemsModel::where('order_id',$request->id)->sum(DB::raw('price * qty'));
            $doc_amount->client_id = $data->user_id;
            $doc_amount->save();    
        
        if ($data->save()){
            return redirect()->route('accounting.orders_sales.orders_sales_details',['order_id'=>$request->id])->with('تم ترحيل طلبية البيع بنجاح');
        }
    }

    public function check_if_price_offer_if_found(Request $request)
    {
        $data = OrdersSalesModel::query();
        $data->where('price_offer_sales_id',$request->price_offer_sales_id);
        $data = $data->first();
        if (!empty($data)){
            return response()->json([
                'success' => true,
                'status' => 'not_empty'
            ]);
        }
        else{
            return response()->json([
                'success' => true,
                'status' => 'empty'
            ]);
        }
    }

    public function order_sales_pdf($order_id,Request $request){
        $data = OrdersSalesModel::with('user','order_sales_items','order_sales_items.product')->where('id',$order_id)->first();
        $system_setting = SystemSettingModel::first();
        $pdf = PDF::loadView('admin.accounting.orders_sales.pdf.order_sales_details',['data'=>$data , 'system_setting'=>$system_setting ,'request'=>$request]);
        // $pdf->SetHTMLFooterByName('last-footer', '<div style="text-align: center;">Footer content for the last page</div>');
        // $pdf->SetHTMLFooter('last-footer', 'O');
        return $pdf->stream('order_sales.pdf');
    }

    public function create_preparation(Request $request){
        $data = new PreparationModel();
        $data->order_id = $request->order_id;
        $data->from_user = auth()->user()->id;
        $data->to_user = $request->employee_id;
        $data->status = 'waiting_prepared';
        $data->notes = $request->notes;
        $data->insert_at = Carbon::now();
        if($data->save()){
            return redirect()->back();
        }
    }
}
