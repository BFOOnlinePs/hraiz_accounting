<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\BfoExpenseCategoriesModel;
use App\Models\BfoExpensesModel;
use App\Models\Currency;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    public function index(){
        $start_date = Carbon::now()->firstOfMonth()->toDateString();
        $end_date = Carbon::now()->toDateString();
        $expenses = BfoExpensesModel::get();
        $expenses_categories = BfoExpenseCategoriesModel::get();
        $currencies = Currency::get();
        $users = User::whereJsonContains('user_role','1')->get();
        foreach ($expenses as $key){
            $key->user = User::where('id',$key->user_id)->first();
            $key->expenses_category = BfoExpenseCategoriesModel::where('id',$key->category_id)->first();
        }
        return view('admin.accounting.expenses.index',['expenses'=>$expenses , 'expenses_categories'=>$expenses_categories , 'users'=>$users , 'currencies'=>$currencies,'start_date'=>$start_date,'end_date'=>$end_date]);
    }

    public function expenses_table_ajax(Request $request){
        $expenses = BfoExpensesModel::when($request->filled('category_id'), function ($query) use ($request) {
            $query->where('category_id', $request->category_id);
        })
            ->when($request->filled('added_by'), function ($query) use ($request) {
                $query->where('user_id', $request->added_by);
            })
            ->when($request->filled('from') && $request->filled('to'), function ($query) use ($request) {
                $query->whereBetween('expense_date', [$request->from, $request->to]);
            })
            ->get();

        foreach ($expenses as $expense) {
            $expense->user = User::find($expense->user_id);
            $expense->currency = Currency::find($expense->currency_id);
            $expense->expenses_category = BfoExpenseCategoriesModel::find($expense->category_id);

            // Calculate the total sum with filters
            $expense->total_sum = BfoExpensesModel::when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
                ->when($request->filled('added_by'), function ($query) use ($request) {
                    $query->where('user_id', $request->added_by);
                })
                ->when($request->filled('from') && $request->filled('to'), function ($query) use ($request) {
                    $query->whereBetween('expense_date', [$request->from, $request->to]);
                })
                ->groupBy('currency_id')
                ->select('currency_id', DB::raw('SUM(amount) as total_sum'))
                ->get();
        }
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.expenses.ajax.expenses_table', ['expenses' => $expenses])->render()
        ]);
    }

    public function create(Request $request){
        $data = new BfoExpensesModel();
        $data->expense_date = $request->expense_date;
        $data->category_id = $request->category_id;
        $data->description = $request->description;
        $data->amount = $request->amount;
        $data->expenses_status = 'not_published';
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('expenses', $filename, 'public');
            $data->files = $filename;
        }
        $data->title = $request->title;
        $data->user_id = auth()->user()->id;
        $data->repeat_every = $request->repeat_every;
        $data->repeat_type = $request->repeat_type;
        $data->no_of_cycles = $request->no_of_cycles;
        // $data->currency_id = $request->currency_id;
        if ($data->save()){
            return redirect()->route('accounting.expenses.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.expenses.index')->with(['success'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function update(Request $request){
        $data = BfoExpensesModel::where('id',$request->expenses_id)->first();
        $data->expense_date = $request->expense_date;
        $data->category_id = $request->category_id;
        $data->description = $request->description;
        $data->amount = $request->amount;
        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('expenses', $filename, 'public');
            $data->files = $filename;
        }
        $data->title = $request->title;
        $data->user_id = auth()->user()->id;
        $data->repeat_every = $request->repeat_every;
        $data->repeat_type = $request->repeat_type;
        $data->no_of_cycles = $request->no_of_cycles;
        if ($data->save()){
            return redirect()->route('accounting.expenses.index')->with(['success'=>'تم تعديل البيانات بنجاح','tab_id'=>12]);
        }
        else{
            return redirect()->route('accounting.expenses.index')->with(['success'=>'هناك خلل ما لم يتم تعديل البيانات','tab_id'=>12]);
        }
    }

    public function delete($id){
        $data = BfoExpensesModel::where('id',$id)->first();
        if ($data->delete()){
            return redirect()->route('accounting.expenses.index')->with(['success'=>'تم حذف البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.expenses.index')->with(['success'=>'هناك خلل ما لم يتم حذف البيانات']);
        }
    }
}
