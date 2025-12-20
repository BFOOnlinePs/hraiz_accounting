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

    /**
     * فلتر سجل الحضور حسب الشهر والسنة
     */
    public function filterAttendance(Request $request)
    {
        $employeeId = $request->get('employee_id');
        $year = $request->get('year');
        $month = $request->get('month');

        // 1. فلتر الحضور
        $attendanceQuery = BfoAttendance::where('user_id', $employeeId)->where('deleted', 0);
        if ($year && $month) {
            $attendanceQuery->whereYear('in_time', $year)->whereMonth('in_time', $month);
        }
        $attendances = $attendanceQuery->orderBy('in_time', 'asc')->get();

        // حساب الساعات
        $totalActualHours = 0;
        foreach($attendances as $att) {
            if($att->in_time && $att->out_time) {
                $start = \Carbon\Carbon::parse($att->in_time);
                $end = \Carbon\Carbon::parse($att->out_time);
                $minutes = $start->diffInMinutes($end);
                $totalActualHours += ($minutes / 60);
            }
        }

        // 2. فلتر الرواتب (حسب الشهر والسنة المخزنة في الجدول)
        $salariesQuery = SalariesModel::where('employee_id', $employeeId);
        if ($year && $month) {
            $salariesQuery->where('year', $year)->where('month', (int)$month); // تحويل الشهر لرقم لإزالة الصفر الزائد
        }
        $salaries = $salariesQuery->get();

        // 3. فلتر العلاوات (حسب تاريخ الإنشاء)
        $bonusesQuery = EmployeeBonus::where('employee_id', $employeeId);
        if ($year && $month) {
            $bonusesQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        }
        $bonuses = $bonusesQuery->get();

        // 4. فلتر التقييمات
        $evaluationsQuery = EmployeeEvaluation::where('employee_id', $employeeId);
        if ($year && $month) {
            $evaluationsQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        }
        $evaluations = $evaluationsQuery->get();

        // إرجاع كل البيانات
        return response()->json([
            'html' => view('admin.hr.employees.ajax.attendance_table_ajax', ['bfo_attendances' => $attendances])->render(),
            'total_actual_hours' => $totalActualHours,
            'salaries' => $salaries,
            'bonuses' => $bonuses,
            'evaluations' => $evaluations
        ]);
    }
}

