<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\EmployeeBonus;
use Illuminate\Http\Request;

class BonusesController extends Controller
{
    public function create(Request $request)
    {
        $employee_bonus = new EmployeeBonus();
        $employee_bonus->employee_id = $request->employee_id;
        $employee_bonus->value = $request->value;
        $employee_bonus->type = $request->type;
        $employee_bonus->notes = $request->notes;
        $employee_bonus->inserted_by = auth()->user()->id;
        if($employee_bonus->save()) {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم إضافة علاوة للموظف بنجاح','tab_id'=>9]);
        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم تتم إضافة العلاوة ، هناك خلل ما','tab_id'=>9]);
        }
    }
    public function edit(Request $request)
    {
        $employee_bonus = EmployeeBonus::find($request->id);
        $employee_bonus->value = $request->value;
        $employee_bonus->type = $request->type;
        $employee_bonus->notes = $request->notes;
        if($employee_bonus->save()) {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم تعديل علاوة للموظف بنجاح']);
        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم تتم تعديل العلاوة ، هناك خلل ما']);
        }

    }
}
