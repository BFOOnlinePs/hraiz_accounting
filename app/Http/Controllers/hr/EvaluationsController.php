<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\EmployeeEvaluation;
use Illuminate\Http\Request;

class EvaluationsController extends Controller
{
    public function create(Request $request)
    {
        $employee_evaluation = new EmployeeEvaluation();
        $employee_evaluation->employee_id = $request->employee_id;
        $employee_evaluation->notes = $request->notes;
        $employee_evaluation->inserted_by = auth()->user()->id;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'attachment_file' . $extension;
            $file->storeAs('employees_evaluations', $filename, 'public');
            $employee_evaluation->attachment = $filename;
        }
        if($employee_evaluation->save()) {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم إضافة تقييم للموظف بنجاح','tab_id'=>10]);
        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم تتم إضافة التقييم ، هناك خلل ما','tab_id'=>10]);
        }
    }
    public function edit(Request $request)
    {
        $employee_evaluation = EmployeeEvaluation::find($request->id);
        $employee_evaluation->notes = $request->notes;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'attachment_file' . $extension;
            $file->storeAs('employees_evaluations', $filename, 'public');
            $employee_evaluation->attachment = $filename;
        }
        if($employee_evaluation->save()) {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم تعديل تقييم الموظف بنجاح']);
        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم تتم تعديل التقييم ، هناك خلل ما']);
        }
    }
}
