<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\BfoAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class AttendanceController extends Controller
{
    public function create(Request $request)
    {
        return $request;
        $bfo_attendance = new BfoAttendance();
        $bfo_attendance->status = "approved";
        $bfo_attendance->user_id = $request->employee_id;
        $bfo_attendance->in_time = $request->date . ' ' . $request->time;
        $bfo_attendance->note = $request->note;
        $bfo_attendance->deleted = 0;
        $bfo_attendance->checked_by = auth()->user()->id;
        $bfo_attendance->activity_type = $request->activity_type;
        if($bfo_attendance->save())
        {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم تسجيل حضور الموظف بنجاح','tab_id'=>2]);

        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم يتم تسجيل حضور الموظف ، هناك خلل ما','tab_id'=>2]);
        }
    }
    public function editOutTime(Request $request)
    {
        $bfo_attendance = BfoAttendance::find($request->bfo_attendance_id);
        $bfo_attendance->out_time = $request->date . ' ' . $request->time;
        $bfo_attendance->note = $request->note;
        $bfo_attendance->checked_by = auth()->user()->id;
        $bfo_attendance->activity_type = $request->activity_type;
        if($bfo_attendance->save())
        {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم تسجيل مغادرة الموظف بنجاح','tab_id'=>2]);

        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم يتم تسجيل مغادرة الموظف ، هناك خلل ما']);
        }
    }
    public function delete(Request $request)
    {
        $bfo_attendance = BfoAttendance::find($request->bfo_attendance_id);
        $bfo_attendance->deleted = 1;
        if($bfo_attendance->save())
        {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم حذف السجل بنجاح','tab_id'=>2]);
        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم يتم حذف السجل ، هناك خلل ما']);
        }
    }
    public function edit(Request $request)
    {
        $bfo_attendance = BfoAttendance::find($request->bfo_attendance_id);
        $bfo_attendance->in_time = $request->in_time_date . ' ' . $request->in_time_time;
        $bfo_attendance->out_time = $request->out_time_date . ' ' . $request->out_time_time;
        $bfo_attendance->note = $request->note;
        $bfo_attendance->checked_by = auth()->user()->id;
        $bfo_attendance->activity_type = $request->activity_type;
        if($bfo_attendance->save())
        {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم تعديل السجل بنجاح','tab_id'=>2]);

        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم يتم تعديل السجل ، هناك خلل ما']);
        }
    }

    public function export_pdf(){
        $data = BfoAttendance::get();
        $pdf = PDF::loadView('admin.hr.employees.pdf.attendance', ['data'=>$data]);
        return $pdf->stream('document.pdf');
    }
}
