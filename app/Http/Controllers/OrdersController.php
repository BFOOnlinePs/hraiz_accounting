<?php

namespace App\Http\Controllers;

use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UnitsModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    // TODO  For Storekeeper
    public function index(){
        $data = OrderModel::where('user_id',auth()->user()->id)->orderBy('id','desc')->get();
        foreach ($data as $key){
            $key->user = User::where('id',$key->user_id)->first();
        }
        $users = User::get();
        return view('admin.orders.storekeeper.index',['data'=>$data,'users'=>$users]);
    }

    public function order_items_index($order_id){
        $data = OrderItemsModel::where('order_id',$order_id)->orderBy('id','desc')->get();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
        }
        $order = OrderModel::where('id',$order_id)->first();
        $product = ProductModel::get();
        $unit = UnitsModel::get();
        $salesman = User::whereJsonContains('user_role',['2'])->get();
        return view('admin.orders.storekeeper.order_items',['data'=>$data,'order'=>$order,'product'=>$product,'unit'=>$unit,'salesman'=>$salesman]);
    }

    public function create_order(){
        $data = new OrderModel();
        $data->user_id = auth()->user()->id;
        $data->order_status = 0;
        $data->inserted_at = Carbon::now()->toDateString();
        if ($data->save()){
            return redirect()->route('orders.order_items.index',['order_id'=>$data->id]);
        }
    }

    public function create_order_items(Request $request){
        $data = new OrderItemsModel();
        $data->order_id = $request->order_id;
        $data->product_id = $request->product_id;
        $data->qty = $request->qty;
        $data->unit_id = $request->unit_id;
        $data->notes = $request->notes;
        $data->status = 1;
        if ($data->save()){
            return redirect()->route('orders.order_items.index',['order_id'=>$request->order_id])->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('orders.order_items.index',['order_id'=>$request->order_id])->with(['fail'=>'هناك خطا ما لم يتم اضافة البيانات']);
        }
    }

    public function updateQtyForOrder_items(Request $request){
        $data = OrderItemsModel::where(['order_id'=>$request->order_id,'id'=>$request->order_items_id])->first();
        $data->qty = $request->qty;
        $data->save();
    }

    public function updateUnitOrder_items(Request $request){
        $data = OrderItemsModel::where(['order_id'=>$request->order_id,'id'=>$request->order_items_id])->first();
        $data->unit_id = $request->unit_id;
        $data->save();
    }

    public function selectedUnit(Request $request){
        $data = ProductModel::where('id',$request->product_id)->first();
        $data['unit'] = UnitsModel::where('id',$data->unit_id)->first();
        return response()->json([
            'success'=>'true',
            'data'=>$data
        ]);
    }

    public function updateOrderStatus(Request $request,$order_id){
        $data = OrderModel::where('id',$order_id)->first();
        $data->order_status = 1 ;
        $data->to_user = $request->to_user;
        if ($data->save()){
            return redirect()->route('orders.index');
        }
    }


}
