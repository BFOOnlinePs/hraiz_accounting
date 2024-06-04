<table class="table table-sm table-bordered table-hover">
    <thead>
    <tr>
        <th>المنتج المجمع</th>
        <th>العمليات</th>
    </tr>
    </thead>
    <tbody>
    @if($data->isEmpty())
        <tr>
            <td colspan="5" class="text-center">لا توجد بيانات</td>
        </tr>
    @else
        @foreach($data as $key)
            <tr>
                <td>
                    {{ $key->product->product_name_ar }}
                </td>
                <td>
                    <a href="{{ route('product.edit_assembled_product',['id'=>$key->id]) }}" class="btn btn-success btn-sm"><span class="fa fa-edit"></span></a>
                    <button onclick="delete_assembled_product_ajax({{ $key->id }})" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
