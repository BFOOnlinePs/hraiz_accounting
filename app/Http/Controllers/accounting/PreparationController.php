<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\OrdersSalesItemsModel;
use App\Models\OrdersSalesModel;
use App\Models\PreparationModel;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class PreparationController extends Controller
{
    public function index(){
        $employees = User::whereJsonContains('user_role','11')->get();
        return view('admin.accounting.preparation.index' , ['employees'=>$employees]);
    }

    public function details($preparation_id){
        $preparation = PreparationModel::where('id',$preparation_id)->first();
        $data = OrdersSalesModel::with('order_sales_items' , 'order_sales_items.product')->where('id',$preparation->order_id)->first();
        return view('admin.accounting.preparation.details',['data'=>$data , 'preparation'=>$preparation]);
    }

    public function update_data(Request $request){
        $data = PreparationModel::where('order_id',$request->order_id)->first();
        $data->{$request->data_type} = $request->value;
        if($data->save()){
            return response()->json([
                'success'=>true,
                'message'=>'تم تعديل البيانات بنجاح'
            ]);
        }
    }

    public function print_qr_code_pdf($id){
        $data = PreparationModel::where('id',$id)->first();
        $pdf = PDF::loadView('admin.accounting.preparation.pdf.order_qrcode', ['data' => $data], [], [
            'format' => [100, 100],
            'defaultFontSize' => 10,
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 5,
            'margin_bottom' => 5,
        ]);       
        return $pdf->stream('qr_code_product.pdf');
    }

    public function list_preparation_ajax(Request $request){
        $data = PreparationModel::query();
        $data = $data->with('order','fromUser','toUser');
        if($request->filled('from_date') && $request->filled('to_date')){
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
            $data->whereBetween('insert_at',[$fromDate,$toDate]);
        }
        if($request->filled('to_user')){
            $data->where('to_user',$request->to_user);
        }
        if($request->filled('status')){
            $data->where('status',$request->status);
        }
        $data = $data->get();
        return response()->json([
            'success'=>true,
            'view'=>view('admin.accounting.preparation.ajax.perparation_list',['data'=>$data])->render()
        ]);
    }

    public function update_status_preparation(Request $request){
        $data = PreparationModel::where('id',$request->id)->first();
        $data->status = $request->status;
        if($data->save()){
            return response()->json([
                'success'=>true,
                'message'=>'تم تعديل البيانات بنجاح'
            ]);
        }
    }
}
