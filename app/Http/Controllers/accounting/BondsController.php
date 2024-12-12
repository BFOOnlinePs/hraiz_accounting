<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\BankModel;
use App\Models\BondsModel;
use App\Models\Currency;
use App\Models\DocAmountModel;
use App\Models\InvoiceItemsModel;
use App\Models\PurchaseInvoicesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
class BondsController extends Controller
{
    public function index(){
        $data = BondsModel::orderBy('id','desc')->get();
        $invoices = PurchaseInvoicesModel::where('invoice_type','sales')->get();
        $currencies = Currency::get();
        $users = User::whereJsonContains('user_role',['2'])->get();
        $clients = User::whereJsonContains('user_role',['10'])->get();
        $banks = BankModel::get();
        return view('admin.accounting.bonds.payment_bond.index',['data'=>$data,'invoices'=>$invoices,'currencies'=>$currencies,'users'=>$users,'clients'=>$clients , 'banks'=>$banks]);
    }

    public function create(Request $request){
        $data = new BondsModel();
        // ترحيل فاتورة
        $doc_amount = new DocAmountModel();

        if ($request->invoice_modal_type == 'invoice'){
            $client = PurchaseInvoicesModel::where('id',$request->invoice_id)->first()->client_id;
            $data->invoice_id = $request->invoice_id;
            $data->client_id = $client;
            $doc_amount->client_id = $client;
        }
        else{
            $data->invoice_id = -1;
            $data->client_id = $request->client_id;
            $doc_amount->client_id = $request->client_id;
        }
        $data->amount = $request->amount;
        $data->reference_number = $request->reference_number;
        $data->notes = $request->notes;
        $data->currency_id = $request->currency_id;
        // $data->payment_type = $request->customRadio;
        $data->payment_type = 'cash';
        $data->insert_by = auth()->user()->id;
        $data->check_number = $request->check_number;
        $data->due_date = $request->due_date;
        $data->bank_id = $request->bank_id;
        $data->invoice_type = 'payment_bond';
        if (!$request->check_number == ''){
            $data->check_type = 'outgoing';
            $data->check_status = $request->check_status;
        }



        if ($data->save()){
            $doc_amount->type = 'payment_bond';
        $doc_amount->invoice_id = $data->id;
        $doc_amount->amount = $request->amount;
        $doc_amount->reference_number = $request->reference_number;
        $doc_amount->currency = $request->currency_id;
        $doc_amount->save();
            return redirect()->route('accounting.bonds.payment_bond.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.bonds.payment_bond.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function payment_bond_check_create(Request $request)
    {
        $checkData = $request->input('checks'); // Assuming checks[] is the array of checks in the form
        $successCount = 0;

        foreach ($checkData as $i => $check) {
            // Validate required fields before processing

            $data = new BondsModel();
            $doc_amount = new DocAmountModel();

            // Determine client and invoice based on the type
            if ($request->invoice_modal_type == 'invoice') {
                $client = PurchaseInvoicesModel::where('id', $request->invoice_id)->first()->client_id;
                $data->invoice_id = $request->invoice_id;
                $data->client_id = $client;
                $doc_amount->client_id = $client;
            } else {
                $data->invoice_id = -1;
                $data->client_id = $request->client_id;
                $doc_amount->client_id = $request->client_id;
            }

            // Populate fields from each check data
            $data->amount = $check['amount'];
            $data->reference_number = $check['reference_number'] ?? null; // Handle optional reference number
            // $data->client_id = $check['client_id'] ?? null; // Handle optional reference number
            $data->client_id = $request->client_id ?? null; // Handle optional reference number
            $data->notes = $check['notes'] ?? ''; // Ensure notes is set to empty string if not provided
            $data->currency_id = $check['currency_id'];
            $data->payment_type = 'check';
            $data->insert_by = auth()->user()->id;
            $data->check_number = $check['check_number'];
            $data->due_date = $check['due_date'];
            $data->bank_id = $check['bank_id'];
            $data->invoice_type = 'payment_bond';


            // Handle front image upload
        if ($request->hasFile("checks.$i.front_image")) {
            $frontImage = $request->file("checks.$i.front_image");
            $frontImagePath = $frontImage->store('checks/front', 'public'); // Store in public/storage/checks/front
            $data->front_image = $frontImagePath; // Save the path in the database
        }

        // Handle rear image upload
        if ($request->hasFile("checks.$i.rear_image")) {
            $rearImage = $request->file("checks.$i.rear_image");
            $rearImagePath = $rearImage->store('checks/rear', 'public'); // Store in public/storage/checks/rear
            $data->rear_image = $rearImagePath; // Save the path in the database
        }

            // Set check type and status if check number is provided
            if (!empty($check['check_number'])) {
                $data->check_type = 'incoming';
                $data->check_status = $check['check_status'] ?? 'under_collection'; // Handle optional check status
            }


            if ($data->save()) {
                $doc_amount->type = 'payment_bond';
                $doc_amount->invoice_id = $data->id;
                $doc_amount->amount = $check['amount'];
                $doc_amount->reference_number = $check['reference_number'] ?? null; // Optional reference number
                $doc_amount->currency = $check['currency_id'];
                $doc_amount->save();

                $successCount++;
            }
        }

        if ($successCount > 0) {
            return redirect()->route('accounting.bonds.payment_bond.index')
                ->with(['success' => 'تم اضافة البيانات بنجاح']);
        } else {
            return redirect()->route('accounting.bonds.payment_bond.index')
                ->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit_payment_bonds($id){
        $data = BondsModel::where('id',$id)->first();
        $currency = Currency::get();
        $clients = User::get();
        return view('admin.accounting.bonds.payment_bond.edit',['data'=>$data,'currency'=>$currency]);
    }

    public function update_payment_bonds(Request $request){
        $data = BondsModel::where('id',$request->id)->first();
        $data->amount = $request->amount;
        $data->notes = $request->notes;
        $data->currency_id = $request->currency_id;
        $data->payment_type = $request->customRadio;
        $data->insert_by = auth()->user()->id;
        $data->check_number = $request->check_number;
        $data->due_date = $request->due_date;
        $data->bank_id = $request->bank_id;
        if ($data->save()){
            return redirect()->route('accounting.bonds.payment_bond.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.bonds.payment_bond.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function bonds_table_ajax(Request $request){
        $data = BondsModel::with('bank')->where('invoice_type','payment_bond')
        // ->whereIn('invoice_id',function ($query) use ($request){
        //     $query->select('id')->from('bfo_invoices')->where('client_id','like','%'.$request->client_id.'%')->get();
        // })
        ->when($request->filled('reference_number'),function ($query) use ($request){
            $query->where('reference_number','like','%'.$request->reference_number.'%')->get();
        })
          ->when($request->filled('payment_type'),function ($query) use ($request){
                $query->where('payment_type','like','%'.$request->payment_type.'%')->get();
          })
            ->when($request->filled('insert_by'),function ($query) use ($request){
                $query->where('insert_by','like','%'.$request->insert_by.'%')->get();
            })->
            orderBy('id','desc')->get();
        foreach ($data as $key){
            $key->currency = Currency::where('id',$key->currency_id)->first();
            $key->users = User::where('id',$key->insert_by)->first();
            $key->invoice = PurchaseInvoicesModel::where('id',$key->invoice_id)->first();
        }
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.bonds.payment_bond.ajax.bonds_table',['data'=>$data])->render()
        ]);
    }

    public function performance_bond_index(){
        $data = BondsModel::with('bank')->where('invoice_type','performance_bond')->get();
        $invoices = PurchaseInvoicesModel::where('invoice_type','purchases')->get();
        $currencies = Currency::get();
        $users = User::whereJsonContains('user_role',['2'])->get();
        $clients = User::whereJsonContains('user_role',['4'])->orWhereJsonContains('user_role',['10'])->get();
        $banks = BankModel::get();
        return view('admin.accounting.bonds.performance_bond.index',['data'=>$data,'invoices'=>$invoices,'currencies'=>$currencies,'users'=>$users,'clients'=>$clients , 'banks'=>$banks]);
    }

    public function performance_bonds_table_ajax(Request $request){
        $data = BondsModel::with('bank')->where('invoice_type','performance_bond')->when($request->filled('reference_number'),function ($query) use ($request){
            $query->where('reference_number','like','%'.$request->reference_number.'%')->get();
        })
            ->when($request->filled('client_id'),function ($query) use ($request){
                $query->where('client_id','like','%'.$request->client_id.'%')->get();
            })
            ->when($request->filled('payment_type'),function ($query) use ($request){
                $query->where('payment_type','like','%'.$request->payment_type.'%')->get();
            })
            ->when($request->filled('insert_by'),function ($query) use ($request){
                $query->where('insert_by','like','%'.$request->insert_by.'%')->get();
            })
            ->orderBy('id','desc')
            ->get();
        foreach ($data as $key){
            $key->currency = Currency::where('id',$key->currency_id)->first();
            $key->users = User::where('id',$key->insert_by)->first();
            $key->invoice = PurchaseInvoicesModel::where('id',$key->invoice_id)->first();
            $key->client = User::where('id',$key->client_id)->first();
        }
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.bonds.performance_bond.ajax.performance_bonds_table',['data'=>$data])->render()
        ]);
    }

    public function performance_bond_create(Request $request){
        $data = new BondsModel();
        // ترحيل فاتورة
        $doc_amount = new DocAmountModel();
        if ($request->invoice_modal_type == 'invoice'){
            $client = PurchaseInvoicesModel::where('id',$request->invoice_id)->first()->client_id;
            $data->invoice_id = $request->invoice_id;
            $data->client_id = $client;
            $doc_amount->client_id = $client;
        }
        else{
            $data->invoice_id = -1;
            $data->client_id = $request->client_id;
            $doc_amount->client_id = $request->client_id;
        }
        $data->amount = $request->amount;
        $data->reference_number = $request->reference_number;
        $data->notes = $request->notes;
        $data->currency_id = $request->currency_id;
        $data->payment_type = 'cash';
        $data->insert_by = auth()->user()->id;
        $data->check_number = $request->check_number;
        $data->due_date = $request->due_date;
        $data->bank_id = $request->bank_id;
        $data->invoice_type = 'performance_bond';
        if (!$request->check_number == ''){
            $data->check_type = 'incoming';
            $data->check_status = $request->check_status;
        }

        if ($data->save()){

            $doc_amount->type = 'performance_bond';
            $doc_amount->invoice_id = $data->id;
            $doc_amount->amount = $request->amount;
            $doc_amount->reference_number = $request->reference_number;
            $doc_amount->currency = $request->currency_id;
            $doc_amount->save();


            return redirect()->route('accounting.bonds.performance_bond.performance_bond_index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.bonds.performance_bond.performance_bond_index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }


    public function performance_bond_check_create(Request $request)
    {
        $checkData = $request->input('checks'); // Assuming checks[] is the array of checks in the form
        $successCount = 0;

        foreach ($checkData as $i => $check) {
            // Validate required fields before processing

            $data = new BondsModel();
            $doc_amount = new DocAmountModel();

            // Determine client and invoice based on the type
            if ($request->invoice_modal_type == 'invoice') {
                $client = PurchaseInvoicesModel::where('id', $request->invoice_id)->first()->client_id;
                $data->invoice_id = $request->invoice_id;
                $data->client_id = $client;
                $doc_amount->client_id = $client;
            } else {
                $data->invoice_id = -1;
                $data->client_id = $request->client_id;
                $doc_amount->client_id = $request->client_id;
            }

            // Populate fields from each check data
            $data->amount = $check['amount'];
            $data->reference_number = $check['reference_number'] ?? null; // Handle optional reference number
            // $data->client_id = $check['client_id'] ?? null; // Handle optional reference number
            $data->client_id = $request->client_id ?? null; // Handle optional reference number
            $data->notes = $check['notes'] ?? ''; // Ensure notes is set to empty string if not provided
            $data->currency_id = $check['currency_id'];
            $data->payment_type = 'check';
            $data->insert_by = auth()->user()->id;
            $data->check_number = $check['check_number'];
            $data->due_date = $check['due_date'];
            $data->bank_id = $check['bank_id'];
            $data->invoice_type = 'performance_bond';


            // Handle front image upload
        if ($request->hasFile("checks.$i.front_image")) {
            $frontImage = $request->file("checks.$i.front_image");
            $frontImagePath = $frontImage->store('checks/front', 'public'); // Store in public/storage/checks/front
            $data->front_image = $frontImagePath; // Save the path in the database
        }

        // Handle rear image upload
        if ($request->hasFile("checks.$i.rear_image")) {
            $rearImage = $request->file("checks.$i.rear_image");
            $rearImagePath = $rearImage->store('checks/rear', 'public'); // Store in public/storage/checks/rear
            $data->rear_image = $rearImagePath; // Save the path in the database
        }

            // Set check type and status if check number is provided
            if (!empty($check['check_number'])) {
                $data->check_type = 'incoming';
                $data->check_status = $check['check_status'] ?? 'under_collection'; // Handle optional check status
            }


            if ($data->save()) {
                $doc_amount->type = 'performance_bond';
                $doc_amount->invoice_id = $data->id;
                $doc_amount->amount = $check['amount'];
                $doc_amount->reference_number = $check['reference_number'] ?? null; // Optional reference number
                $doc_amount->currency = $check['currency_id'];
                $doc_amount->save();

                $successCount++;
            }
        }

        if ($successCount > 0) {
            return redirect()->route('accounting.bonds.performance_bond.performance_bond_index')
                ->with(['success' => 'تم اضافة البيانات بنجاح']);
        } else {
            return redirect()->route('accounting.bonds.performance_bond.performance_bond_index')
                ->with(['fail' => 'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit_performance_bonds($id){
        $data = BondsModel::where('id',$id)->first();
        $currency = Currency::get();
        return view('admin.accounting.bonds.performance_bond.edit',['data'=>$data,'currency'=>$currency]);
    }

    public function update_performance_bond(Request $request){
        $data = BondsModel::where('id',$request->id)->first();
        $data->amount = $request->amount;
        $data->notes = $request->notes;
        $data->currency_id = $request->currency_id;
        $data->payment_type = $request->customRadio;
        $data->insert_by = auth()->user()->id;
        $data->check_number = $request->check_number;
        $data->due_date = $request->due_date;
        $data->bank_id = $request->bank_id;
        if ($data->save()){
            return redirect()->route('accounting.bonds.performance_bond.performance_bond_index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.bonds.performance_bond.performance_bond_index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function edit_check_payment_type(Request $request){
        $data = BondsModel::where('id',$request->id)->first();
        $data->check_number = $request->check_number;
        $data->due_date = $request->due_date;
        $data->bank_id = $request->bank_id;
        if ($data->save()){
//            return red
        }
        else{

        }
    }

    public function get_amount_for_invoice(Request $request){
        $data = InvoiceItemsModel::where('invoice_id',$request->invoice_id)->sum('rate');
        return response()->json([
            'success' => 'true',
            'data' => $data
        ]);
    }

    public function list_invoice_for_payment_bond_clients_table_ajax(Request $request){
        $reference_number = $request->input('reference_number');
        $client_name = $request->input('client_name');

        $query = PurchaseInvoicesModel::query();
        if ($reference_number){
            $query->where(function ($q) use ($reference_number){
                $q->where('invoice_reference_number','like','%'.$reference_number.'%');
            });
        }
        if ($client_name){
            $query->where(function ($q) use ($client_name){
                $q->whereIn('client_id',function ($q) use ($client_name){
                    $q->select('id')->from('users')->where('name','like','%'.$client_name.'%');
                });
            });
        }
        $data = $query->where('invoice_type','sales')->orderBy('id','desc')->paginate(10);
        foreach ($data as $key){
            $key->client = User::where('id',$key->client_id)->first();
            $key->total_amount = $key->totalAmount(); // احسب المجموع هنا
        }
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.bonds.payment_bond.ajax.list_invoice_clients',['data'=>$data])->render(),
            'pagination' => $data->links()->toHtml(),
        ]);
    }
    public function list_invoice_for_performance_bond_clients_table_ajax(Request $request){
        $reference_number = $request->input('reference_number');
        $client_name = $request->input('client_name');

        $query = PurchaseInvoicesModel::query();
        if ($reference_number){
            $query->where(function ($q) use ($reference_number){
                $q->where('invoice_reference_number','like','%'.$reference_number.'%');
            });
        }
        if ($client_name){
            $query->where(function ($q) use ($client_name){
                $q->whereIn('client_id',function ($q) use ($client_name){
                    $q->select('id')->from('users')->where('name','like','%'.$client_name.'%');
                });
            });
        }
        $data = $query->where('invoice_type','purchases')->paginate(10);
        foreach ($data as $key){
            $key->client = User::where('id',$key->client_id)->first();
            $key->total_amount = $key->totalAmount();
        }
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.bonds.payment_bond.ajax.list_invoice_clients',['data'=>$data])->render(),
            'pagination' => $data->links()->toHtml(),
        ]);
    }

    public function update_check_information(Request $request){
        $data = BondsModel::where('id',$request->bonds_id)->first();
        $data->check_number = $request->check_number;
        $data->due_date = $request->due_date;
        $data->bank_id = $request->bank_id;
        $data->check_status = $request->check_status;
        if ($data->save()){
            return response()->json([
                'success' => 'true',
                'message' => 'تم تعديل معلومات البنك بنجاح'
            ]);
        }
    }

    public function registration_bonds_index()
    {
        $client = User::whereJsonContains('user_role','4')->orWhereJsonContains('user_role','10')->get();
        $currency = Currency::get();
        return view('admin.accounting.bonds.registration_bonds.index',['client'=>$client,'currency'=>$currency]);
    }

    public function registration_bonds_list_ajax(Request $request)
    {
        $data = BondsModel::where('invoice_type','registration_bonds')->get();
        foreach ($data as $key){
            $key->client = User::where('id',$key->client_id)->first();
            $key->currency = Currency::where('id',$key->currency_id)->first();
        }
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.bonds.registration_bonds.ajax.registration_bonds_list',['data'=>$data])->render()
        ]);
    }

    public function create_registration_bonds(Request $request)
    {
        $data = new BondsModel();
//        $data->invoice_id = $request->invoice_id;
        $data->invoice_id = -1;
        $data->client_id = $request->client_id;
        $data->amount = $request->amount;
        $data->notes = $request->notes;
        $data->currency_id = $request->currency_id;
        $data->payment_type = $request->payment_type;
        $data->insert_by = auth()->user()->id;
        $data->check_number = $request->check_number;
        $data->due_date = $request->due_date;
        $data->bank_id = $request->bank_id;
        $data->invoice_type = 'registration_bonds';
        $data->check_status = $request->check_status;
        $data->debt_credit = $request->debt_credit;

        $doc_amount = new DocAmountModel();
        if ($request->cash_for_client == 'cash'){
            $data->payment_type = 'cash';
        }
        else{
            $data->payment_type = 'cash';
        }
        if($request->debt_credit == 'debt'){
            $data->check_type = 'incoming';
            $data->debt_credit = 'debt';
            $doc_amount->type = 'registration_bond_debt';
        }
        else{
            $data->debt_credit = 'credit';
            $data->check_type = 'outgoing';
            $doc_amount->type = 'registration_bond_credit';
        }
        $doc_amount->invoice_id = -1;
        $doc_amount->amount = $request->amount;
        $doc_amount->currency = $request->curreny_id;
        $doc_amount->client_id = $request->client_id;
        $doc_amount->save();
        if ($data->save()){
            return redirect()->route('accounting.bonds.registration_bonds.registration_bonds_index')->with('تم اضافة سند القيد بنجاح');
        }
    }

    public function details($id){
        $data = BondsModel::where('id',$id)->first();
        $currencies = Currency::get();
        return view('admin.accounting.bonds.payment_bond.details',['data'=>$data , 'currencies'=>$currencies]);
    }

    public function list_check_ajax(Request $request){
        $data = BondsModel::where('payment_type','check')->where('check_number','like','%'.$request->check_number.'%')->take(10)->get();
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.bonds.performance_bond.ajax.list_check',['data'=>$data])->render()
        ]);
    }

    public function bonds_pdf($id){
        $data = BondsModel::where('id',$id)->first();
        $currencies = Currency::get();
        $pdf = PDF::loadView('admin.accounting.bonds.pdf.bonds_details_pdf',['data'=>$data , 'currencies'=>$currencies]);
        return $pdf->stream('order_sales.pdf');
    }
}
