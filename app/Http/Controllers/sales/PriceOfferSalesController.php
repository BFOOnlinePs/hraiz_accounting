<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use App\Models\CurrencyModel;
use App\Models\PriceOfferSalesItemsModel;
use App\Models\PriceOfferSalesModel;
use App\Models\ProductModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use function Termwind\render;
use PDF;

class PriceOfferSalesController extends Controller
{
    public function index(){
        $data = PriceOfferSalesModel::get();
        foreach ($data as $key){
            $key->user = User::where('id',$key->customer_id)->first();
            $key->insert_by_user = User::where('id',$key->insert_by)->first();
            $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
        }
        $clients = User::whereJsonContains('user_role','10')->orwhereJsonContains('user_role','4')->get();
        $added_by = User::whereJsonContains('user_role','1')->orWhereJsonContains('user_role','2')->get();
        $currency = CurrencyModel::get();
        return view('admin.sales.price_offer_sales.index',['data'=>$data,'clients'=>$clients,'currency'=>$currency,'added_by'=>$added_by]);
    }

    public function create(Request $request){
        $data = new PriceOfferSalesModel();
        $data->customer_id = $request->customer_id;
        $data->insert_at = Carbon::now();
        $data->insert_by = auth()->user()->id;
        $data->notes = $request->notes;
        $data->currency_id = $request->currency_id;
        if ($data->save()){
            return redirect()->route('price_offer_sales.price_offer_sales_items.price_offer_sales_items_index',['id'=>$data->id])->with(['success'=>'تم اضافة عرض السعر بنجاح']);
        }
        else{
            return redirect()->route('price_offer_sales.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة عرض السعر بنجاح']);
        }
    }
    public function edit($id){
        $data = PriceOfferSalesModel::where('id',$id)->first();
        $clients = User::whereJsonContains('user_role','10')->get();
        $currency = CurrencyModel::get();
        return view('admin.sales.price_offer_sales.edit',['data'=>$data,'clients'=>$clients,'currency'=>$currency]);
    }

    public function update(Request $request){
        $data = PriceOfferSalesModel::where('id',$request->id)->first();
        $data->customer_id = $request->customer_id;
        $data->insert_at = Carbon::now();
        $data->insert_by = auth()->user()->id;
        $data->notes = $request->notes;
        $data->currency_id = $request->currency_id;
        if ($data->save()){
            return redirect()->route('price_offer_sales.index')->with(['success'=>'تم تعديل البيانات بنجاح']);
        }
        else{
            return redirect()->route('price_offer_sales.index')->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات']);
        }
    }

    public function price_offer_sales_items_index($id){
        $data = PriceOfferSalesItemsModel::where('price_offer_sales_id',$id)->get();
        $price_offer_sales = PriceOfferSalesModel::find($id);
        $price_offer_sales['user'] = User::where('id',$price_offer_sales->customer_id)->first();
        $price_offer_sales['currency'] = CurrencyModel::where('id',$price_offer_sales->currency_id)->first();
        $currency = CurrencyModel::get();
        $client = User::whereJsonContains('user_role',['10'])->orWhereJsonContains('user_role',['4'])->get();
        return view('admin.sales.price_offer_sales.price_offer_sales_items.index',['data'=>$data,'price_offer_sales'=>$price_offer_sales,'currency'=>$currency , 'client'=>$client]);
    }

    public function price_offer_sales_items_table_ajax(Request $request){
        $data = PriceOfferSalesItemsModel::where('price_offer_sales_id',$request->price_offer_sales_id)->get();
        $sum = PriceOfferSalesItemsModel::where('price_offer_sales_id',$request->price_offer_sales_id)->sum(DB::raw('qty * price'));
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.sales.price_offer_sales.price_offer_sales_items.ajax.price_offer_sales_items_table',['data'=>$data,'sum'=>$sum])->render(),
        ]);
    }

    public function product_list_search(Request $request){
        $data = ProductModel::where('product_name_ar','like','%'.$request->product_search.'%')->orWhere('barcode','like','%'.$request->product_search.'%')->whereNotIn('id',function ($query) use ($request){
            $query->select('product_id')->from('price_offer_sales_item')->where('price_offer_sales_id',$request->price_offer_sales_id)->get();
        })->paginate(8);
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.sales.price_offer_sales.price_offer_sales_items.ajax.product_list_search',['data'=>$data])->render()
        ]);
    }

    public function create_price_offer_sales_items_ajax(Request $request){
        $data = new PriceOfferSalesItemsModel();
        $data->price_offer_sales_id = $request->price_offer_sales_id;
        $data->product_id = $request->product_id;
        $data->qty = 0;
//        $data->qty = ProductModel::where('id',$request->product_id)->first()->less_qty;
        $data->price = ProductModel::where('id',$request->product_id)->first()->product_price;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم اضافة المنتج بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خلل ما لم يتم اضافة المنتج بنجاح'
            ]);
        }
    }

    public function delete_price_offer_sales_items(Request $request){
        $data = PriceOfferSalesItemsModel::where('id',$request->id)->first();
        if ($data->delete()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم حذف الصنف بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'لم يتم حذف الصنف هناك خلل ما'
            ]);
        }
    }

    public function update_qty_price_price_offer_sales_items_ajax(Request $request){
        $data = PriceOfferSalesItemsModel::where('id',$request->id)->first();
        $message = '';
        if ($request->operation == 'qty'){
            $data->qty = $request->value;
            $message = 'تم تعديل الكمية بنجاح';
        }
        else if ($request->operation == 'price'){
            $data->price = $request->value;
            $message = 'تم تعديل السعر بنجاح';
        }
        else if ($request->operation == 'notes'){
            $data->notes = $request->value;
            $message = 'تم تعديل الملاحظة بنجاح';
        }
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>$message
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خلل ما لم يتم التعديل بنجاح'
            ]);
        }
    }

    public function price_offer_sales_items_pdf(Request $request){
        $data = PriceOfferSalesItemsModel::where('price_offer_sales_id',$request->id)->get();
        $sum = PriceOfferSalesItemsModel::where('price_offer_sales_id',$request->id)->sum(DB::raw('qty * price'));
        $price_offer_sales = PriceOfferSalesModel::where('id',$request->id)->first();
        $price_offer_sales['customer'] = User::where('id',$price_offer_sales->customer_id)->first();
        $price_offer_sales['currency'] = CurrencyModel::where('id',$price_offer_sales->currency_id)->first();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }

        $pdf = PDF::loadView('admin.sales.price_offer_sales.price_offer_sales_items.pdf.price_offer_sales_items', ['data' => $data,'sum'=>$sum,'price_offer_sales'=>$price_offer_sales,'language'=>$request->language],[]);
        return $pdf->stream('suppliers_report.pdf');
    }

    public function update_currency_notes_customer_for_price_offer_sales_items_ajax(Request $request){
        $data = PriceOfferSalesModel::where('id',$request->price_offer_sales_id)->first();
        if ($request->operation == 'currency'){
            $data->currency_id = $request->value;
            $message = 'تم تعديل العملة بنجاح';
        }
        else if ($request->operation == 'notes'){
            $data->notes = $request->value;
            $message = 'تم تعديل الملاحظات بنجاح';
        }
        else if ($request->operation == 'customer'){
            $data->customer_id = $request->value;
            $message = 'تم تعديل العميل بنجاح';
        }
        else{
            $message = 'هناك خلل ما لم يتم تعديل البيانات';
        }
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>$message
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>$message
            ]);
        }
    }

    public function get_sum_price_offer_sales_items_ajax(Request $request){
        $sum = PriceOfferSalesItemsModel::where('price_offer_sales_id',$request->price_offer_sales_id)->sum(DB::raw('qty * price'));
        return response()->json([
            'success'=>'true',
            'sum'=>$sum
        ]);
    }

    public function price_offer_sales_table_ajax(Request $request){
        $from = Carbon::parse($request->from)->subMonth();
        $to = $request->to;
        $data = PriceOfferSalesModel::where('customer_id', 'like', '%' . $request->customer_id . '%')
            ->where('insert_by', 'like', '%' . $request->insert_by . '%')->where('deleted',0)
            ->when(!empty($request->from) || !empty($request->to), function ($query) use ($request,$from,$to) {
                $query->when(!empty($request->from) && !empty($request->to), function ($query) use ($request) {
                    $query->whereBetween('insert_at', [
                        $request->from,
                        Carbon::parse($request->to)->addDays()
                    ]);
                })->when(empty($request->from) && !empty($request->to), function ($query) use ($from, $to) {
                    $query->whereBetween('insert_at', [
                        $from,
                        Carbon::parse($to)->addDays()
                    ]);
                });
            })->orderBy('id','desc')->get();
        foreach ($data as $key){
            $key->user = User::where('id',$key->customer_id)->first();
            $key->insert_by_user = User::where('id',$key->insert_by)->first();
            $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
        }
        $clients = User::whereJsonContains('user_role','10')->get();
        $currency = CurrencyModel::get();
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.sales.price_offer_sales.ajax.price_offer_sales_table',['data'=>$data,'clients'=>$clients,'currency'=>$currency])->render()
        ]);
    }

    public function price_offer_sales_items_table_display_for_order_sales(Request $request)
    {
        $data = PriceOfferSalesItemsModel::where('price_offer_sales_id',$request->price_offer_sales_id)->with('product')->get();
        return response()->json([
            'success'=>'true',
            'view' => view('admin.sales.price_offer_sales.price_offer_sales_items.ajax.price_offer_sales_product_table_found',['data'=>$data])->render()
        ]);
    }

    public function update_customer_ajax(Request $request){
        $data = PriceOfferSalesModel::where('id',$request->price_offer_sales_id)->first();
        $data->customer_id = $request->customer_id;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم تعديل العميل بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خلل ما لم يتم تعديل العميل'
            ]);
        }
    }

    public function archive_index(){
        $clients = User::whereJsonContains('user_role','10')->orwhereJsonContains('user_role','4')->get();
        $added_by = User::whereJsonContains('user_role','1')->orWhereJsonContains('user_role','2')->get();
        $currency = CurrencyModel::get();
        return view('admin.sales.price_offer_sales.archive.index',['clients'=>$clients , 'added_by'=>$added_by , 'currency'=>$currency]);
    }

    public function list_archive_ajax(Request $request){
        $from = Carbon::parse($request->from)->subMonth();
        $to = $request->to;
        $data = PriceOfferSalesModel::where('customer_id', 'like', '%' . $request->customer_id . '%')
            ->where('insert_by', 'like', '%' . $request->insert_by . '%')->where('deleted',1)
            ->when(!empty($request->from) || !empty($request->to), function ($query) use ($request,$from,$to) {
                $query->when(!empty($request->from) && !empty($request->to), function ($query) use ($request) {
                    $query->whereBetween('insert_at', [
                        $request->from,
                        Carbon::parse($request->to)->addDays()
                    ]);
                })->when(empty($request->from) && !empty($request->to), function ($query) use ($from, $to) {
                    $query->whereBetween('insert_at', [
                        $from,
                        Carbon::parse($to)->addDays()
                    ]);
                });
            })->orderBy('id','desc')->get();
        foreach ($data as $key){
            $key->user = User::where('id',$key->customer_id)->first();
            $key->insert_by_user = User::where('id',$key->insert_by)->first();
            $key->currency = CurrencyModel::where('id',$key->currency_id)->first();
        }
        $clients = User::whereJsonContains('user_role','10')->get();
        $currency = CurrencyModel::get();
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.sales.price_offer_sales.archive.ajax.list_archive',['data'=>$data,'clients'=>$clients,'currency'=>$currency])->render()
        ]);
    }

    public function add_to_archive($id){
        $data = PriceOfferSalesModel::where('id',$id)->first();
        $data->deleted = 1;
        if ($data->save()){
            return redirect()->route('price_offer_sales.index')->with(['success'=>'تم اضافة عرض السعر الى الارشيف بنجاح']);
        }
        else{
            return redirect()->route('price_offer_sales.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة عرض السعر الى الارشيف بنجاح']);
        }
    }

    public function remove_from_archive($id){
        $data = PriceOfferSalesModel::where('id',$id)->first();
        $data->deleted = 0;
        if ($data->save()){
            return redirect()->route('price_offer_sales.archive.archive_index')->with(['success'=>'تم حذف عرض السعر من الارشيف بنجاح']);
        }
        else{
            return redirect()->route('price_offer_sales.archive.archive_index')->with(['fail'=>'هناك خلل ما لم يتم حذف عرض السعر من الارشيف بنجاح']);
        }
    }
}
