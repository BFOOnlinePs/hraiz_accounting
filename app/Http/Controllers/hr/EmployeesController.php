<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\BfoAttendance;
use App\Models\BfoExpenseCategoriesModel;
use App\Models\BfoExpensesModel;
use App\Models\Currency;
use App\Models\DiscountReward;
use App\Models\EmployeeBonus;
use App\Models\EmployeeEvaluation;
use App\Models\SalariesModel;
use App\Models\User;
use App\Models\UserLevels;
use App\Models\UserRole;
use App\Models\VacationType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    public function index()
    {
        return view('admin.hr.employees.index');
    }
    public function add()
    {
        return view('admin.hr.employees.add');
    }
    public function employee_table(Request $request){
        $data = User::whereJsonContains('user_role','11')
        ->where(function($query) use($request){
            $query->where('name','like','%'.$request->search.'%');
        })
        ->get();
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.hr.employees.ajax.employee_table',['data' => $data])->render()
        ]);
    }
    public function details($id)
    {
        $data = User::find($id);
        $bfo_attendances = BfoAttendance::where('user_id' , $id)
        ->where('deleted', 0)
        ->paginate(10);
        dd($bfo_attendances);
        $currencies = Currency::get();
        $vacations_types = VacationType::get();
        $employees_bonuses = EmployeeBonus::where('employee_id' , $id)->get();
        $employees_evaluations = EmployeeEvaluation::where('employee_id' , $id)->get();
        $salaries = SalariesModel::where('employee_id', $id)->get();
        $expenses_categories = BfoExpenseCategoriesModel::get();
        $expenses = BfoExpensesModel::get();
        foreach ($expenses as $key){
            $key->user = User::where('id',$key->user_id)->first();
            $key->expenses_category = BfoExpenseCategoriesModel::where('id',$key->category_id)->first();
        }
        return view('admin.hr.employees.details' , ['employees_evaluations' => $employees_evaluations ,'employees_bonuses' => $employees_bonuses  , 'vacations_types'=> $vacations_types , 'data' => $data , 'bfo_attendances' => $bfo_attendances , 'currencies' => $currencies , 'salaries' => $salaries , 'expenses_categories' => $expenses_categories , 'expenses' => $expenses]);
    }

    public function edit($id)
    {
        $data = User::find($id);
        $user_role = UserRole::get();
        return view('admin.hr.employees.edit' , ['data' => $data , 'user_role' => $user_role]);
    }
}
