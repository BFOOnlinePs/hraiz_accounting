<table class="table table-sm table-bordered table-hover">
    <thead class="bg-secondary">
    <tr>
        <th style="width: 40px"></th>
        <th>باركود</th>
        <th>اسم الصنف</th>
{{--        <th style="width: 100px">الكمية</th>--}}
        <th style="width: 100px">السعر</th>
{{--        <th>المجموع</th>--}}
        <th>الملاحظات</th>
        <th style="width: 10px">العمليات</th>
    </tr>
    </thead>
    <tbody>
    @if(!$data->isEmpty())
        @foreach($data as $key)
            <tr>
                <td>
                    @if(!empty($key->product->product_photo))
                        <img width="35px" src="{{ asset('storage/product/'.$key->product->product_photo) }}" alt="">
                    @else
                        <img width="35px" src="{{ asset('img/no_img.jpeg') }}" alt="">
                    @endif
                </td>
                <td class="text-center">{{ $key->product->barcode }}</td>
                <td>{{ $key->product->product_name_ar }}</td>
{{--                <td>--}}
{{--                    <input style="width: 80px;@if(!$key->qty == 0) background-color:palegoldenrod @endif;display: inline" class="form-control @if($key->qty == 0 || $key->qty == '') bg-danger @endif" onchange="update_qty_price_price_offer_sales_items_ajax({{ $key->id }},this.value,'qty')" type="text" value="{{ $key->qty }}">--}}
{{--                    <div id="loader_qty_{{ $key->id }}" style="display: none" class="col text-center"><i style="font-size: 16px" class="fas fa-3x fa-sync-alt fa-spin"></i></div>--}}
{{--                </td>--}}
                <td>
                    <input style="width: 80px;background-color:palegoldenrod" class="form-control @if($key->price == 0 || $key->price == '') bg-danger @endif" onchange="update_qty_price_price_offer_sales_items_ajax({{ $key->id }},this.value,'price')" type="text" value="{{ $key->price }}">
                    <div id="loader_price_{{ $key->id }}" style="display: none" class="col text-center"><i style="font-size: 16px" class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                </td>
{{--                <td class="text-center">--}}
{{--                    {{ $key->qty * $key->price }}--}}
{{--                </td>--}}
                <td>
                    <textarea onchange="update_qty_price_price_offer_sales_items_ajax({{ $key->id }},this.value,'notes')" name="" class="form-control" id="" cols="30" rows="1" placeholder="اكتب ملاحظة ...">{{ $key->notes }}</textarea>
                    <div id="loader_notes_{{ $key->id }}" style="display: none" class="col text-center"><i style="font-size: 16px" class="fas fa-3x fa-sync-alt fa-spin"></i></div>
                </td>
                <td>
                    <button onclick="delete_price_offer_sales_items({{ $key->id }})" class="btn btn-sm btn-danger"><span class="fa fa-close"></span></button>
                </td>
            </tr>
        @endforeach
{{--        <tr>--}}
{{--            <td colspan="5" class="text-center bg-secondary">المجموع</td>--}}
{{--            <td class="text-center" id="sum_items">{{ $sum }}</td>--}}
{{--            <td></td>--}}
{{--        </tr>--}}
    @else
        <tr>
            <td colspan="4" class="text-center">لا توجد بيانات</td>
        </tr>
    @endif
    </tbody>
</table>
