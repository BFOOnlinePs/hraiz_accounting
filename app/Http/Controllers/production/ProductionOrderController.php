<?php

namespace App\Http\Controllers\production;

use App\Http\Controllers\Controller;
use App\Models\ProducationLinesModel;
use App\Models\ProductionOrdersModel;
use App\Models\User;
use Illuminate\Http\Request;

class ProductionOrderController extends Controller
{
    public function index(){
        $data = ProductionOrdersModel::get();
        foreach ($data as $key){
            $key->production_lines = ProducationLinesModel::where('id',$key->production_line_id)->first();
            $key->user = User::where('id',$key->employee_id)->first();
        }
        $production_lines = ProducationLinesModel::get();
        $employees = User::whereJsonContains('user_role','11')->get();
        return view('admin.production.production_orders.index',['data'=>$data,'production_lines'=>$production_lines,'employees'=>$employees]);
    }
}
