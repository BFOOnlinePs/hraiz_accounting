<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use App\Models\ProductionSettingModel;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function production_setting_list(Request $request){
        $data = ProductionSettingModel::where('production_line_id',$request->production_line_id)->paginate(10);
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.production.settings.ajax.setting_table',['data'=>$data])->render()
        ]);
    }

    public function create(Request $request){
        $data = new ProductionSettingModel();
        $data->production_line_id = $request->production_line_id;
        $data->production_name = $request->production_name;
        $data->production_value = $request->production_value;
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('production', $filename, 'public');
            $data->product_image = $filename;
        }
        $data->production_description = $request->production_description;
        if ($data->save()){
            return redirect()->route('production.production_inputs.index',['id'=>$request->production_line_id,'tab_id'=>1])->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('production.production_inputs.index',['id'=>$request->production_line_id,'tab_id'=>1])->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات بنجاح']);
        }
    }

    public function edit($id){
        $data = ProductionSettingModel::where('id',$id)->first();
        return view('admin.production.settings.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = ProductionSettingModel::where('id',$request->id)->first();
        $data->production_name = $request->production_name;
        $data->production_value = $request->production_value;
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('production', $filename, 'public');
            $data->product_image = $filename;
        }
        $data->production_description = $request->production_description;
        if ($data->save()){
            return redirect()->route('production.production_inputs.index',['id'=>$data->production_line_id,'tab_id'=>1])->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('production.production_inputs.index',['id'=>$data->production_line_id,'tab_id'=>1])->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function delete($id){
        $data = ProductionSettingModel::where('id',$id)->first();
        if ($data->delete()){
            return redirect()->route('production.production_inputs.index',['id'=>$data->production_line_id,'tab_id'=>1])->with(['success'=>'تم حذف العنصر بنجاح']);
        }
        else{
            return redirect()->route('production.production_inputs.index',['id'=>$data->production_line_id,'tab_id'=>1])->with(['fail'=>'هناك خلل ما لم يتم حذف البيانات']);
        }
    }
}
