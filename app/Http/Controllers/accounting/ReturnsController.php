<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use App\Models\DocAmountModel;
use App\Models\InvoiceItemsModel;
use App\Models\ProductModel;
use App\Models\PurchaseInvoicesModel;
use App\Models\ReturnItemsModel;
use App\Models\ReturnsModel;
use App\Models\SystemSettingModel;
use App\Models\UnitsModel;
use App\Models\User;
use App\Models\WhereHouseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReturnsController extends Controller
{
    public function index(){
        $clients = User::whereJsonContains('user_role','10')->get();
        $data = ReturnsModel::get();
        foreach ($data as $key){
            $key->invoice = PurchaseInvoicesModel::where('id',$key->invoice_id)->first();
        }
        return view('admin.accounting.returns.index',['clients'=>$clients,'data'=>$data]);
    }

    public function get_invoices_for_client(Request $request){
        $data = PurchaseInvoicesModel::where('client_id',$request->client_id)->orderBy('id','desc')->get();
        return response()->json([
            'success' => 'true',
            'data' => $data
        ]);
    }

    public function get_invoice_items(Request $request){
        $data = InvoiceItemsModel::where('invoice_id',$request->invoice_id)->get();
        return response()->json([
            'success' => 'true',
            'data' => $data
        ]);
    }

    public function invoice_items_table(Request $request){
        $data = InvoiceItemsModel::where('invoice_id',$request->invoice_id)->get();

        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->item_id)->first();
            // $key->wherehouse = WhereHouseModel::where('id',$key->wherehouse_id)->first();
        }

        $wherehouses = WhereHouseModel::get();
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.returns.ajax.invoice_items',['data'=>$data,'wherehouses'=>$wherehouses])->render(),
        ]);
    }

    public function create_return(Request $request){
        $selectedProducts = $request->input('selected_products');
        $quantities = $request->input('quantities');
        $rates = $request->input('rates');
        $wherehouses = $request->input('wherehouses');
        $invoice = PurchaseInvoicesModel::where('id',$request->invoice_id)->first();
        $doc_amount = new DocAmountModel();
        $returns = new ReturnsModel();
        if ($request->returns_type_invoice == 'with_invoice'){
            $returns->invoice_id = $request->invoice_id;
        }
        else{
            $returns->invoice_id = -1;
        }
        $returns->notes = $request->notes;
        $returns->is_deleted = 'no';
        $returns->returns_type = $request->returns_type;
        $returns->save();

        if ($request->returns_type_invoice == 'with_invoice'){
            foreach ($selectedProducts as $index => $productId){
                $quantity = $quantities[$index];
                $rate = $rates[$index];
                // $wherehouse = $wherehouses[$index];
                $return_items = new ReturnItemsModel();
                $return_items->invoice_id = $returns->id;
                $return_items->product_id = $productId;
                $return_items->qty = $quantity;
                // $return_items->wherehouse_id = $wherehouse;
                if (!$return_items->save()){
                    return redirect()->route('accounting.returns.index')->with(['fail' => 'هناك خلل ما']);
                }
            }
        }
        return redirect()->route('accounting.returns.index')->with(['success' => 'تم اضافة البيانات بنجاح']);
    }

    public function product_table(Request $request){
        $returns = ReturnsModel::where('id',$request->return_id)->first();
        $query = ProductModel::query();
        $query->where(function ($query) use ($request){
            $query->where('product_name_ar','like','%'.$request->search_input.'%')
                ->orWhere('barcode','like','%'.$request->search_input.'%');
        })->whereNotIn('id',function ($query) use ($request){
            $query->select('product_id')->from('return_items')->where('invoice_id',$request->return_id);
        });

        if ($returns->invoice_id != -1){
            $query->whereIn('id',function ($query) use ($request){
                $query->select('item_id')->from('bfo_invoice_items')->where('invoice_id',$request->invoice_id);
            });

        }
        $data = $query->take(10)->get();
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.returns.ajax.product_table',['data'=>$data,'request'=>$request,'returns'=>$returns])->render()
        ]);
    }

    public function selected_product_from_search(Request $request){
        $data = new ReturnItemsModel();
        $data->invoice_id = $request->invoice_id;
        $data->product_id = $request->product_id;
        $data->qty = InvoiceItemsModel::where('invoice_id',$request->invoice_id)->where('item_id',$request->product_id)->first()->quantity ?? 0;
        if ($data->save()){
            return response()->json([
                'success' => 'true',
            ]);
        }
        else{
            return response()->json([
                'success' => 'false',
            ]);
        }
    }

    public function returns_details($id){
        $data = ReturnsModel::where('id',$id)->first();
        $data->invoice = PurchaseInvoicesModel::where('id',$data->invoice_id)->first();
        $return_items = ReturnItemsModel::where('invoice_id',$id)->get();
        return view('admin.accounting.returns.details',['return_items'=>$return_items,'data'=>$data]);
    }

    public function return_item_table(Request $request){
        $returns = ReturnsModel::where('id',$request->return_id)->first();
        $data = ReturnItemsModel::where('invoice_id',$request->return_id)->get();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
            $key->invoice_qty = InvoiceItemsModel::where('invoice_id',$returns->invoice_id)->where('item_id',$key->product_id)->first()->quantity ?? 0;
        }
        $wherehouses = WhereHouseModel::get();
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.returns.ajax.return_items_product',['data'=>$data , 'returns'=>$returns,'wherehouses'=>$wherehouses])->render(),
        ]);
    }

    public function remove_item_from_return_items(Request $request){
        $data = ReturnItemsModel::where('id',$request->id)->first();
        if ($data->delete()){
            return response()->json([
                'success' => 'true'
            ]);
        }
        else{
            return response()->json([
                'success' => 'false'
            ]);
        }
    }

    public function update_qty_from_return_items(Request $request){
        $data = ReturnItemsModel::where('id',$request->id)->first();
        $data->qty = $request->qty;
        if($data->save()){
            return response()->json([
                'success' => 'true',
                'message' => 'تم تعديل الكمية بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success' => 'false',
                'message' => 'هناك خلل ما لم يتم التعديل بنجاح'
            ]);
        }
    }

    //TODO ترحيل الفاتورة
    public function invoice_posting($id){
        $data = ReturnsModel::where('id',$id)->first();
        $invoice = PurchaseInvoicesModel::where('id',$data->invoice_id)->first();
        $data->status = 'stage';
        $doc_amount = new DocAmountModel();
        if ($data->returns_type == 'sales'){
            $doc_amount->type = 'return_sales';
        }
        if ($data->returns_type == 'purchases'){
            $doc_amount->type = 'return_purchase';
        }
        $doc_amount->invoice_id = $data->invoice_id;
        $doc_amount->reference_number = $invoice->invoice_reference_number;
        $record = ReturnItemsModel::select(
            DB::raw('SUM(return_items.qty * bfo_invoice_items.rate) as total_return_price')
        )
            ->where('returns.id',$id)
            ->join('returns', 'return_items.invoice_id', '=', 'returns.id')
            ->join('bfo_invoice_items', 'returns.invoice_id', '=', 'bfo_invoice_items.invoice_id')
            ->groupBy('returns.id') // Grouping by return.id to sum total_price for each return
            ->first();
        if ($record){
            $doc_amount->amount = $record->total_return_price;
        }
        else{
            return redirect()->back()->with(['fail'=>'يجب ان تحتوي على اصناف']);
        }

        $doc_amount->client_id = $invoice->client_id;
        $doc_amount->save();
        if ($data->save()){
            return redirect()->route('accounting.sales_invoices.invoice_view',['id'=>$id])->with(['success'=>'تم ترحيل الفاتورة بنجاح']);
        }
        else{
            return redirect()->route('accounting.sales_invoices.invoice_view',['id'=>$id])->with(['fail'=>'هناك خلل ما لم يتم ترحيل الفاتورة']);
        }
    }

    public function returns_table_ajax(Request $request){
//        radio_invoice_type
        $query = ReturnsModel::query();
        if ($request->radio_invoice_type == 'sales'){
            $query->where('returns_type','sales')->whereIn('invoice_id',function ($query) use ($request){
                $query->select('id')->from('bfo_invoices')->where('invoice_reference_number','like','%'.$request->reference_number.'%');
            });
        }
        if ($request->radio_invoice_type == 'purchase'){
            $query->where('returns_type','purchases')->whereIn('invoice_id',function ($query) use ($request){
                $query->select('id')->from('bfo_invoices')->where('invoice_reference_number','like','%'.$request->reference_number.'%');
            });
        }
        $data = $query->paginate(10);
        foreach ($data as $key){
            $key->invoice = PurchaseInvoicesModel::where('id',$key->invoice_id)->first();
        }
        return response()->json([
            'success' => 'true',
            'view' => view('admin.accounting.returns.ajax.returns_table',['data'=>$data])->render()
        ]);
    }

    public function returns_pdf($id){
        $system_setting = SystemSettingModel::first();
        $data = ReturnItemsModel::where('invoice_id',$id)->get();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
        }
        $return = ReturnsModel::where('id',$id)->first();
        $pdf = PDF::loadView('admin.accounting.returns.pdf.returns_pdf',['data'=>$data,'return'=>$return,'system_setting'=>$system_setting]);
        return $pdf->stream('returns.pdf');
    }

    public function update_wherehouse(Request $request){
        $data = ReturnItemsModel::where('id',$request->id)->first();
        $data->wherehouse_id = $request->wherehouse_id;
        if ($data->save()){
            return response()->json([
                'success' => 'true',
                'message' => 'تم تعديل المخزن بنجاح'
            ]);
        }
    }
}
