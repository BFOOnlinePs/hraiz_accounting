<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\BondsModel;
use App\Models\User;
use Illuminate\Http\Request;
use function Symfony\Component\String\s;

class CheckController extends Controller
{
    public function index()
    {
        return view('admin.accounting.cheques.index');
    }

    public function list_cheques_ajax(Request $request)
    {
        $data = BondsModel::orderBy('id', 'desc');
        if ($request->filled('client_name')) {
            $data->whereIn('client_id', function ($query) use ($request) {
                $query->select('id')
                    ->from('users')
                    ->where('name', 'like','%'.$request->client_name.'%');
            });
        }
        if ($request->filled('check_status')){
            $data->where('check_status',$request->check_status);
        }
        if ($request->filled('check_type')){
            $data->where('check_type',$request->check_type);
        }
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
            $data->whereBetween('due_date', [$fromDate, $toDate]);
        } elseif ($request->filled('from_date')) {
            $fromDate = $request->from_date;
            $data->whereDate('due_date', '>=', $fromDate);
        } elseif ($request->filled('to_date')) {
            $toDate = $request->to_date;
            $data->whereDate('due_date', '<=', $toDate);
        }
        $data = $data->paginate(10);
        foreach ($data as $key){
            $key->user = User::where('id',$key->client_id)->first()->name;
        }
        return response()->json([
            'success' => true,
            'view' => view('admin.accounting.cheques.ajax.list_cheques_ajax', ['data' => $data])->render()
        ]);
    }

    public function update_check_status_ajax(Request $request)
    {
        $data = BondsModel::where('id',$request->id)->first();
        $data->check_status = $request->check_status;
        if ($data->save()){
            return response()->json([
                'success' => true,
                'message' => 'تم تعديل حالة الشيك بنجاح'
            ]);
        }
    }

    public function update_check_type_ajax(Request $request)
    {
        $data = BondsModel::where('id',$request->id)->first();
        $data->check_type = $request->check_type;
        if ($data->save()){
            return response()->json([
                'success' => true,
                'message' => 'تم تعديل نوع الشيك بنجاح'
            ]);
        }
    }

    public function update_check_amount_ajax(Request $request)
    {
        $data = BondsModel::where('id',$request->id)->first();
        $data->amount = $request->amount;
        if($data->save()){
            return response()->json([
                'success' => true,
                'message' => 'تم تعديل البيانات بنجاح'
            ]);
        }
    }
}
