<div class="table-responsive">
  <table style="width:100%" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>صورة</th>
            <th>باركود</th>
            <th>اسم الصنف</th>
            <th>اسم الصنف EN</th>
            <th>المجموعة</th>
            <th>الوحدة</th>
{{--            <th>باركود الصنف</th>--}}
{{--            <th>باركود الصنف</th>--}}
            <th>حالة الصنف</th>
            <th>العمليات</th>
        </tr>
    </thead>
    <tbody id="tableBody">
    @if(!$data->isEmpty())
        @foreach ($data as $key)
            <tr>
                <td>
                    @if (empty($key->product_photo))
                        <img src="{{ asset('img/no_img.jpeg') }}" width="50" alt="">
                    @else
                        <span class="mytooltip tooltip-effect-1">
                                <span class="tooltip-item"
                                      style='width: 65px;height: 50px;background-image: url("{{ asset('storage/product/' . $key->product_photo) }}");background-size: contain;background-repeat: no-repeat;background-position: center'>

                                </span>
                                <span class="tooltip-content clearfix">
                                    <img src="{{ asset('storage/product/' . $key->product_photo) }}">
                                </span>
                            </span>
                    @endif
                </td>
                <td>
                    {{ $key->barcode }}
                </td>
                <td>
                    <input onchange="edit_product_ajax({{ $key->id }})"
                           id="product_name_ar_{{ $key->id }}" class="form-control" type="text"
                           value="{{ $key->product_name_ar }}">
                </td>
                <td>
                    <input onchange="edit_product_ajax({{ $key->id }})"
                           id="product_name_en_{{ $key->id }}" class="form-control" type="text"
                           value="{{ $key->product_name_en }}">
                </td>
                <td>
                    @if (!empty($key['category']->cat_name))
                        {{ $key['category']->cat_name }}
                    @endif
                </td>
                <td>{{ $key['unit']->unit_name }}</td>
                {{--                    <td>--}}
                {{--                        {!! QrCode::size(100)->generate($key->barcode); !!}--}}
                {{--                        {!! DNS2D::getBarcodeHTML($key->barcode, 'QRCODE'); !!}--}}

                {{--                        --}}{{--                        {{ $key->barcode }}--}}
                {{--                    </td>--}}
                <td>
                    @if ($key->product_status)
                        <small class="badge btn-success">فعال</small>
                    @else
                        <small class="badge badge-danger">غير فعال</small>
                    @endif
                </td>
                <td>
                    {{--                        <a href="{{ route('product.edit', ['id' => $key->id]) }}"--}}
                    {{--                            class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>--}}
                    <a href="{{ route('product.details', ['id' => $key->id]) }}"
                       class="btn btn-dark btn-sm"><span class="fa fa-search"></span></a>
                    {{--                        <a target="_blank" href="{{ route('product.qrCode_product',['id' => $key->id]) }}" class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a>--}}
                    <a href="{{  route('reports.products.product_pdf',['product_id'=>$key->id]) }}" class="btn btn-sm btn-info"><span class="fa fa-print"></span></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="8" class="text-center">لا توجد نتائج</td>
        </tr>
    @endif
    </tbody>
</table>
<div id="paginationLinks">
    {{ $data->links() }}
</div>
