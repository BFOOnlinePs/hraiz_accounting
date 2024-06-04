<?php

namespace App\Http\Controllers\procurement_officer;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\CashPaymentsModel;
use App\Models\CurrencyModel;
use App\Models\LetterBankModel;
use App\Models\LetterBankModificationModel;
use App\Models\OrderModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancialFileController extends Controller
{
    public $progress_status = 4;
    public function index($order_id)
    {
        $order = OrderModel::where('id', $order_id)->first();
        $order->user = User::where('id',$order->user_id)->first();
        $order->to_user = User::where('id',$order->to_user)->first();
        $cash_payment = CashPaymentsModel::where('order_id', $order_id)->get();
        foreach ($cash_payment as $key) {
            $key->user_name = User::where('id', $key->user_id)->first();
            $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
        }
        $letter_bank = LetterBankModel::where('order_id', $order_id)->get();
        foreach ($letter_bank as $key) {
            $key->user_name = User::where('id', $key->user_id)->first();
            $key->bank_name = BankModel::where('id', $key->bank_id)->first();
            $key->modifications = $this->getExtentionId($key->id);
            $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
        }
        $banks = BankModel::get();
        $currency = CurrencyModel::get();
        return view('admin.orders.procurement_officer.financial_file.index', ['order' => $order,'currency'=>$currency, 'cash_payment' => $cash_payment, 'banks' => $banks, 'letter_bank' => $letter_bank]);
    }

    public function create_cash_payment(Request $request)
    {
        $check_progress_status = OrderModel::where('id',$request->order_id)->first();

        $data = new CashPaymentsModel();
        $data->order_id = $request->order_id;
        $data->payment_type = $request->payment_type;
        $data->amount = $request->amount;
        $data->persent = $request->persent;
        $data->payment_status = $request->payment_status;
        $data->due_date = $request->due_date;

        if (($check_progress_status->progress_status) <= $this->progress_status){
            $check_progress_status->progress_status = $this->progress_status;
            $check_progress_status->save();
        }

        $data->payment_date = $request->payment_date;
        $data->notes = $request->notes;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->user_id = auth()->user()->id;
        $data->insert_at = Carbon::now();
        $data->currency_id = $request->currency_id;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.financial_file.index', ['order_id' => $request->order_id])->with(['success' => 'تم اضافة البيانات بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.financial_file.index', ['order_id' => $request->order_id])->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function create_letter_bank(Request $request)
    {
        $data = new LetterBankModel();
        $data->order_id = $request->order_id;
        $data->letter_type = $request->letter_type;
        $data->letter_value = $request->letter_value;
        $data->bank_id = $request->bank_id;
        $data->notes = $request->notes;
        $data->due_date = $request->due_date;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->user_id = auth()->user()->id;
        $data->status = 1;
        $data->duration_days = $request->duration_days;
        $data->currency_id = $request->currency_id;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.financial_file.index', ['order_id' => $request->order_id])->with(['success' => 'تم اضافة البيانات بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.financial_file.index', ['order_id' => $request->order_id])->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit_cash_payment($id)
    {
        $data = CashPaymentsModel::find($id);
        $currency = CurrencyModel::get();
        return view('admin.orders.procurement_officer.financial_file.cash_payment.edit', ['data' => $data,'currency'=>$currency]);
    }

    public function update_cash_payment(Request $request)
    {
        $data = CashPaymentsModel::find($request->id);
        $data->amount = $request->amount;
        $data->payment_type = $request->payment_type;
        $data->persent = $request->persent;
        $data->due_date = $request->due_date;
        $data->payment_date = $request->payment_date;
        $data->notes = $request->notes;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->user_id = auth()->user()->id;
        $data->insert_at = Carbon::now();
        $data->currency_id = $request->currency_id;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.financial_file.index', ['order_id' => $data->order_id])->with(['success' => 'تم تعديل البيانات بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.financial_file.index', ['order_id' => $data->order_id])->with(['fail' => 'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function delete_cash_payment($id)
    {
        $data = CashPaymentsModel::find($id);
        if ($data->delete()) {
            return redirect()->back()->with(['success' => 'تم حذف الباينات بنجاح']);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم حذف البيانات']);
        }
    }

    public function edit_letter_bank($id)
    {
        $data = LetterBankModel::find($id);
        $banks = BankModel::get();
        $currency = CurrencyModel::get();
        return view('admin.orders.procurement_officer.financial_file.letter_bank.edit', ['data' => $data, 'banks' => $banks,'currency'=>$currency]);
    }

    public function update_letter_bank(Request $request)
    {
        $data = LetterBankModel::find($request->id);
        $data->letter_type = $request->letter_type;
        $data->letter_value = $request->letter_value;
        $data->bank_id = $request->bank_id;
        $data->notes = $request->notes;
        $data->due_date = $request->due_date;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->user_id = auth()->user()->id;
        $data->status = 1;
        $data->duration_days = $request->duration_days;
        $data->currency_id = $request->currency_id;
        if ($data->save()) {
            return redirect()->route('procurement_officer.orders.financial_file.index', ['order_id' => $data->order_id])->with(['success' => 'تم اضافة البيانات بنجاح']);
        } else {
            return redirect()->route('procurement_officer.orders.financial_file.index', ['order_id' => $data->order_id])->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function delete_letter_bank($id)
    {
        $data = LetterBankModel::find($id);
        if ($data->delete()) {
            return redirect()->back()->with(['success' => 'تم حذف الباينات بنجاح']);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم حذف البيانات']);
        }
    }

    public function index_extension($letter_bank_id)
    {
        $data = LetterBankModificationModel::where('letter_bank_id', $letter_bank_id)->get();
        foreach ($data as $key) {
            $key->user = User::where('id', $key->insert_by)->first();
        }
        return view('admin.orders.procurement_officer.financial_file.letter_bank.extension', ['data' => $data, 'letter_bank_id' => $letter_bank_id]);
    }

    function getExtentionId($id)
    {
        $data = LetterBankModificationModel::where('letter_bank_id', $id)->get();
        return $data;
    }

    public function create_extension(Request $request)
    {
        $data = new LetterBankModificationModel();
        $data->letter_bank_id = $request->letter_bank_id;
        $data->new_due_date = $request->new_due_date;
        $data->notes = $request->notes;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->insert_by = auth()->user()->id;
        if ($data->save()) {
            return redirect()->back()->with(['success' => 'تم اضافة البيانات بنجاح']);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit_extension($id)
    {
        $data = LetterBankModificationModel::find($id);
        return view('admin.orders.procurement_officer.financial_file.letter_bank.edit_extension', ['data' => $data]);
    }

    public function update_extension(Request $request)
    {
        $data = LetterBankModificationModel::find($request->id);
        $data->new_due_date = $request->new_due_date;
        $data->notes = $request->notes;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('attachment', $filename, 'public');
            $data->attachment = $filename;
        }
        $data->insert_by = auth()->user()->id;
        if ($data->save()) {
            return redirect()->back()->with(['success' => 'تم تعديل البيانات بنجاح']);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function delete_extension($id)
    {
        $data = LetterBankModificationModel::find($id);
        if ($data->delete()) {
            return redirect()->back()->with(['success' => 'تم حذف البيانات بنجاح']);
        } else {
            return redirect()->back()->with(['fail' => 'هناك خلل ما لم يتم حذف البيانات']);
        }
    }

    public function updatePaymentStatus(Request $request){
        $data = CashPaymentsModel::find($request->id);
        $data->payment_status = $request->payment_status;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'data'=>$data
            ]);
        }
    }

    public function edit_cash_payment_note(Request $request){
        $data = CashPaymentsModel::where('id',$request->note_id)->first();
        $data->notes = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }

    public function edit_letter_bank_note(Request $request){
        $data = LetterBankModel::where('id',$request->note_id)->first();
        $data->notes = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }

    public function edit_letter_bank_modification_note(Request $request){
        $data = LetterBankModificationModel::where('id',$request->note_id)->first();
        $data->notes = $request->note_text;
        if($data->save()){
            return redirect()->back()->with(['success'=>'تم التعديل بنجاح']);
        }
        else{
            return redirect()->back()->with(['fail'=>'هناك خلل ما لم يتم التعديل بنجاح']);
        }
    }
}
