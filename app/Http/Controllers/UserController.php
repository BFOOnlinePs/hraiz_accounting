<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\RoleLevelModel;
use App\Models\User;
use App\Models\UserLevels;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        return view('admin.users.index');
    }

    public function updateStatus(Request $request){
        $data = User::find($request->id);
        if ($request->user_status == 'true'){
            $data->user_status = 1;
        }
        else if($request->user_status == 'false'){
            $data->user_status = 0;
        }
        if ($data->save()){
            return response()->json([
                'message'=>'success'
            ]);
        }
    }

    public function add_form(){
        $user_role = UserRole::get();
        return view('admin.users.add',['user_role'=>$user_role]);
    }

    public function create(Request $request){
        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->user_phone1 = $request->user_phone1;
        $data->user_phone2 = $request->user_phone2;
        $data->user_role = json_encode($request->role_level);

        $data->user_status = 1;
        // if(auth()->user()->user_role == 1){
        //     $data->follow_by = json_encode($request->follow_by);
        // }
        // if(auth()->user()->user_role == 2){
        //     $data->follow_by = '["'.auth()->user()->id.'"]';
        // }
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
            $user_levels = UserLevels::findOrNew($data->id);
            $user_levels->user_id = $data->id;
            $user_levels->role_id = json_encode($request->role_level);
            if($user_levels->save()){
                return redirect()->route('users.supplier.index')->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>1]);

            }
        }
        else{
            return redirect()->back()->withInput();
        }
    }

    public function update($id,Request $request){
        $this->validate($request,[
            'role_level' => 'required'
        ],[
            'role_level.required' => 'حقل الصلاحية مطلوب',
        ]);
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
        $data->user_role = json_encode($request->role_level);
        if ($data->save()) {
            return redirect()->route('users.supplier.edit', ['id'=>$id])->with(['success'=>'تم تعديل البيانات بنجاح','tab_id'=>1]);
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function update_user_ajax(Request $request){
        $data = User::where('id',$request->id)->first();

        if ($request->has('data_type')) {
            if ($request->data_type == 'email'){
                $rules['value'] = 'required|email|unique:users,email,'.$request->id;
                $validator = Validator::make($request->all(),$rules,[
                    'required'=>'يجب تعبئة الحقول المناسبة',
                    'email'=>'يجب اضافة حقل بريد الكتروني صالح',
                    'unique'=>'هذا الايميل مستخدم من قبل'
                ]);

                if ($validator->fails()){
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->first()
                    ]);
                }
            }
        }

        if($request->filled('password')){
            $data->{$request->data_type} = bcrypt($request->input('value'));
        }
        $data->{$request->data_type} = $request->input('value');

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

    public function upload_image(Request $request){
        $data = User::where('id',$request->id)->first();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('user_photo', $filename, 'public');
            $data->user_photo = $filename;
            if ($data->save()){
                return response()->json([
                    'success'=>'true',
                    'message'=>'تم رفع الصورة بنجاح'
                ]);
            }
            else{
                return response()->json([
                    'success'=>'false',
                    'message'=>'هناك خطا ما في رفع الصورة'
                ]);
            }
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'لم يتم رفع الصورة'
            ]);
        }

    }
}
