<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\SalariesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $users = User::whereJsonContains('user_role' , '11')
        ->get();
        $data = SalariesModel::get();
        foreach ($data as $key){
            $key->employee = User::where('id',$key->employee_id)->first();
        }
        return view('admin.hr.salaries.index' , ['users' => $users , 'data' => $data]);
    }

    public function create(Request $request){
        $data = new SalariesModel();
        $data->employee_id = $request->employee_id;
        $data->month = $request->month;
        $data->year = $request->year;
        $data->days = $request->days;
        $data->insert_by = auth()->user()->id;
        $data->insert_at = Carbon::now();
        $data->status = 1;
        $data->salary_value = $request->salary_value;
        if($data->save()) {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم اضافة الراتب بنجاح','tab_id'=>3]);
        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم يتم اضافة الراتب ، هناك خلل ما','tab_id'=>3]);
        }
    }

    public function edit($id){
        $data = SalariesModel::where('id',$id)->first();
        $users = User::whereJsonContains('user_role' , '11')
            ->get();
        return view('admin.hr.salaries.edit',['data'=>$data,'users'=>$users]);
    }

    public function update(Request $request){
        $data = SalariesModel::where('id',$request->id)->first();
        $data->employee_id = $request->employee_id;
        $data->month = $request->month;
        $data->year = $request->year;
        $data->days = $request->days;
        $data->insert_by = auth()->user()->id;
        $data->insert_at = Carbon::now();
        $data->status = 1;
        $data->salary_value = $request->salary_value;
        if($data->save()) {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['success'=>'تم اضافة الراتب بنجاح','tab_id'=>3]);
        }
        else {
            return redirect()->route('users.employees.details' , ['id' => $request->employee_id])->with(['fail'=>'لم يتم اضافة الراتب ، هناك خلل ما','tab_id'=>3]);
        }
    }
}
