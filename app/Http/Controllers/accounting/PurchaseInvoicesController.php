<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\DocAmountModel;
use App\Models\InvoiceItemsModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\OrdersSalesItemsModel;
use App\Models\PriceOfferItemsModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\PurchaseInvoicesModel;
use App\Models\SystemSettingModel;
use App\Models\TaxesModel;
use App\Models\User;
use App\Models\WhereHouseModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use PDF;

class PurchaseInvoicesController extends Controller
{
    public function index(){
        $data = PurchaseInvoicesModel::get();
        $order = OrderModel::get();
        $users = User::whereJsonContains('user_role',['4'])->orWhereJsonContains('user_role',['10'])->get();
        // $order = OrderModel::whereIn('id',function($query){
        //     $query->from('price_offers')->where('status', 1)->select('id')->get();
        // })->get();
        return view('admin.accounting.purchase_invoices.index',['data'=>$data,'order'=>$order,'users'=>$users]);
    }

    public function invoice_table_index_ajax(Request $request){
        $from = Carbon::parse($request->from_date)->startOfDay();
        $to = Carbon::parse($request->to_date)->endOfDay();
        $data = PurchaseInvoicesModel::where('invoice_type','purchases')->when(!empty($request->supplier_user_id),function ($query) use ($request){
            $query->where('client_id','like','%'.$request->supplier_user_id.'%');
        })->when(!empty($request->from_date) && !empty($request->to_date) , function($query) use ($from,$to){
            $query->whereBetween('bill_date',[$from,$to]);
        })->when(!empty($request->invoice_status),function($query) use ($request){
            $query->where('status',$request->invoice_status);
        })->when(!empty($request->invoice_reference_number),function ($query) use ($request){
            $query->where('invoice_reference_number','like','%'.$request->invoice_reference_number.'%');
        })->where('deleted',0)->orderBy('id','desc')->paginate(10);
        foreach ($data as $key){
            $key->totalAmount =InvoiceItemsModel::where('invoice_id',$key->id)
                ->sum('rate');
        }
        $order = OrderModel::orderBy('id','desc')->get();
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.accounting.purchase_invoices.ajax.invoice_table',['data'=>$data,'order'=>$order])->render(),
        ]);
        // $data = PurchaseInvoicesModel::when(!empty($request->supplier_user_id),function ($query) use ($request){
        //     $query->where('client_id','like','%'.$request->supplier_user_id.'%');
        // })->when(!empty($request->invoice_reference_number),function ($query) use ($request){
        //     $query->where('invoice_reference_number','like','%'.$request->invoice_reference_number.'%');
        // })->orderBy('id','desc')->paginate(10);
        // $order = OrderModel::get();
        // return response()->json([
        //     'success'=>'true',
        //     'view'=>view('admin.accounting.purchase_invoices.ajax.invoice_table',['data'=>$data,'order'=>$order])->render(),
        // ]);
    }

    public function new_invoices_index(){
        $client = User::whereJsonContains('user_role',['4'])->orwhereJsonContains('user_role',['10'])->get();
        $taxes = TaxesModel::get();
        $currency = Currency::get();
        $wherehouses = WhereHouseModel::get();
        $get_invoice_order_number = PurchaseInvoicesModel::latest('id')->first()->id + 1;
        return view('admin.accounting.purchase_invoices.new_invoice.index',['client'=>$client,'taxes'=>$taxes,'wherehouses'=>$wherehouses , 'currency'=>$currency , 'get_invoice_order_number'=>$get_invoice_order_number]);
    }

    public function create_new_invoices(Request $request){
        $data = new PurchaseInvoicesModel();
        $data->invoice_reference_number = $request->invoice_reference_number;
        $data->client_id = $request->client_id;
        $data->project_id = $request->project_id;
        $data->bill_date = $request->bill_date;
        $data->due_date = $request->due_date;
        $data->note = $request->note;
        $data->tax_id = $request->tax_id;
        $data->tax_id2 = $request->tax_id2;
        $data->currency_id = $request->currency_id;
        $data->repeat_every = $request->repeat_every;
        $data->repeat_type = $request->repeat_type;
        $data->no_of_cycles	= $request->no_of_cycles;
        $data->invoice_type	= 'purchases';
        $data->wherehouse_id = $request->wherehouse_id;
        if($data->save()){
            return redirect()->route('accounting.purchase_invoices.invoice_view',['id'=>$data->id])->with(['success'=>'تم انشاء البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.purchase_invoices.invoice_view',['id'=>$data->id])->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات بنجاح']);
        }
    }

    public function edit_invoices($id){
        $data = PurchaseInvoicesModel::find($id);
        $data->user = User::where('id',$data->client_id)->first();
        $client = User::whereJsonContains('user_role',['10'])->get();
        return view('admin.accounting.purchase_invoices.new_invoice.edit',['data'=>$data,'client'=>$client]);
    }

    public function update_invoices(Request $request){
        $data = PurchaseInvoicesModel::find($request->id);
        $data->invoice_reference_number = $request->invoice_reference_number;
        $data->client_id = $request->client_id;
        $data->project_id = $request->project_id;
        $data->bill_date = $request->bill_date;
        $data->due_date = $request->due_date;
        $data->note = $request->note;
        $data->tax_id = $request->tax_id;
        $data->tax_id2 = $request->tax_id2;
        $data->repeat_every = $request->repeat_every;
        $data->repeat_type = $request->repeat_type;
        $data->no_of_cycles	= $request->no_of_cycles;
        if($data->save()){
            return redirect()->route('accounting.purchase_invoices.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.purchase_invoices.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات بنجاح']);
        }
    }

    public function delete_invoices($id){
        $data = PurchaseInvoicesModel::find($id);
        $data->deleted = 1;
        if($data->save()){
            return redirect()->route('accounting.purchase_invoices.index')->with(['success'=>'تم حذف البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.purchase_invoices.index')->with(['fail'=>'هناك خلل ما لم يتم حذف البيانات بنجاح']);
        }
    }

    public function invoice_view($id){
        $wherehouses = WhereHouseModel::get();
        $purchase_invoice = PurchaseInvoicesModel::where('id',$id)->first();
        if ($purchase_invoice != null) {
            $purchase_invoice->tax = TaxesModel::where('id', $purchase_invoice->tax_id)->first();
            $purchase_invoice->order = OrderModel::where('id',$purchase_invoice->order_id)->first();
            $data = PurchaseInvoicesModel::find($id);
            $data->user = User::where('id',$data->client_id)->first();
            $taxes = TaxesModel::get();
            $data->tax = TaxesModel::where('id',$data->tax_id)->first();
            $invoice = InvoiceItemsModel::where('invoice_id',$id)->get();
            foreach($invoice as $key){
                $key->product = ProductModel::where('id',$key->item_id)->first();
            }
            $users = User::get();
            return view('admin.accounting.purchase_invoices.invoices.view',['data'=>$data,'invoice'=>$invoice,'taxes'=>$taxes,'purchase_invoice'=>$purchase_invoice,'users'=>$users,'wherehouses'=>$wherehouses]);
        }
        return redirect()->back();
    }

    public function invoice_table(Request $request){
        $invoice = PurchaseInvoicesModel::where('id',$request->invoice_id)->first();
        $data = InvoiceItemsModel::where('invoice_id',$request->invoice_id)->get();
        foreach($data as $key){
            $key->product = ProductModel::where('id',$key->item_id)->first();
            $key->qty = OrderItemsModel::where('order_id',PurchaseInvoicesModel::where('id',$key->invoice_id)->first()->value('order_id'))->where('product_id',$key->item_id)->first();
        }
        // return OrderItemsModel::where('order_id',24)->where('product_id',2328)->first();
        $invoice->tax = TaxesModel::where('id',$invoice->tax_id)->first();
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.accounting.purchase_invoices.invoices.ajax.invoices_table',['data'=>$data,'invoice'=>$invoice])->render(),
        ]);
    }

    public function search_product_ajax(Request $request){
        $data = ProductModel::where('product_name_ar','like','%'.$request->search_product.'%')->whereNotIn('id',function($query) use($request){
            $query->select('item_id')->from('bfo_invoice_items')->where('invoice_id',$request->invoice_id)->get();
        })->paginate(7);
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.accounting.purchase_invoices.invoices.ajax.search_product',['data'=>$data])->render(),
        ]);
    }

    public function create_product_ajax(Request $request){
        $data = new InvoiceItemsModel();
        $data->item_id = $request->item_id;

        // $data->quantity = $request->quantity;
        // $data->unit_type = $request->unit_type;
        // $data->rate = 200;
        $data->invoice_id = $request->invoice_id;
        $data->rate = 1;
        // $data->wherehouse_id = PurchaseInvoicesModel::where('id',$request->invoice_id)->first()->wherehouse_id ?? 0;

        if($data->save()){
            return response()->json([
                'status'=>'true',
                'message'=>'تم اضافة الصنف بنجاح',
            ]);
        }
    }

    // this function for editing qty , price , bonus , discount for invoice view page
    public function edit_inputs_from_invoice(Request $request){
        $data = InvoiceItemsModel::where('id',$request->id)->first();
        if($request->operation == 'qty'){
            $data->quantity = $request->value;
        }
        if($request->operation == 'rate'){
            $data->rate = $request->value;
        }
        if($request->operation == 'discount'){
            $data->discount = $request->value;
        }
        if($request->operation == 'bonus'){
            $data->bonus = $request->value;
        }
        if($data->save()){
            return response()->json([
                'success'=>'true'
            ]);
        }
    }

    public function delete_item(Request $request){
        $data = InvoiceItemsModel::where('id',$request->id)->first();
        if($data->delete()){
            return response()->json([
                'status'=>'true'
            ]);
        }
    }

    public function create_purchase_invoices_from_order(Request $request){
        $data = new PurchaseInvoicesModel();
//        $order = OrderModel::where('id',$request->order_id)->first();
        $data->invoice_reference_number = $request->order_id;
        $data->bill_date = Carbon::now()->toDateString();
        $data->due_date = Carbon::now()->toDateString();
        $data->client_id = $request->supplier_user_id;
        $data->invoice_type = $request->invoice_type;
        if ($request->invoice_type == 'purchases'){
            $data->order_id = $request->order_id;
        }
        else if ($request->invoice_type == 'sales'){
            $data->price_offer_sales_id = $request->order_id;
        }
        $order_items = OrdersSalesItemsModel::where('order_id',$request->order_id)->get();
        if($data->save()){
            foreach($order_items as $key){
                $invoice_items = new InvoiceItemsModel();
                $invoice_items->quantity = $key->qty ?? 0;
//                return PriceOfferItemsModel::where('order_id',$request->order_id)->where('supplier_id',$request->supplier_user_id)->where('product_id',$key->product_id)->value('price');
                $invoice_items->rate = PriceOfferItemsModel::where('order_id',$request->order_id)->where('supplier_id',$request->supplier_user_id)->where('product_id',$key->product_id)->value('price') ?? 0;
                $invoice_items->invoice_id = $data->id;
                $invoice_items->item_id = $key->product_id;
                $invoice_items->save();
            }
            return redirect()->route('accounting.purchase_invoices.invoice_view',['id'=>$data->id])->with(['success'=>'تم انشاء الفاتورة بنجاح']);
        }
    }

    public function update_purchase_invoices_from_ajax(Request $request){
        $data = PurchaseInvoicesModel::where('id',$request->id)->first();
        $message = '';
        if($request->operation == 'bill_date'){
            $data->bill_date = $request->value;
            $message = 'تم تعديل تاريخ الفاتورة بنجاح';
        }
        if($request->operation == 'due_date'){
            $data->due_date = $request->value;
            $message = 'تم تعديل تاريخ التسليم بنجاح';
        }
        if($request->operation == 'client_id'){
            $data->client_id = $request->value;
            $message = 'تم تعديل العميل بنجاح';
        }
        if($request->operation == 'tax_id'){
            $data->tax_id = $request->value;
            $message = 'تم تعديل الضريبة الاولى بنجاح';
        }
        if($request->operation == 'tax_id2'){
            $data->tax_id2 = $request->value;
            $message = 'تم تعديل الضريبة الثانية بنجاح';
        }
        if($request->operation == 'repeat_every'){
            $data->repeat_every = $request->value;
            $message = 'تم تعديل التكرار خلال بنجاح';
        }
        if($request->operation == 'repeat_type'){
            $data->repeat_type = $request->value;
            $message = 'تم تعديل خلال المدة بنجاح';
        }
        if($request->operation == 'no_of_cycles'){
            $data->no_of_cycles = $request->value;
            $message = 'تم تعديل الدورة بنجاح';
        }
        if($request->operation == 'note'){
            $data->note = $request->value;
            $message = 'تم تعديل الملاحظات بنجاح';
        }
        if($request->operation == 'wherehouse_id'){
            $data->note = $request->value;
            $message = 'تم تعديل المخزن بنجاح';
        }
        if($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>$message
            ]);
        }
    }

    public function search_order_ajax(Request $request){
        $data = PriceOffersModel::where('status',1)->whereIn('order_id',function($query) use ($request){
            $query->select('id')->from('orders')->where('reference_number','like','%'.$request->input_search.'%')->get();
        })->when(!empty($request->supplier_id),function($query) use ($request){
            $query->where('supplier_id', $request->supplier_id);
        })->paginate(10);
        foreach($data as $key){
            $key->order = OrderModel::where('id',$key->order_id)->first();
            $key->user = User::where('id',$key->supplier_id)->first();
        }
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.accounting.purchase_invoices.ajax.search_order',['data'=>$data])->render(),
        ]);
    }

    public function update_invoice_reference_number_ajax(Request $request){
        $data = PurchaseInvoicesModel::where('id',$request->id)->first();
        $data->invoice_reference_number = $request->invoice_reference_number;
        if ($data->save()){
            return response()->json([
                'status'=>'true',
                'message'=>'تم تعديل الرقم المرجعي بنجاح'
            ]);
        }
        else{
            return response()->json([
                'status'=>'false',
                'message'=>'هناك خطا ما'
            ]);
        }
    }

    public function update_tax_id_ratio(Request $request){
        $data = PurchaseInvoicesModel::where('id',$request->id)->first();
        $data->tax_id = $request->tax_id;
        if ($data->save()){
            return response()->json([
                'status'=>'true',
                'message'=>'تم تعديل البيانات بنجاح'
            ]);
        }
        else{
            return response()->json([
                'status'=>'false',
                'message'=>'هناك خطا ما'
            ]);
        }
    }

    //TODO ترحيل الفاتورة
    public function invoice_posting($id){
        $data = PurchaseInvoicesModel::where('id',$id)->first();
        $data->status = 'stage';
        $doc_amount = new DocAmountModel();
        $doc_amount->type = 'purchase';
        $doc_amount->invoice_id = $id;
        $doc_amount->reference_number = $data->invoice_reference_number;
        $doc_amount->amount = InvoiceItemsModel::where('invoice_id',$id)->sum(DB::raw('rate * quantity'));
        $doc_amount->client_id = $data->client_id;
        $doc_amount->currency = $data->currency_id;
        $doc_amount->save();
        if ($data->save()){
            return redirect()->route('accounting.purchase_invoices.invoice_view',['id'=>$id])->with(['success'=>'تم ترحيل الفاتورة بنجاح']);
        }
        else{
            return redirect()->route('accounting.purchase_invoices.invoice_view',['id'=>$id])->with(['fail'=>'هناك خلل ما لم يتم ترحيل الفاتورة']);
        }
    }

    public function purchase_invoice_pdf(Request $request){
        $data = PurchaseInvoicesModel::where('id',$request->invoice_id)->first();

//        $purchase_invoice->tax = TaxesModel::where('id', $purchase_invoice->tax_id)->first();
//        $purchase_invoice->order = OrderModel::where('id',$purchase_invoice->order_id)->first();
        $data->user = User::where('id', $data->client_id)->first();
        $taxes = TaxesModel::get();
        $data->tax = TaxesModel::where('id', $data->tax_id)->first();
        $invoice = InvoiceItemsModel::where('invoice_id', $request->invoice_id)->get();
        foreach ($invoice as $key) {
            $key->product = ProductModel::where('id', $key->item_id)->first();
        }

        // حساب المجموع الكلي
        $total = InvoiceItemsModel::where('invoice_id', $request->invoice_id)->sum(DB::raw('rate * quantity'));

        // حساب المجموع المستحق
        $final_total = InvoiceItemsModel::where('invoice_id', $request->invoice_id)->sum(DB::raw('rate * quantity'));

        $system_setting = SystemSettingModel::first();
        $users = User::get();
        $pdf = PDF::loadView('admin.accounting.purchase_invoices.invoices.pdf.purchase_invoice',['data'=>$data,'invoice'=>$invoice,'total'=>$total,'final_total'=>$final_total,'system_setting'=>$system_setting , 'request'=>$request]);
        return $pdf->stream('sales_invoice.pdf');
    }

    public function archive_order(){
        $data = PurchaseInvoicesModel::where('deleted',1)->where('invoice_type','purchases')->get();
        return view('admin.accounting.purchase_invoices.archive.index',['data'=>$data]);
    }

    public function restore_invoices($id){
        $data = PurchaseInvoicesModel::find($id);
        $data->deleted = 0;
        if($data->save()){
            return redirect()->route('accounting.purchase_invoices.archive_order')->with(['success'=>'تم استرجاع البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.purchase_invoices.archive_order')->with(['fail'=>'هناك خطا ما لم يتم استرجاع البيانات بنجاح']);
        }
    }
}
