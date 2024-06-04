<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\BankSupplierModel;
use App\Models\CompanyContactPersonModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\ProductSupplierModel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLevels;
use App\Models\UserRole;
use App\Models\UsersFollowUpRecordsModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ClientsController extends Controller
{
    public function index(){
        $data = User::whereJsonContains('user_role',['10'])->get();
        return view('admin.users.clients.index',['data'=>$data]);
    }

    public function add(){
        $officer = User::whereJsonContains('user_role','2')->get();
        return view('admin.users.clients.add',['officer'=>$officer]);
    }

    public function create(Request $request){
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->user_phone1 = $request->user_phone1;
        $data->user_phone2 = $request->user_phone2;
        $data->user_role = json_encode(['10']);
        $data->user_status = 1;
        if(in_array('1',json_decode(auth()->user()->user_role))){
            $data->follow_by = json_encode($request->follow_by);
        }
        if(in_array('2',json_decode(auth()->user()->user_role))){
            $data->follow_by = '["'.auth()->user()->id.'"]';
        }
        $data->user_reg_date = Carbon::now();
        if ($request->hasFile('user_photo')) {
            $file = $request->file('user_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('user_photo', $filename, 'public');
            $data->user_photo = $filename;
        }
        $data->user_notes = $request->user_notes;
        $data->user_website = $request->user_website;
        $data->user_address = $request->user_address;
        $data->user_category = $request->user_category;
        $data->user_account_number = $request->user_account_number;
        $data->user_bank_name = $request->user_bank_name;
        $data->user_bank_address = $request->user_bank_address;
        $data->user_swift_code = $request->user_swift_code;
        $data->user_iban_number = $request->user_iban_number;
        if ($data->save()){
            $user_levels = new UserLevels();
            $user_levels->user_id = $data->id;
            $user_levels->role_id = 10;
            $user_levels->save();
            return redirect()->route('users.clients.index')->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>1]);
        }
        else{
            return redirect()->back()->withInput();
        }
    }

    public function edit($id){
        $data = User::where('id',$id)->first();
        $user_role = UserRole::get();
        return view('admin.users.clients.edit',['data'=>$data,'user_role'=>$user_role]);
    }

    public function update($id,Request $request){
        $data = User::where('id',$id)->first();
        $data->name = $request->name;
        $data->email = $request->email;
        if ($request->password != ''){
            $data->password = Hash::make($request->password);
        }
        $data->user_phone1 = $request->user_phone1;
        $data->user_phone2 = $request->user_phone2;
        if ($request->photo != ''){
            if ($request->hasFile('user_photo')) {
                $file = $request->file('user_photo');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->storeAs('user_photo', $filename, 'public');
                $data->user_photo = $filename;
            }
        }
        $data->user_notes = $request->user_notes;
        $data->user_website = $request->user_website;
        $data->user_category = $request->user_category;
        $data->user_account_number = $request->user_account_number;
        $data->user_bank_name = $request->user_bank_name;
        $data->account_owner = $request->account_owner;
        $data->user_bank_address = $request->user_bank_address;
        $data->user_swift_code = $request->user_swift_code;
        $data->user_iban_number = $request->user_iban_number;
        if ($data->save()) {
            return redirect()->route('users.clients.edit', ['id'=>$id])->with(['success' => 'تم تعديل البيانات بنجاح','tab_id'=>1]);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function details($id){
        $data = User::where('id',$id)->first();
        $company_contact_person = CompanyContactPersonModel::where('company_id',$id)->get();
        $product_supplier = ProductSupplierModel::where('user_id',$id)->get();
        $order_supplier = OrderModel::join('price_offers','price_offers.order_id','=','orders.id')->where('price_offers.supplier_id',$id)->get();
        foreach ($order_supplier as $key){
            $key->supplier = User::where('id',$key->supplier_id)->first();
        }
        foreach ($product_supplier as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        $products = ProductModel::take(15)->get();
        $banks = BankModel::get();
        $supplier_banks = BankSupplierModel::where('supplier_id',$id)->get();
        $users_follow_up_records = UsersFollowUpRecordsModel::where('user_id',$data->id)->get();
        foreach ($supplier_banks as $key){
            $key->added_by = User::where('id',$key->added_by)->first();
            $key->bank = BankModel::where('id',$key->bank_id)->first();
        }
        return view('admin.users.clients.details',['data'=>$data,'banks'=>$banks,'company_contact_person'=>$company_contact_person,'order_supplier'=>$order_supplier,'product_supplier'=>$product_supplier,'users_follow_up_records'=>$users_follow_up_records,'products'=>$products,'supplier_banks'=>$supplier_banks]);
    }
}
