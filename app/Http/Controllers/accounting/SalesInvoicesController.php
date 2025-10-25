<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\CurrencyModel;
use App\Models\DocAmountModel;
use App\Models\InvoiceItemsModel;
use App\Models\OrderItemsModel;
use App\Models\OrderModel;
use App\Models\OrdersSalesItemsModel;
use App\Models\OrdersSalesModel;
use App\Models\PriceOfferItemsModel;
use App\Models\PriceOfferSalesItemsModel;
use App\Models\PriceOfferSalesModel;
use App\Models\PriceOffersModel;
use App\Models\ProductModel;
use App\Models\PurchaseInvoicesModel;
use App\Models\SystemSettingModel;
use App\Models\TaxesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class SalesInvoicesController extends Controller
{
    public function index(){
        $data = PurchaseInvoicesModel::where('invoice_type','sales')->get();
        $users = User::whereJsonContains('user_role',['10'])->orWhereJsonContains('user_role',['4'])->get();
        return view('admin.accounting.sales_invoices.index',['data'=>$data,'users'=>$users]);
    }

    public function invoice_table_index_ajax(Request $request){
        $from = Carbon::parse($request->from_date)->startOfDay();
        $to = Carbon::parse($request->to_date)->endOfDay();
        $data = PurchaseInvoicesModel::where('invoice_type','sales')->when(!empty($request->supplier_user_id),function ($query) use ($request){
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
            'view'=>view('admin.accounting.sales_invoices.ajax.invoice_table',['data'=>$data,'order'=>$order])->render(),
        ]);
    }

    public function new_invoices_index(){
        $client = User::whereJsonContains('user_role',['10'])->get();
        $taxes = TaxesModel::get();
        $currency = CurrencyModel::get();
        $get_invoice_order_number = PurchaseInvoicesModel::latest('id')->first()->id + 1;
        return view('admin.accounting.sales_invoices.new_invoice.index',['client'=>$client,'taxes'=>$taxes,'currency'=>$currency , 'get_invoice_order_number'=>$get_invoice_order_number]);
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
        $data->repeat_every = $request->repeat_every;
        $data->repeat_type = $request->repeat_type;
        $data->no_of_cycles	= $request->no_of_cycles;
        $data->currency_id	= $request->currency_id;
        $data->invoice_type	= 'sales';
        if($data->save()){
            return redirect()->route('accounting.sales_invoices.invoice_view',['id'=>$data->id])->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.sales_invoices.invoice_view',['id'=>$data->id])->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات بنجاح']);
        }
    }

    public function edit_invoices($id){
        $data = PurchaseInvoicesModel::find($id);
        $data->user = User::where('id',$data->client_id)->first();
        $client = User::whereJsonContains('user_role',['10'])->get();
        $currency = CurrencyModel::get();
        return view('admin.accounting.sales_invoices.new_invoice.edit',['data'=>$data,'client'=>$client,'currency'=>$currency]);
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
        $data->currency_id	= $request->currency_id;
        if($data->save()){
            return redirect()->route('accounting.sales_invoices.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.sales_invoices.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات بنجاح']);
        }
    }

    public function delete_invoices($id){
        $data = PurchaseInvoicesModel::find($id);
        $data->deleted = 1;
        if($data->save()){
            return redirect()->route('accounting.sales_invoices.index')->with(['success'=>'تم حذف البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.sales_invoices.index')->with(['fail'=>'هناك خلل ما لم يتم حذف البيانات بنجاح']);
        }
    }

    public function invoice_view($id)
    {
        // 1. جلب الفاتورة الرئيسية مع العلاقات (user, tax, order)
        // وتم تسميتها $data لتطابق ملف الـ Blade
        $data = PurchaseInvoicesModel::with(['user', 'tax', 'order'])->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'الفاتورة غير موجودة');
        }

        // 2. جلب الأصناف المرتبطة بالفاتورة مع علاقة 'product'
        // وتم تسميتها $invoice لتطابق ملف الـ Blade
        $invoice = InvoiceItemsModel::where('invoice_id', $id)->with('product')->get();

        // 3. جلب البيانات الإضافية
        $taxes = TaxesModel::get();
        $users = User::get();

        // 4. تمرير المتغيرات بالأسماء الصحيحة
        return view('admin.accounting.sales_invoices.invoices.view', [
            'data' => $data,         // $data هو مودل الفاتورة الرئيسي
            'invoice' => $invoice,     // $invoice هي مصفوفة الأصناف
            'taxes' => $taxes,
            'users' => $users,

            // الكود في الـ Blade يستخدم $data فقط، لذا لا داعي لتمرير $purchase_invoice
            // 'purchase_invoice' => $data
        ]);
    }

    public function invoice_table(Request $request){
        // 1. جلب مودل الفاتورة (كائن واحد)
        $invoice_model = PurchaseInvoicesModel::where('id',$request->invoice_id)->first();

        // 2. جلب مصفوفة الأصناف (مجموعة)
        $items_collection = InvoiceItemsModel::where('invoice_id',$request->invoice_id)->get();

        foreach($items_collection as $key){
            $key->product = ProductModel::where('id',$key->item_id)->first();
        }

        $invoice_model->tax = TaxesModel::where('id',$invoice_model->tax_id)->first();

        // ===================================================
        // !! هذا هو السطر الذي تم تصحيحه !!
        // قمنا بتبديل المتغيرات لتطابق ملف الـ Blade
        // ===================================================
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.accounting.sales_invoices.invoices.ajax.invoices_table',[
                'data'    => $invoice_model,     // $data هو مودل الفاتورة
                'invoice' => $items_collection   // $invoice هي مصفوفة الأصناف
            ])->render(),
        ]);
    }

    public function search_product_ajax(Request $request){
        $data = ProductModel::where('product_name_ar','like','%'.$request->search_product.'%')->whereNotIn('id',function($query) use($request){
            $query->select('item_id')->from('bfo_invoice_items')->where('invoice_id',$request->invoice_id)->get();
        })->paginate(7);
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.accounting.sales_invoices.invoices.ajax.search_product',['data'=>$data])->render(),
        ]);
    }

    public function create_product_ajax(Request $request){
        $data = new InvoiceItemsModel();
        $data->item_id = $request->item_id;
        // $data->quantity = $request->quantity;
        // $data->unit_type = $request->unit_type;
        // $data->rate = 200;
        $data->invoice_id = $request->invoice_id;
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

    // انشاء فاتورة من عرض سعر
    public function create_purchase_invoices_from_order(Request $request){

        // return $request;
        $order = OrdersSalesModel::findOrFail($request->order_id);

        $invoices = $order->getInvoices;

        if ($invoices->isEmpty() || $order->order_status == 'ready') {

            $data = new PurchaseInvoicesModel();
//        $order = OrderModel::where('id',$request->order_id)->first();
//        $data->invoice_reference_number = $request->order_id ?? $request->price_offer_sales_id;
            $data->invoice_reference_number = 'INV-S-' . session()->get('login_date') . '-' . (PurchaseInvoicesModel::get()->last()->id + 1);
            $data->price_offer_sales_id = $request->price_offer_sales_id;
            $data->bill_date = Carbon::now()->toDateString();
            $data->due_date = Carbon::now()->toDateString();
            $data->client_id = $request->supplier_user_id;
            $data->invoice_type = 'sales';
            $data->order_id = $request->order_id;
            $data->currency_id = $request->currency_id;
            // $order_itmes = OrdersSalesItemsModel::where('order_id',$request->order_id)->get();
            if($data->save()){
                foreach($request->select_items as $key){
                    $order_itmes = OrdersSalesItemsModel::where('order_id',$request->order_id)->where('id',$key)->first();
                    $invoice_items = new InvoiceItemsModel();
                    $invoice_items->quantity = $order_itmes->qty ?? 0;
                    $invoice_items->rate = $order_itmes->price ?? 0;
                    $invoice_items->invoice_id = $data->id;
                    $invoice_items->item_id = $order_itmes->product_id;
                    $invoice_items->save();
                }
                return redirect()->route('accounting.sales_invoices.invoice_view',['id'=>$data->id])->with(['success'=>'تم انشاء الفاتورة بنجاح']);
            }

        }

        return 'هذه الطلبية بها فواتير مسبقا';


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
            $message = 'تم تعديل تاريخ الاستحقاق بنجاح';
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
        if($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>$message
            ]);
        }
    }

    public function search_order_ajax(Request $request){
        $data = OrdersSalesModel::where('user_id','like','%'.$request->supplier_id.'%')->get();
        foreach ($data as $key){
            $key->client = User::where('id',$key->user_id)->first();
            $key->currency = CurrencyModel::where('id',$key->currency)->first();
            $key->price_offers = PurchaseInvoicesModel::where('price_offer_sales_id',$key->id)->get();
        }
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.accounting.sales_invoices.ajax.search_order',['data'=>$data])->render(),
        ]);
