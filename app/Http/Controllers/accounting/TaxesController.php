<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\TaxesModel;
use Illuminate\Http\Request;

class TaxesController extends Controller
{
    public function index(){
        $data = TaxesModel::get();
        return view('admin.accounting.taxes.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new TaxesModel();
        $data->tax_name = $request->tax_name;
        $data->tax_ratio = $request->tax_ratio;
        if($data->save()){
            return redirect()->route('accounting.texes.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.texes.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit($id){
        $data = TaxesModel::find($id);
        return view('admin.accounting.taxes.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = TaxesModel::find($request->id);
        $data->tax_name = $request->tax_name;
        $data->tax_ratio = $request->tax_ratio;
        if($data->save()){
            return redirect()->route('accounting.texes.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.texes.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function delete($id){
        $data = TaxesModel::find($id);
        if($data->delete()){
            return redirect()->route('accounting.texes.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.texes.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }
}
