<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Vacation;
use App\Models\VacationType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VacationsController extends Controller
{
    public function create(Request $request)
    {
        $startDateTime = Carbon::parse($request->start_date);
        $endDateTime = Carbon::parse($request->end_date);
        $currentDate = $startDateTime->copy();
        while ($currentDate->lte($endDateTime)) {
            $date = $currentDate->toDateString() . PHP_EOL;
            $vacation = new Vacation();
            $vacation->employee_id = $request->employee_id;
            $vacation->v_date = $date;
            $vacation->vacations_type_id = $request->vacations_type_id;
            $vacation->notes = $request->notes;
            if ($request->hasFile('attachement')) {
                $file = $request->file('attachement');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . 'vacations_file' . $extension;
                $file->storeAs('vacations', $filename, 'public');
                $vacation->attachement = $filename;
            }
            if(!($vacation->save())) {
                return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم يتم تسجيل إجازة للموظف ، هناك خلل ما','tab_id'=>8]);
            }
            $currentDate->addDay();
        }
        return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم إضافة إجازة للموظف بنجاح','tab_id'=>8]);
    }
    public function vacations_change_date_by_ajax(Request $request)
    {
        $vacations = Vacation::where('employee_id', $request->employee_id)
        ->whereBetween('v_date', [$request->from , $request->to])
        ->paginate(10);
        foreach ($vacations as $key) {
            $key->name = VacationType::find($key->vacations_type_id);
        }
        $html = view('admin.hr.employees.ajax.vacations_table' , ['vacations' => $vacations])->render();
        return response()->json(['html' => $html]);
    }
    public function edit(Request $request)
    {
        $vacation = Vacation::find($request->id);
        $vacation->v_date = $request->v_date;
        $vacation->vacations_type_id = $request->vacations_type_id;
        $vacation->notes = $request->notes;
        if ($request->hasFile('attachement')) {
            $file = $request->file('attachement');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . 'vacations_file' . $extension;
            $file->storeAs('vacations', $filename, 'public');
            $vacation->attachement = $filename;
        }
            if($vacation->save()) {
                return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم تعديل إجازة للموظف بنجاح']);
            }
            else {
                return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم يتم تعديل إجازة الموظف ، هناك خلل ما']);
            }
    }
}
