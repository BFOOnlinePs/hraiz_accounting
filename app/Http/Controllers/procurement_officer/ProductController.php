<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\ProductSupplierModel;
use App\Models\UnitsModel;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class ProductController extends Controller
{
    public $progress_status = 1;
    public function index($order_id){
        $order = OrderModel::where('id',$order_id)->first();
        $data = OrderItemsModel::where('order_id',$order_id)->get();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        $unit = UnitsModel::get();
       $product = ProductModel::with('orderItems')->whereIn('id',function ($query) use ($order_id){
           $query->select('product_id')->from('product_supplier')->whereIn('user_id',function ($query) use ($order_id){
                $query->select('supplier_id')->from('price_offers')->where('price_offers.order_id',$order_id);
           });
       })->get();
        return view('admin.orders.procurement_officer.product.index',['order'=>$order,'data'=>$data,'unit'=>$unit,'product'=>$product]);
    }

    public function create_order_items(Request $request){
        $check_progress_status = OrderModel::where('id',$request->order_id)->first();
        $check_find = OrderItemsModel::where('order_id',$request->order_id)->where('product_id',$request->product_id)->first();
        if (!empty($check_find)){
            return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$request->order_id])->with(['fail'=>'هذا الصنف تم اضافته مسبقا']);
        }
        else{
            $if_save = 0;
            for($i = 0;$i<count($request->checkbox);$i++){
                $product_find = OrderItemsModel::where('order_id',$request->order_id)->where('product_id',$request->checkbox[$i])->first();
                if(!$product_find){
                    $data = new OrderItemsModel();
                    $data->order_id = $request->order_id;
                    $data->product_id = $request->checkbox[$i];
                    $data->qty = $request->qty;
                    $data->unit_id = $request->unit_id;
                    $data->status = 1;
                    $data->notes = $request->notes;
                    $data->save();
                    $if_save = 1;
                }
            }

            if (($check_progress_status->progress_status) <= $this->progress_status){
                $check_progress_status->progress_status = $this->progress_status;
                $check_progress_status->save();
            }

            if ($if_save == 1){
                return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$request->order_id])->with(['success'=>'تم اضافة البيانات بنجاح']);
            }
            else{
                return redirect()->route('procurement_officer.orders.product.index',['order_id'=>$request->order_id])->with(['fail'=>'هذا المنتج تم اختياره من قبل']);
            }
        }
    }

    public function product_list_pdf(Request $request){
        $order = OrderModel::where('id',$request->order_id)->first();
        $data = OrderItemsModel::where('order_id',$request->order_id)->get();
        foreach($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
        }
        $pdf = PDF::loadView('admin.orders.procurement_officer.product.pdf.product_list', ['data' => $data,'order'=>$order , 'request'=>$request]);
        return $pdf->stream('products.pdf');
    }

    public function search_product_ajax(Request $request){
        $order_id = $request->order_id;
        $order = OrderModel::find($order_id);
        $order_items = OrderItemsModel::where('order_id',$order_id)->get();
        $data = ProductModel::whereIn('id',function ($query) use ($order_id){
            $query->select('product_id')->from('product_supplier')->whereIn('user_id',function ($query) use ($order_id){
                 $query->select('supplier_id')->from('price_offers')->where('price_offers.order_id',$order_id);
            });
        })->whereNotIn('id',OrderItemsModel::select('product_id')->where('order_id',$order_id)->get())->when(!empty($request->search_product),function($query) use ($request){
            $query->where('product_name_ar','like','%'.$request->search_product.'%');
        })->paginate(10);
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.orders.procurement_officer.product.ajax.search_product',['data'=>$data,'order_items'=>$order_items,'order'=>$order])->render(),
        ]);
    }

    public function create_product_ajax(Request $request){
        $data = new OrderItemsModel();
        $data->order_id = $request->order_id;
        $data->product_id = $request->product_id;
        $data->unit_id = $request->unit_id;
        $data->status = 1;
        if($data->save()){
            return response()->json('true');
        }
    }

    public function order_items_table(Request $request){
        $order = OrderModel::where('id',$request->order_id)->first();
        $data = OrderItemsModel::where('order_id',$request->order_id)->get();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        $unit = UnitsModel::get();
        $order_id = $request->order_id;
       $product = ProductModel::with('orderItems')->whereIn('id',function ($query) use ($order_id){
           $query->select('product_id')->from('product_supplier')->whereIn('user_id',function ($query) use ($order_id){
                $query->select('supplier_id')->from('price_offers')->where('price_offers.order_id',$order_id);
           });
       })->get();        return response()->json([
            'status'=>'true',
            'view' => view('admin.orders.procurement_officer.product.ajax.order_items_table', ['data' => $data,'order'=>$order,'unit'=>$unit,'product'=>$product])->render()
        ]);
    }

}
