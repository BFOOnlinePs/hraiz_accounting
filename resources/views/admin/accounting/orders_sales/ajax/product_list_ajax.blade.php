<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th>الباركود</th>
            <th>الصنف</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>العمليات</th>
        </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <tr>
                <td colspan="3" class="text-center">لا يوجد بيانات</td>
            </tr>
        @else
            @foreach($data as $key)
                <tr>
                    <td>{{ $key->barcode }}</td>
                    <td>{{ $key->product_name_ar }}</td>
                    <td style="width: 10%">
                        <input name="qty" class="form-control" type="number" value="1" min="1">
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm" onclick="create_orders_sales_items({{ $key->id }}, $(this).closest('tr').find('input[name=qty]').val())"><span class="fa fa-plus"></span></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $data->links() }}
