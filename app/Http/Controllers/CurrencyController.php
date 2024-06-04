<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CurrencyModel;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(){
        $data = CurrencyModel::get();
        return view('admin.currency.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new CurrencyModel();
        $data->currency_name = $request->currency_name;
        $data->currency_symbol = $request->currency_symbol;
        $data->is_default = 0;
        if ($request->hasFile('currency_flag')) {
            $file = $request->file('currency_flag');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('currency_flag', $filename, 'public');
            $data->currency_flag = $filename;
        }
        if ($data->save()){
            return redirect()->route('currency.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('currency.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function set_default_value($id){
        $check_if_find = Currency::where('is_default',1)->first();
        if (empty($check_if_find)){
            $data = Currency::where('id',$id)->first();
            $data->is_default = 1;
            $data->save();
            if ($data->save()){
                return redirect()->route('currency.index')->with(['success'=>'تم تعديل القيمة الافتراضية للعملة بنجاح']);
            }
            else{
                return redirect()->route('currency.index')->with(['fail'=>'هناك خطا ما لم يتم تعديل البيانات']);
            }
        }
        else{
            $check_if_find->is_default = 0;
            $check_if_find->save();
            $data = Currency::where('id',$id)->first();
            $data->is_default = 1;
            $data->save();
            if ($data->save()){
                return redirect()->route('currency.index')->with(['success'=>'تم تعديل القيمة الافتراضية للعملة بنجاح']);
            }
            else{
                return redirect()->route('currency.index')->with(['fail'=>'هناك خطا ما لم يتم تعديل البيانات']);
            }
        }
    }

    public function edit($id){
        $data = CurrencyModel::find($id);
        return view('admin.currency.edit',['data'=>$data]);
    }

    public function update($id,Request $request){
        $data = CurrencyModel::find($id);
        $data->currency_name = $request->currency_name;
        $data->currency_symbol = $request->currency_symbol;
        if ($request->currency_flag != ''){
            if ($request->hasFile('currency_flag')) {
                $file = $request->file('currency_flag');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->storeAs('currency_flag', $filename, 'public');
                $data->currency_flag = $filename;
            }
        }
        if ($data->save()){
            return redirect()->route('currency.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('currency.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }
}
