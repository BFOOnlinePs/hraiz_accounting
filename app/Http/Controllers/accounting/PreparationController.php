<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\OrdersSalesItemsModel;
use App\Models\OrdersSalesModel;
use App\Models\PreparationModel;
use Illuminate\Http\Request;
use PDF;

class PreparationController extends Controller
{
    public function index(){
        $data = PreparationModel::with('order','fromUser','toUser')->where('from_user',auth()->user()->id)->orWhere('to_user',auth()->user()->id)->get();
        return view('admin.accounting.preparation.index',['data'=>$data]);
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
}