//        $data = PriceOfferSalesModel::where('customer_id','like','%'.$request->supplier_id.'%')->get();
//        foreach ($data as $key){
//            $key->client = User::where('id',$key->customer_id)->first();
//            $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
//            $key->price_offers = PurchaseInvoicesModel::where('price_offer_sales_id',$key->id)->get();
//        }
//        return response()->json([
//            'success'=>'true',
//            'view'=>view('admin.accounting.sales_invoices.ajax.search_order',['data'=>$data])->render(),
//        ]);
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

    public function update_tax_id_ratio(Request $request) {

        // البحث عن الفاتورة
        $data = PurchaseInvoicesModel::find($request->id);

        if (!$data) {
            return response()->json([
                'status' => 'false',
                'message' => 'الفاتورة غير موجودة'
            ], 404);
        }

        // تحديث البيانات
        $data->tax_id = $request->tax_id;
        $data->tax_type = $request->tax_type; // حفظ نوع الضريبة

        if ($data->save()) {
            return response()->json([
                'status' => 'true',
                'message' => 'تم تعديل بيانات الضريبة بنجاح'
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'هناك خطأ ما، لم يتم الحفظ'
            ]);
        }
    }

    //TODO ترحيل الفاتورة
    public function invoice_posting($id)
{
    $data = PurchaseInvoicesModel::where('id', $id)->first();

    // تغيير حالة الفاتورة
    $data->status = 'stage';

    // إنشاء كائن جديد لمبلغ الوثيقة
    $doc_amount = new DocAmountModel();
    $doc_amount->type = 'sales';
    $doc_amount->invoice_id = $id;
    $doc_amount->reference_number = $data->invoice_reference_number;
    $doc_amount->notes = $data->note;

    // حساب المبلغ مع الأخذ في الاعتبار الخصومات الفارغة
    $totalAmountWithDiscounts = InvoiceItemsModel::where('invoice_id', $id)
        ->sum(DB::raw('rate * quantity * (1 - (discount / 100))'));

    $totalAmountWithoutDiscounts = InvoiceItemsModel::where('invoice_id', $id)
        ->whereNull('discount')
        ->sum(DB::raw('rate * quantity'));

    // إضافة المبالغ المحسوبة
    $doc_amount->amount = $totalAmountWithDiscounts + $totalAmountWithoutDiscounts;

    // حفظ بيانات المبلغ
    $doc_amount->client_id = $data->client_id;
    $doc_amount->currency = $data->currency_id;
    $doc_amount->save();

    // حفظ حالة الفاتورة
    if ($data->save()) {
        return redirect()->route('accounting.sales_invoices.invoice_view', ['id' => $id])
            ->with(['success' => 'تم ترحيل الفاتورة بنجاح']);
    } else {
        return redirect()->route('accounting.sales_invoices.invoice_view', ['id' => $id])
            ->with(['fail' => 'هناك خلل ما لم يتم ترحيل الفاتورة']);
    }
}

    public function sales_invoice_pdf(Request $request){
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
        $pdf = PDF::loadView('admin.accounting.sales_invoices.invoices.pdf.sales_invoice',['data'=>$data,'invoice'=>$invoice,'total'=>$total,'final_total'=>$final_total,'system_setting'=>$system_setting,'request'=>$request]);
        return $pdf->stream('sales_invoice.pdf');
    }

    public function archive_order(){
        $data = PurchaseInvoicesModel::where('deleted',1)->where('invoice_type','sales')->get();
        return view('admin.accounting.sales_invoices.archive.index',['data'=>$data]);
    }

    public function restore_invoices($id){
        $data = PurchaseInvoicesModel::find($id);
        $data->deleted = 0;
        if($data->save()){
            return redirect()->route('accounting.sales_invoices.archive_order')->with(['success'=>'تم استرجاع البيانات بنجاح']);
        }
        else{
            return redirect()->route('accounting.sales_invoices.archive_order')->with(['fail'=>'هناك خطا ما لم يتم استرجاع البيانات بنجاح']);
        }
    }
}
