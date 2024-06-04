<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkingHoursModel;
use Illuminate\Http\Request;

class WorkingHoursController extends Controller
{
    public function update_permanent_type(Request $request){
        $data = User::where('id',$request->employee_id)->first();
        $data->permanent_type = $request->permanent_type;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم تعديل البيانات بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خلل ما لم يتم تعديل البيانات'
            ]);
        }
    }

    public function create_working_houre(Request $request){
        $data = WorkingHoursModel::firstOrCreate(['employee_id'=>$request->employee_id,'day'=>$request->day]);
        $data->employee_id = $request->employee_id;
        $data->day = $request->day;
        $data->{$request->operation} = $request->value;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم تعديل البيانات بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خلل ما لم يتم تعديل البيانات'
            ]);
        }
    }
}
