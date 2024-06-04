<?php

namespace App\Http\Controllers;

use App\Models\BfoExpenseCategoriesModel;
use Illuminate\Http\Request;

class ExpensesCategoryController extends Controller
{
    public function index(){
        $data = BfoExpenseCategoriesModel::get();
        return view('admin.setting.expenses.index',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new BfoExpenseCategoriesModel();
        $data->title = $request->title;
        if ($data->save()){
            return redirect()->route('setting.expenses_category.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('setting.expenses_category.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }
}
