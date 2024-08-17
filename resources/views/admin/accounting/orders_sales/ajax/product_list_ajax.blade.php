<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th>الباركودس</th>
            <th>الصنف</th>
            <th>لصنف</th>
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
                    <td>
                        <button class="btn btn-success btn-sm" onclick="create_orders_sales_items({{ $key->id }})"><span class="fa fa-plus"></span></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $data->links() }}
