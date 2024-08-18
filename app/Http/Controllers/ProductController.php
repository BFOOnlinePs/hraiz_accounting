<?php

namespace App\Http\Controllers;
use App\Imports\UsersImport;
use App\Models\AssembledProductModel;
use App\Models\CategoryProductModel;
use App\Models\ProducationLinesModel;
use App\Models\ProductCompatibilityModel;
use App\Models\ProductModel;
use App\Models\ProductSupplierModel;
use App\Models\UnitsModel;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
//use Barryvdh\DomPDF\Facade as PDF;
use PDF;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home(){
        $product_count = ProductModel::count();
        $category_count = CategoryProductModel::count();
        $unit_count = UnitsModel::count();
        return view('admin.product.home',['product_count'=>$product_count,'category_count'=>$category_count,'unit_count'=>$unit_count]);
    }

    public function index(){
        $product_count = ProductModel::count();
        $category_count = CategoryProductModel::count();
        $unit_count = UnitsModel::count();
        $data = ProductModel::paginate(20);
        $products = ProductModel::get();
        foreach ($data as $key){
            $key->category = CategoryProductModel::where('id',$key->category_id)->first();
            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
        }
        $category = CategoryProductModel::get();
        $unit = UnitsModel::get();
        return view('admin.product.index',['data'=>$data,'category'=>$category,'unit'=>$unit,'product_count'=>$product_count,'category_count'=>$category_count,'unit_count'=>$unit_count,'products'=>$products]);
    }

    public function search_table(Request $request){
        $data = ProductModel::where(function ($query) use ($request) {
            $query->where('product_name_ar', 'like', "%{$request->product_search}%")
                ->orWhere('product_name_en', 'like', "%{$request->product_search}%")
                ->orWhere('barcode', 'like', "%{$request->product_search}%");
        })
            ->when($request->filled('category_selected_id'), function ($query) use ($request) {
                $query->where('category_id', $request->category_selected_id);
            })
            ->when($request->filled('units_selected_id'), function ($query) use ($request) {
                $query->where('unit_id', $request->units_selected_id);
            })
            ->paginate(8);
        foreach ($data as $key){
            $key->category = CategoryProductModel::where('id',$key->category_id)->first();
            $key->unit = UnitsModel::where('id',$key->unit_id)->first();
        }
//        if ($request->ajax()) {
//            $data = ProductModel::where('product_name_ar','like',"%{$request->product_search}%")->orWhere('product_name_en','like',"%{$request->product_search}%")->orWhere('barcode','like',"%{$request->product_search}%")->paginate(8);
//            foreach ($data as $key){
//                $key->category = CategoryProductModel::where('id',$key->category_id)->first();
//                $key->unit = UnitsModel::where('id',$key->unit_id)->first();
//            }
//            return response()->view('admin.product.ajax.search_product',['data'=>$data]);
//        }
        return response()->view('admin.product.ajax.search_product',['data'=>$data]);
    }

    public function create(Request $request){
        $data = new ProductModel();
        $data->product_name_ar = $request->product_name_ar;
        $data->product_name_en = $request->product_name_en;
        $data->product_name_he = $request->product_name_he;
        $data->category_id = $request->category_id;
        $data->unit_id = $request->unit_id;
        $data->barcode = $request->barcode;
        $data->certified = $request->certified;
        $data->less_qty = $request->less_qty;
        $data->product_status = 1;
        $data->product_price = $request->product_price;
        $data->weight = $request->weight;
        $data->height = $request->height;
        $data->cost_price = $request->cost_price;
        $data->min_sale_price = $request->min_sale_price;
        $data->color = $request->color;
        $data->assembled_product = ($request->assembled_product) ? '1' : '0';
        if ($request->hasFile('product_photo')) {
            $file = $request->file('product_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('product', $filename, 'public');
            $data->product_photo = $filename;
        }
        if ($data->save()){
            if (!empty($request->assembled_product)){
                foreach ($request->assembled_product as $key){
                    $assembled_product = new AssembledProductModel();
                    $assembled_product->product_id = $data->id;
                    $assembled_product->assembled_product = $key;
                    $assembled_product->save();
                }
            }
            return redirect()->route('product.index')->with(['success'=>'تم اضافة البيانات بنجاح']);
        }
        else{
            return redirect()->route('product.index')->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات']);
        }
    }

    public function edit($id){
        $data = ProductModel::find($id);
        $data['category'] = CategoryProductModel::where('id',$data->category_id)->first();
        $data['unit'] = UnitsModel::where('id',$data->unit_id)->first();
        $category = CategoryProductModel::get();
        $units = UnitsModel::get();
        return view('admin.product.edit',['data'=>$data,'category'=>$category,'units'=>$units]);
    }

    public function update($id,Request $request){
        $data = ProductModel::find($id);
        $data->product_name_ar = $request->product_name_ar;
        $data->product_name_en = $request->product_name_en;
        $data->product_name_he = $request->product_name_he;
        $data->category_id = $request->category_id;
        $data->unit_id = $request->unit_id;
        $data->barcode = $request->barcode;
        $data->certified = $request->certified;
        $data->less_qty = $request->less_qty;
        $data->weight = $request->weight;
        $data->height = $request->height;
        $data->cost_price = $request->cost_price;
        $data->min_sale_price = $request->min_sale_price;
        $data->color = $request->color;
        $data->assembled_product = ($request->assembled_product) ? '1' : '0';
        if ($request->hasFile('product_photo')) {
            $file = $request->file('product_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('product', $filename, 'public');
            $data->product_photo = $filename;
        }
        if ($request->product_status == 'on'){
            $data->product_status = 1;
        }
        else{
            $data->product_status = 0;
        }
        $data->product_price = $request->product_price;
        if ($data->save()){
//            foreach ($request->assembled_product as $key){
//                $assembled_product = AssembledProductModel::firstOrNew(['product_id'=>$id,'assembled_product'=>$request->assembled_product]);
//                $assembled_product->product_id = $data->id;
//                $assembled_product->assembled_product = $key;
//                $assembled_product->save();
//            }
            return redirect()->route('product.details',['id'=>$data->id])->with(['success'=>'تم تعديل المنتج بنجاح','tab_id'=>1]);
        }
        else{
            return redirect()->route('product.details',['id'=>$data->id])->with(['fail'=>'هناك خلل ما لم يتم تعديل البيانات','tab_id'=>1]);
        }
    }

    public function import(Request $request)
    {
        Excel::import(new UsersImport, $request->file('file'));
        return redirect()->route('product.index')->with('success', 'تم اضافة البيانات بنجاح');
    }

    public function details($id){
        // TODO this for product supplier table
            $supplier = User::whereJsonContains('user_role',['4'])->whereNotIn('id',function ($query) use ($id){
                $query->select('user_id')->from('product_supplier')->where('product_id',$id)->get();
            })->get();
        // *********
        $data = ProductModel::find($id);
        $data['category'] = CategoryProductModel::where('id',$data->category_id)->first();
        $data['unit'] = UnitsModel::where('id',$data->unit_id)->first();
        $category = CategoryProductModel::get();
        $units = UnitsModel::get();
        $data['product_supplier'] = ProductSupplierModel::where(['product_id'=>$data->id])->get();
        foreach ($data['product_supplier'] as $key){
            $key->user = User::where('id',$key->user_id)->first();
        }
        $product_compatibility = ProductCompatibilityModel::where('product_id',$id)->get();

        $products = ProductModel::whereNotIn('id',function ($query){
            $query->select('product_compatibility_id')->from('product_compatibility')->get();
        })->get();
        foreach ($product_compatibility as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
            $key->product_compatibility = ProductModel::where('id',$key->product_compatibility_id)->first();
        }
        $assembled_product = AssembledProductModel::where('product_id',$id)->get();
        foreach ($assembled_product as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        $production_lines = ProducationLinesModel::where('product_id',$id)->get();
        foreach ($production_lines as $key){
            $key->product = ProductModel::where('id',$key->product_id)->first();
        }
        return view('admin.product.details',['data'=>$data,'category'=>$category,'units'=>$units,'supplier'=>$supplier,'product_compatibility'=>$product_compatibility,'products'=>$products,'assembled_product'=>$assembled_product,'production_lines'=>$production_lines]);
    }

    public function createForProductSupplier(Request $request){
        $if_found = ProductSupplierModel::where(['user_id'=>$request->user_id,'product_id'=>$request->product_id])->first();
        if ($if_found){
            return redirect()->route('product.details',['id'=>$request->product_id])->with(['fail'=>'هذا المورد او الشركة مسجل من قبل']);
        }
        else{
            $data = new ProductSupplierModel();
            $data->user_id = $request->user_id;
            $data->product_id = $request->product_id;
            if ($data->save()){
                return redirect()->route('product.details',['id'=>$request->product_id])->with(['success'=>'تم اضافة المورد او الشركة بنجاح','tab_id'=>2]);
            }
            else{
                return redirect()->route('product.details',['id'=>$request->product_id])->with(['fail'=>'هناك خلل ما لم تتم اضافة البيانات بنجاح','tab_id'=>2]);
            }
        }
    }

    public function edit_product_ajax(Request $request){
        $data = ProductModel::where('id',$request->product_id)->first();
        if ($data->product_name_ar == ''){
            $data->product_name_ar = $request->product_name_ar;
        }
        $data->product_name_en = $request->product_name_en;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'data'=>$data,
            ]);
        }
    }

    public function delete_image(Request $request){
        $data = ProductModel::where('id',$request->product_id)->first();
        $data->product_photo = null;
        if($data->save()){
            return 'asd';
        }
    }

    public function qrCode_product($id){
        $data = ProductModel::where('id',$id)->first();
        $pdf = PDF::loadView('admin.product.pdf.qrcode_product', ['data' => $data],[],['format' => [80,30]]);
        return $pdf->stream('qr_code_product.pdf');
    }

    public function create_product_compatibility(Request $request){
        $data = new ProductCompatibilityModel();
        $data->product_id = $request->product_id;
        $data->product_compatibility_id = $request->product_compatibility_id;
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('product', $filename, 'public');
            $data->product_image = $filename;
        }
        $data->notes = $request->notes;
        if ($data->save()){
            return redirect()->route('product.details',['id'=>$request->product_id])->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>3]);
        }
        else{
            return redirect()->route('product.details',['id'=>$request->product_id])->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات','tab_id'=>3]);
        }
    }

    public function edit_product_compatibility($id){
        $data = ProductCompatibilityModel::where('id',$id)->first();
        $data->product = ProductModel::where('id',$data->product_id)->first();
        $data->product_compatibility = ProductModel::where('id',$data->product_compatibility_id)->first();
        $products = ProductModel::get();
        return view('admin.product.edit_product_compatibility',['data'=>$data,'products'=>$products]);
    }

    public function update_product_compatibility(Request $request){
        $data = ProductCompatibilityModel::where('id',$request->product_id)->first();
        $data->product_id = $request->product_id;
        $data->product_compatibility_id = $request->product_compatibility_id;
        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->storeAs('product', $filename, 'public');
            $data->product_image = $filename;
        }
        $data->notes = $request->notes;
        if ($data->save()){
            return redirect()->route('product.details',['id'=>$data->product_id])->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>3]);
        }
        else{
            return redirect()->route('product.details',['id'=>$data->product_id])->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات','tab_id'=>3]);
        }
    }

    public function create_assembled_product_ajax(Request $request){
        $data = new AssembledProductModel();
        $data->product_id = $request->product_id;
        $data->assembled_product = $request->assembled_product;
        if ($data->save()){
            return response()->json([
                'success'=>'true'
            ]);
        }
    }

    public function edit_assembled_product($id){
        $data = AssembledProductModel::where('id',$id)->first();
        $data['assembled_product'] = ProductModel::where('id',$data->assembled_product)->first();
        $products = ProductModel::get();
        return view('admin.product.edit_assembled_product',['data'=>$data,'products'=>$products]);
    }

    public function search_assembled_product_ajax(Request $request){
        $data = ProductModel::whereNotIn('id',function ($query) use ($request){
            $query->select('assembled_product')->from('assembled_product')->where('product_id',$request->product_id)->get();
        })->where('product_name_ar','like','%'.$request->search_input_assembled_product.'%')->paginate(10);
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.product.ajax.search_assembled_product_ajax',['data'=>$data])->render(),
        ]);
    }

    public function list_assembled_product_ajax(Request $request){
        $data = AssembledProductModel::where('product_id',$request->product_id)->get();
        foreach ($data as $key){
            $key->product = ProductModel::where('id',$key->assembled_product)->first();
        }
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.product.ajax.list_assembled_product',['data'=>$data])->render(),
        ]);

    }

    public function delete_assembled_product_ajax(Request $request){
        $data = AssembledProductModel::where('id',$request->id)->first();
        if ($data->delete()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم حذف البيانات بنجاح'
            ]);
        }
        else{
            return response()->json([
                'success'=>'false',
                'message'=>'هناك خلل لم يتم حذف البيانات'
            ]);
        }
    }

    public function update_assembled_product(Request $request){
        $data = AssembledProductModel::where('id',$request->id)->first();
        $data->assembled_product = $request->assembled_product;
        if ($data->save()){
            return redirect()->route('product.details',['id'=>$data->product_id])->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>3]);
        }
        else{
            return redirect()->route('product.details',['id'=>$data->product_id])->with(['fail'=>'لم يتم تعديل البيانات هناك خلل ما','tab_id'=>4]);
        }
    }

    public function assembled_product_list_for_details_in_product_ajax(Request $request){
        $data = AssembledProductModel::where('product_id',$request->product_id)->get();
        return response()->json([
            'success'=>'true',
            'view'=>view('admin.product.ajax.assembled_product_list_for_details_in_product_ajax',['data'=>$data]),
        ]);
    }

    public function assembled_product_create_for_details_in_product_ajax(){
        $data = new AssembledProductModel();
        $data->product_id = $http_response_header->product_id;
        $data->assembled_product = $http_response_header->assembled_product;
        if ($data->save()){
            return response()->json([
                'success'=>'true',
                'message'=>'تم اضافة البيانات بنجاح'
            ]);
        }
    }

    public function product_lines_create(Request $request){
        $data = new ProducationLinesModel();
        $data->production_name = $request->production_name;
        if ($request->hasFile('production_image')) {
            $file = $request->file('production_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('production', $filename, 'public');
            $data->production_image = $filename;
        }
        $data->production_notes = $request->production_notes;
        $data->product_id = $request->product_id;
        $data->production_output_count = $request->production_output_count;
        if ($data->save()){
            return redirect()->route('product.details',['id'=>$request->product_id])->with(['success'=>'تم اضافة البيانات بنجاح','tab_id'=>5]);
        }
        else{
            return redirect()->route('product.details',['id'=>$request->product_id])->with(['fail'=>'هناك خلل ما لم يتم اضافة البيانات','tab_id'=>5]);
        }
    }
}
