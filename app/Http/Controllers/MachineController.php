<?php

namespace App\Http\Controllers;

use App\Models\MachineModel;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function setting_index(){
        $data = MachineModel::get();
        return view('admin.setting.machine.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new MachineModel();
        $data->machines_name = $request->machines_name;
        $data->machines_description = $request->machines_description;
        if ($request->hasFile('machines_image')) {
            $file = $request->file('machines_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('machine', $filename, 'public');
            $data->machines_image = $filename;
        }
        if ($data->save()){
            return redirect()->route('setting.machine.setting_index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('setting.machine.setting_index')->with(['fail'=>'هناك خطا ما لم يتم اضافة البيانات بنجاح']);
        }
    }

    public function edit($id){
        $data = MachineModel::where('id',$id)->first();
        return view('admin.setting.machine.edit',['data'=>$data]);
    }

    public function update(Request $request){
        $data = MachineModel::where('id',$request->id)->first();
        $data->machines_name = $request->machines_name;
        $data->machines_description = $request->machines_description;
        if ($request->hasFile('machines_image')) {
            $file = $request->file('machines_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('machine', $filename, 'public');
            $data->machines_image = $filename;
        }
        if ($data->save()){
            return redirect()->route('setting.machine.setting_index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('setting.machine.setting_index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function delete($id){
        $data = MachineModel::where('id',$id)->first();
        if ($data->delete()){
            return redirect()->route('setting.machine.setting_index')->with(['success'=>'تم حذف البيانات بنجاح']);
        }
        else{
            return redirect()->route('setting.machine.setting_index')->with(['fail'=>'هناك خلل ما لم يتم حذف البيانات']);
        }
    }
}
