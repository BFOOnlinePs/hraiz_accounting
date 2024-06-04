<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VacationType;
use Illuminate\Http\Request;

class VacationsTypesController extends Controller
{
    public function index()
    {
        $vacations_types = VacationType::get();
        return view('admin.setting.vacations_types.index' , ['vacations_types' => $vacations_types]);
    }
    public function create(Request $request)
    {
        $vacations_types = new VacationType();
        $vacations_types->type_name = $request->type_name;
        if($vacations_types->save()) {
            return redirect()->route('setting.vacations_types.index' , ['vacations_types' => $vacations_types])->with(['success'=>'تم إضافة نوع إجازة بنجاح']);
        }
        else {
            return redirect()->route('setting.vacations_types.index' , ['vacations_types' => $vacations_types])->with(['fail'=>'لم تتم الإضافة ، هناك خلل ما']);
        }
    }
    public function edit(Request $request)
    {
        $vacations_types = VacationType::find($request->id);
        $vacations_types->type_name = $request->type_name;
        if($vacations_types->save()) {
            return redirect()->route('setting.vacations_types.index' , ['vacations_types' => $vacations_types])->with(['success'=>'تم تعديل نوع إجازة بنجاح']);
        }
        else {
            return redirect()->route('setting.vacations_types.index' , ['vacations_types' => $vacations_types])->with(['fail'=>'لم يتم تعديل نوع الإجازة ، هناك خلل ما']);
        }
    }
}
