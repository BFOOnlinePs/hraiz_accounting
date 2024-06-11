<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\OrdersSalesItemsModel;
use App\Models\OrdersSalesModel;
use App\Models\ProductModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersSalesController extends Controller
{
    public function index()
    {
        $clients = User::whereJsonContains('user_role','10')->orWhereJsonContains('user_role','4')->get();
        return view('admin.accounting.orders_sales.index',['clients'=>$clients]);
    }

    public function list_orders_sales_ajax(Request $request)
    {
        $data = OrdersSalesModel::get();
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
        return view('admin.accounting.orders_sales.orders_sales_details',['data'=>$data]);
    }

    public function orders_sales_items_list_ajax(Request $request)
    {
        $data = OrdersSalesItemsModel::where('order_id',$request->order_id)->get();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        return response()->json([
            'success' => true,
            'view' => view('admin.accounting.orders_sales.ajax.list_product_details',['data'=>$data])->render()
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
}
