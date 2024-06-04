<table class="table table-sm table-hover table-bordered">
    <thead>
    <tr>
        <th>اسم المدخل</th>
        <th>العدد</th>
        <th>تكلفة الوحدة</th>
        <th>المجموع</th>
        <th>الوزن</th>
        <th>الطول</th>
        <th>الملاحظات</th>
        <th>العمليات</th>
    </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="10" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td><a href="{{ route('product.details',['id'=>$key->id]) }}">{{ $key->production_input_name }}</a></td>
                <td>
                    <input type="text" onchange="update_product_line_inputs_ajax({{$key->id}},'qty',this.value)" class="form-control" value="{{ $key->qty }}">
                </td>
                <td>
                    @if($key->product_id == -1)
                        <input type="text" onchange="update_product_line_inputs_ajax({{$key->id}},'estimated_cost',this.value)" class="form-control" value="{{ $key->estimated_cost }}">
                    @else
                        <input type="text" readonly class="form-control" value="{{ $key->estimated_cost }}">
                    @endif
                </td>
                <td>
                    @if($key->product_id == -1)
                        <input type="text" readonly class="form-control" value="{{ $key->estimated_cost * $key->qty }}">
                    @else
                        <input type="text" readonly class="form-control" value="{{ $key->product->cost_price * $key->qty }}">
                    @endif
                </td>
                <td>
                    <input type="text" readonly class="form-control" value="{{ $key->product->weight??'' }}">
                </td>
                <td>
                    <input type="text" readonly class="form-control" value="{{ $key->product->height??'' }}">
                </td>
                <td>
                    <input type="text" onchange="update_product_line_inputs_ajax({{$key->id}},'production_input_notes',this.value)" class="form-control" value="{{ $key->production_input_notes }}">
                </td>
                <td>
                    {{--                                            <a href="" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>--}}
{{--                    <a href="{{ route('production.production_inputs.production_input_delete',['id'=>$key->id]) }}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>--}}
                    <button onclick="delete_production_input_ajax({{ $key->id }})" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
