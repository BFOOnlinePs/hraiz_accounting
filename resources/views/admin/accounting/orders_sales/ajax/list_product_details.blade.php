<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <th>الصنف</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>العمليات</th>
        </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <tr>
                <td colspan="4" class="text-center">لا توجد اصناف</td>
            </tr>
        @else
            @foreach($data as $key)
                <tr>
                    <td>{{ $key->product->product_name_ar }}</td>
                    <td><input type="number" onchange="update_orders_sales_items({{ $key->id }} ,'qty',this.value)" class="form-control" value="{{ $key->qty }}"></td>
                    <td><input type="number" onchange="update_orders_sales_items({{ $key->id }},'price',this.value)" class="form-control" value="{{ $key->price }}"></td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="delete_orders_sales_items({{ $key->id }})"><span class="fa fa-close"></span></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
