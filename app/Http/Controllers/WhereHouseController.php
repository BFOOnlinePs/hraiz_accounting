<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WhereHouseModel;
use Illuminate\Http\Request;

class WhereHouseController extends Controller
{
    public function index(){
        $employee = User::whereJsonContains('user_role','11')->get();
        $data = WhereHouseModel::get();
        foreach ($data as $key){
            $key->user = User::where('id',$key->wherehouse_store_manager)->first();
        }
        return view('admin.wherehouse.index',['data'=>$data,'employee'=>$employee]);
    }

    public function create(Request $request){
        $data = new WhereHouseModel();
        $data->wherehouse_name = $request->wherehouse_name;
        $data->wherehouse_address = $request->wherehouse_address;
        $data->wherehouse_phone = $request->wherehouse_phone;
        $data->wherehouse_type = $request->wherehouse_type;
        $data->wherehouse_store_manager = $request->wherehouse_store_manager;
        if ($data->save()){
            return redirect()->route('wherehouse.index')->with(['success'=>'تم اضافة المستودع بنجاح']);
        }
        else{
            return redirect()->route('wherehouse.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function update(Request $request){
        $data = WhereHouseModel::where('id',$request->wherehouse_id)->first();
        $data->wherehouse_name = $request->wherehouse_name;
        $data->wherehouse_address = $request->wherehouse_address;
        $data->wherehouse_phone = $request->wherehouse_phone;
        $data->wherehouse_type = $request->wherehouse_type;
        $data->wherehouse_store_manager = $request->wherehouse_store_manager;
        if ($data->save()){
            return redirect()->route('wherehouse.index')->with(['success'=>'تم تعديل بيانات المستودع بنجاح']);
        }
        else{
            return redirect()->route('wherehouse.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }
}
