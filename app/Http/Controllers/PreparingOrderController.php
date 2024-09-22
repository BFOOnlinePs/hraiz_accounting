<?php

namespace App\Http\Controllers;

use App\Models\PreparingOrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PreparingOrderController extends Controller
{
    public function index(){
        $data = PreparingOrderModel::get();
        return view('admin.accounting.preparing_order.index',['data'=>$data]);
    }

    public function add(){
        return view('admin.accounting.preparing_order.add');
    }

    public function create(Request $request){
        $data = new PreparingOrderModel();
        $data->from_user = auth()->user()->id;
        $data->to_user = $request->to_user;
        $data->insert_at = Carbon::now();
        $data->user_notes = $request->user_notes;
        $data->preparing_notes = 'sent_to_storekeeper';
        if($data->save()){
            return redirect()->route('')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
    }
}
