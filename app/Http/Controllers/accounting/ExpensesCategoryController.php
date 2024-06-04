<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\BfoExpenseCategoriesModel;
use Illuminate\Http\Request;

class ExpensesCategoryController extends Controller
{
    public function index(){
        $data = BfoExpenseCategoriesModel::get();
        return view('admin.accounting.expenses_category.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new BfoExpenseCategoriesModel();
        $data->title = $request->title;
        if ($data->save()){
            return redirect()->route('accounting.expenses_category.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.expenses_category.index')->with(['fail'=>'هناك خطا ما لم يتم اضافة البيانات']);
        }
    }

    public function update(Request $request){
        $data = BfoExpenseCategoriesModel::where('id',$request->expenses_category_id)->first();
        $data->title = $request->title;
        if ($data->save()){
            return redirect()->route('accounting.expenses_category.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.expenses_category.index')->with(['fail'=>'هناك خطا ما لم يتم تعديل البيانات']);
        }
    }
}
